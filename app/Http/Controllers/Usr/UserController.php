<?php

namespace App\Http\Controllers\Usr;

use App\Models\Sys\Roles;
use App\Models\Usr\Users;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Ref\Religions;
use App\Models\Sys\RoleUsers;
use App\Mail\MailNotification;
use App\Models\Log\Activities;
use App\Models\Usr\UserProfiles;
use App\Models\Sys\Notifications;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\Ref\IdentificationTypes;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\AccessController;

class UserController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index()
    {
        try 
        {
            $users = Users::where([
                ['status_id', '!=', 0]
            ])->get();

            return view('usr.users.index', compact('users'));
        } 
        catch (\Exception $e) {
            return redirect()->route('error/store',['id' => Auth::id(), 'url' => str_replace('/','.',\Request::getRequestUri()), 'error' => base64_encode($e->getMessage())]);
        }
    }

    public function create()
    {
        $route = 'users/store';
        $title = 'Add New User';

        $user = new Users();
        $userProfile = new UserProfiles();
        $roles = Roles::whereIn('id',[2,3,4])->orderBy('id', 'ASC')->get();
        $identification = IdentificationTypes::orderBy('id', 'ASC')->pluck('name', 'id');

        return view('usr.users.form', compact('title', 'route', 'user', 'userProfile', 'roles', 'identification'));
    }

    public function store(Request $request)
    {
        // Role-Based Access Control *******************************************
        (new AccessController)->permission(); 
        // *********************************************************************

        try
        {
            $token = Str::random(12);
            $user = Users::create([
                'username' => $request->email,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => $request->role_id,
                'status_id' => $request->status_id,
                'email_verified' => 1,
                'token' => $token,
                'first_login' => 1,
                'created_at' => NOW(),
                'created_by' => Auth::id(),
            ]);

            $phone_home = $request->phone_home;
            if($phone_home != null && substr($request->phone_home, 0, 1) != "6") {
                $phone_home = '6'.$request->phone_home;
            }

            $phone_mobile = $request->phone_mobile;
            if($phone_mobile != null && substr($request->phone_mobile, 0, 1) != "6") {
                $phone_mobile = '6'.$request->phone_mobile;
            }

            $userProfile = UserProfiles::create([
                'user_id' => $user->id,
                'name' => $request->profile_name,
                'identification_type_id' => $request->profile_identification_type_id,
                'identification_card' => $request->profile_identification_card,
                'phone_mobile' => $phone_mobile,
                'created_at' => NOW(),
                'created_by' => Auth::id(),
            ]);

            $roleUser = RoleUsers::create([
                'user_id' => $user->id,
                'role_id' => $request->role_id,
                'created_at' => NOW(),
            ]);

            // Upload Avatar Image **************************************************************************************************
            $directory = 'uploads/images/avatar';
            File::isDirectory($directory) or File::makeDirectory($directory, 0777, true, true);
            if($request->file('path_avatar') != null)
            {
                $fileName = $user->id.'-avatar.'.$request->file('path_avatar')->extension();  
                $request->file('path_avatar')->move(public_path($directory), $fileName);
                
                UserProfiles::where('user_id', $user->id)->update([
                    'path_avatar' => $directory.'/'.$fileName,
                ]);
            }
            // **********************************************************************************************************************

            // Log Activity System **************************************************************************************************
            $logActivity = Activities::create([
                'user_id' => Auth::id(),
                'path' => 'users/create',
                'remarks' => 'Create new user : '.$user->name.' ('.$user->id.')',
                'created_at' => NOW(),
            ]);
            // End Log Activity System **********************************************************************************************

            return Redirect::to($request->url_previous)->with('success','New User Registration Successfully Saved.');
        }
        catch (\Exception $e) 
        {
            return Redirect::to($request->url_previous)->with('error',$e->getMessage());
        }
    }

    public function edit($id)
    {
        // Check User Access ***********************************************************************************
        if(Auth::User()->role_id > 2) {
            if($id != Auth::id()) {
                return redirect()->route('/')->with('info','Sorry. You do not have access to edit this information.');
            }
        }
        // End Check User Access *******************************************************************************

        $route = 'users/update';
        $title = 'Update User Information';

        $user = Users::find($id);
        $userProfile = UserProfiles::where('user_id','=',$user->id)->first();
        $identification = IdentificationTypes::orderBy('id', 'ASC')->pluck('name', 'id');

        if(Auth::User()->role_id <= 2) 
        {
            $roles = Roles::orderBy('id', 'ASC')->get();
        }
        else
        {
            $roles = Roles::where('id','=',Auth::User()->role_id)->orderBy('id', 'ASC')->get();
        }

        return view('usr.users.form', compact('title', 'route', 'user', 'userProfile', 'roles', 'identification'));
    }

    public function update(Request $request)
    {
        // Role-Based Access Control *******************************************
        (new AccessController)->permission(); 
        // *********************************************************************

        try
        {
            $user = Users::find($request->id);
            $status_id = $user->status_id;
            if($user->role_id <= 2) {
                $status_id = $request->status_id;
            }
            
            if($request->password != null) 
            {
                Users::find($request->id)->update([
                    'username' => $request->email,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'role_id' => $request->role_id,
                    'status_id' => $status_id,
                    'updated_at' => NOW(),
                    'updated_by' => Auth::id(),
                ]);
            }
            else 
            {
                Users::find($request->id)->update([
                    'username' => $request->email,
                    'email' => $request->email,
                    'role_id' => $request->role_id,
                    'status_id' => $status_id,
                    'updated_at' => NOW(),
                    'updated_by' => Auth::id(),
                ]);
            }

            $phone_home = $request->phone_home;
            if($phone_home != null && substr($request->phone_home, 0, 1) != "6") {
                $phone_home = '6'.$request->phone_home;
            }

            $phone_mobile = $request->phone_mobile;
            if($phone_mobile != null && substr($request->phone_mobile, 0, 1) != "6") {
                $phone_mobile = '6'.$request->phone_mobile;
            }

            UserProfiles::where('user_id','=',$request->id)->update([
                'name' => $request->profile_name,
                'identification_type_id' => $request->profile_identification_type_id,
                'identification_card' => $request->profile_identification_card,
                'phone_home' => $phone_home,
                'phone_mobile' => $phone_mobile,
                'updated_at' => NOW(),
                'updated_by' => Auth::id(),
            ]);  

            $roleUser = RoleUsers::where('user_id','=',$request->id)->update([
                'role_id' => $request->role_id,
                'updated_at' => NOW(),
            ]);

            // Upload Avatar Image **************************************************************************************************
            $directory = 'uploads/images/avatar';
            File::isDirectory($directory) or File::makeDirectory($directory, 0777, true, true);
            if($request->file('path_avatar') != null)
            {
                $fileName = $request->id.'-avatar.'.$request->file('path_avatar')->extension();  
                $request->file('path_avatar')->move(public_path($directory), $fileName);
                
                UserProfiles::where('user_id', '=', $request->id)->update([
                    'path_avatar' => $directory.'/'.$fileName,
                ]);
            }
            // **********************************************************************************************************************

            // Log Activity System **************************************************************************************************
            $logActivity = Activities::create([
                'user_id' => Auth::id(),
                'path' => 'users/edit',
                'remarks' => 'Update user information : '.$request->name.' ('.$request->id.')',
                'created_at' => NOW(),
            ]);
            // End Log Activity System **********************************************************************************************

            return Redirect::to($request->url_previous)->with('success','User information update successfully saved.');
        }
        catch (\Exception $e) 
        {
            return Redirect::to($request->url_previous)->with('error',$e->getMessage());
        }
    }

    public function view($id)
    {
        $user = Users::find($id);

        return view('usr.users.view', compact('user'));
    }

    public function delete($id)
    {
        // Role-Based Access Control *******************************************
        (new AccessController)->permission(); 
        // *********************************************************************
        
        $user = Users::find($id);

        Users::find($user->id)->update([
            'username' => 'REMOVE-'.$user->username,
            'email' => 'REMOVE-'.$user->email,
            'status_id' => 0,
            'updated_at' => NOW(),
            'updated_by' => Auth::id(),
        ]);

        UserProfiles::find($user->id)->update([
            'email' => 'REMOVE-'.$user->email,
            'updated_at' => NOW(),
            'updated_by' => Auth::id(),
        ]);

        // $delete_role_user = RoleUsers::where('user_id', $user->id)->delete();

        // Log Activity System **************************************************************************************************
        $logActivity = Activities::create([
            'user_id' => Auth::id(),
            'path' => 'users/delete',
            'remarks' => 'Padam Pengguna Sistem : '.$user->name.' ('.$user->id.')',
            'created_at' => NOW(),
        ]);
        // End Log Activity System **********************************************************************************************

        return redirect()->back()->with('success','MAKLUMAT PENGGUNA SISTEM BERJAYA DIPADAM.');
    }


    public function list(Request $request)
    {
        $role = null;
        if($request->role != null) {
            $role = $request->role;
        }

        if($role == null) {
            $users = Users::where([['status_id', '!=', 0]])->whereIn('role_id',[2,3,4])->orderBy('id', 'DESC')->get();
        }
        else {
            $users = Users::where([['status_id', '!=', 0]])->whereIn('role_id',[$role])->orderBy('id', 'DESC')->get();
        }

        return view('usr.users.list', compact('users','role'));
    }

    public function complete($id)
    {
        $user = Users::find($id);
        $userProfile = UserProfiles::where('user_id','=',$user->id)->first();

        return view('usr.users.form-details', compact('user', 'userProfile'));
    }

    public function completeUpdate(Request $request)
    {
        // Role-Based Access Control *******************************************
        (new AccessController)->permission(); 
        // *********************************************************************

        try
        {
            $user = Users::find($request->id);
            Users::find($user->id)->update([
                'username' => $request->email,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => $request->role_id,
                'first_login' => 1,
                'updated_at' => NOW(),
                'updated_by' => Auth::id(),
            ]);

            if($user->role_id <= 3)
            {
                $phone_mobile = $request->phone_mobile;
                if($phone_mobile != null && substr($request->phone_mobile, 0, 1) != "6") {
                    $phone_mobile = '6'.$request->phone_mobile;
                }

                UserProfiles::where('user_id','=',$user->id)->update([
                    'name' => $request->profile_name,
                    'phone_mobile' => $phone_mobile,
                    'staff_id' => $request->profile_staff_id,
                    'identification_card' => $request->profile_identification_card,
                    'industrial_detail' => $request->profile_industrial_detail,
                    'objective' => $request->profile_objective,
                    'updated_at' => NOW(),
                    'updated_by' => Auth::id(),
                ]);
            }
            else
            {
                UserProfiles::where('user_id','=',$user->id)->update([
                    'name' => $request->profile_name,
                    'phone_mobile' => $phone_mobile,
                    'updated_at' => NOW(),
                    'updated_by' => Auth::id(),
                ]);
            }   

            $roleUser = RoleUsers::where('user_id','=',$user->id)->update([
                'role_id' => $request->role_id,
                'updated_at' => NOW(),
            ]);

            // Upload Avatar Image **************************************************************************************************
            $directory = 'uploads/images/avatar';
            if($request->file('path_avatar') != null)
            {
                $fileName = $user->id.'-avatar.'.$request->file('path_avatar')->extension();  
                $request->file('path_avatar')->move(public_path($directory), $fileName);
                
                UserProfiles::where('user_id', '=', $request->id)->update([
                    'path_avatar' => $directory.'/'.$fileName,
                ]);
            }
            // **********************************************************************************************************************

            // Log Activity System **************************************************************************************************
            $logActivity = Activities::create([
                'user_id' => Auth::id(),
                'path' => 'users/edit',
                'remarks' => 'Update user information : '.$request->name.' ('.$user->id.')',
                'created_at' => NOW(),
            ]);
            // End Log Activity System **********************************************************************************************

            return Redirect::route('/')->with('success','User information update successfully saved.');
        }
        catch (\Exception $e) 
        {
            return Redirect::to($request->url_previous)->with('error',$e->getMessage());
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

    public function emailchecking($id,$val)
    {
        $result = "";
        $check_val = Users::where('email', '=', $val)->first();
        
        if($id == 0)
        {
            $email_old = "";
            if($check_val != null) {
                $result = 1;
            }
        }
        else
        {
            $user = Users::where('id', '=', $id)->first();
            $email_old = $user->email;

            if($check_val != null && $check_val != $user) {
                $result = 1;
            }
        }

        return response()->json([
            'status' =>200,
            'result' => $result,
            'email_old' => $email_old
        ]);
    }

    public function namechecking($id,$val)
    {
        $result = "";
        $check_val = Users::where('name', '=', $val)->first();
        
        if($id == 0)
        {
            $name_old = "";
            if($check_val != null) {
                $result = 1;
            }
        }
        else
        {
            $user = Users::where('id', '=', $id)->first();
            $name_old = $user->name;

            if($check_val != null && $check_val != $user) {
                $result = 1;
            }
        }

        return response()->json([
            'status' =>200,
            'result' => $result,
            'name_old' => $name_old
        ]);
    }

    public function identificationcardchecking($id,$val)
    {
        $result = "";
        $check_identification_card = UserProfiles::where('identification_card', '=', $val)->first();

        if($id == 0) 
        { 
            $identification_card_old = null;
        }
        else
        {
            $user = Users::where('id', '=', $id)->first();
            $identification_card_old = $user->profile->identification_card;
        }
        
        if($check_identification_card != null) {
            $result = 1;
        }

        return response()->json([
            'status' =>200,
            'result' => $result,
            'identification_card_old' => $identification_card_old
        ]);
    }

    public function readNotification($id)
    {
        $notis = Notifications::where('id', '=', $id)->first();
        $notification = Notifications::find($notis->id)->update([
            'is_read' => 1,
            'updated_at' => NOW(),
        ]);

        return redirect()->route($notis->url_redirect);
    }

    public function listNotification()
    {
        $notifications = Notifications::where([['user_id', '=', Auth::id()],['is_read','=',0]])->orderBy('id', 'DESC')->get(); 

        return view('usr.users.list-notification', compact('notifications'));
    }
}