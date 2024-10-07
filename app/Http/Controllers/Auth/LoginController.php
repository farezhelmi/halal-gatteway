<?php

namespace App\Http\Controllers\Auth;

use App\Models\Sys\Roles;
use App\Models\Usr\Users;
use App\Mail\MailVerified;
use Illuminate\Support\Str;
use App\Models\Sys\Settings;
use Illuminate\Http\Request;
use App\Models\Sys\RoleUsers;
use App\Models\Log\Activities;
use App\Models\Usr\UserProfiles;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Providers\RouteServiceProvider;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    // use AuthenticatesUsers;

    public function showLoginForm()
    {
        $settings = Settings::where('id', '=', 1)->first();

        return view('auth.login', compact('settings'));
    }


    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            if ($request->hasSession()) {
                $request->session()->put('auth.password_confirmed_at', time());
            }
            
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        // $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }


    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
    }


    public function username()
    {
        return 'username';
    }


    protected function attemptLogin(Request $request)
    {
        return $this->guard()->attempt(
            $this->credentials($request), $request->boolean('remember')
        );
    }


    protected function guard()
    {
        return Auth::guard();
    }


    protected function credentials(Request $request)
    {
        return $request->only($this->username(), 'password');
        // $credentials = $request->only($this->username(), 'password');
        // $credentials['status_id'] = 1;
        // return $credentials;
    }


    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        // $this->clearLoginAttempts($request);

        if ($response = $this->authenticated($request, $this->guard()->user())) {
            return $response;
        }

        // Log Activity System *****************************************************
        $userLog = Users::find(Auth::id())->update(['login_at' => NOW(), 'login_last' => NOW()]);
        $user = Users::where('id', '=', Auth::id())->first();
        $logActivity = Activities::create([
            'user_id' => Auth::id(),
            'path' => '/login',
            'remarks' => 'Login : '.$user->username,
            'created_at' => NOW(),
        ]);
        // End Log Activity System *************************************************

        return $request->wantsJson()
                    ? new JsonResponse([], 204)
                    : redirect()->intended();
                    // : redirect()->intended($this->redirectPath());
    }


    protected function authenticated(Request $request, $user)
    {
        if ($user->status_id != 1) {
            Auth::logout();
            throw ValidationException::withMessages([
                $this->username() => 'Your account is already inactive'
            ]);
        }
    }


    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => 'Incorrect username or password',
            // $this->username() => [trans('auth.failed')],
        ]);
    }


    public function logout(Request $request)
    {
        // Log Activity System *****************************************************
        $userLog = Users::find(Auth::id())->update(['login_at' => null]);
        $user = Users::where('id', '=', Auth::id())->first();
        $logActivity = Activities::create([
            'user_id' => Auth::id(),
            'path' => '/logout',
            'remarks' => 'Logout : '.$user->username,
            'created_at' => NOW(),
        ]);
        // End Log Activity System *************************************************

        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect('/');
    }

    
    protected function loggedOut(Request $request)
    {
        //
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    public function forgotPassword()
    {
        $settings = Settings::where('id', '=', 1)->first();

        return view('auth.forgot-password', compact('settings'));
    }

    public function registerAccount()
    {
        $settings = Settings::where('id', '=', 1)->first();
        $roles = Roles::whereIn('id',[3,4])->orderBy('id', 'ASC')->get();

        return view('auth.register-account', compact('settings','roles'));
    }

    public function success()
    {
        return 'success';
    }

    public function error()
    {
        return 'error';
    }

    public function registerStore(Request $request)
    {
        try
        {
            $token = Str::random(12);
            $user = Users::create([
                'username' => $request->email,
                'email' => $request->email,
                'password' => Hash::make($token),
                'role_id' => $request->role_id,
                'status_id' => 2,
                'email_verified' => null,
                'token' => $token,
                'created_at' => NOW(),
                'created_by' => 0,
            ]);

            $phone_mobile = $request->phone_mobile;
            if($phone_mobile != null && substr($request->phone_mobile, 0, 1) != "6") {
                $phone_mobile = '6'.$request->phone_mobile;
            }

            $userProfile = UserProfiles::create([
                'user_id' => $user->id,
                'name' => $request->name,
                'phone_mobile' => $phone_mobile,
                'created_at' => NOW(),
                'created_by' => 0,
            ]);

            $roleUser = RoleUsers::create([
                'user_id' => $user->id,
                'role_id' => $request->role_id,
                'created_at' => NOW(),
            ]);

            // Email Verified *******************************************************************************************************
            $mailData = [
                'name' => $request->name,
                'email' => $request->email,
                'token' => $token,
            ];
            Mail::to($request->email)->send(new MailVerified($mailData));
            // End Email Verified ***************************************************************************************************

            // Log Activity System **************************************************************************************************
            $logActivity = Activities::create([
                'user_id' => $user->id,
                'path' => 'register-account',
                'remarks' => 'Create new user : '.$user->name.' ('.$user->id.')',
                'created_at' => NOW(),
            ]);
            // End Log Activity System **********************************************************************************************

            throw ValidationException::withMessages([
                $this->success() => 'New account registration successfully saved. Please check your email to confirm registration.'
            ]);
        }
        catch (\Exception $e) 
        {
            throw ValidationException::withMessages([
                $this->error() => $e->getMessage()
            ]);
        }
    }

    public function verification($token)
    {
        $settings = Settings::where('id', '=', 1)->first();
        $userToken = Users::where('token','=',$token)->first();
        if($userToken != null)
        {
            if($userToken->email_verified == 0)
            {
                $users = Users::find($userToken->id)->update([
                    'status_id' => 1,
                    'email_verified' => 1,
                    'created_at' => NOW(),
                ]);

                // Log Activity System **************************************************************************************************
                $logActivity = Activities::create([
                    'user_id' => $userToken->id,
                    'path' => 'verification/'.$userToken->token,
                    'remarks' => 'Email Verification : '.$userToken->username.' ('.$userToken->id.')',
                    'created_at' => NOW(),
                ]);
                // End Log Activity System **********************************************************************************************
            }

            $status = 'success';
            return view('auth.verification', compact('settings','status'));
        }
        else
        {
            $status = 'fail';
            return view('auth.verification', compact('settings','status'));
        }
    }

    public function usernamechecking($val)
    {
        $result = "";
        $check_val = Users::where('username', '=', $val)->first();
        
        if($check_val != null) {
            $result = 1;
        }

        return response()->json([
            'status' =>200,
            'result' => $result,
        ]);
    }

    public function emailchecking($val)
    {
        $result = "";
        $check_val = Users::where('email', '=', $val)->first();
        
        if($check_val != null) {
            $result = 1;
        }

        return response()->json([
            'status' =>200,
            'result' => $result,
        ]);
    }
}
