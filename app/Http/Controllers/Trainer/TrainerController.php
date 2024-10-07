<?php

namespace App\Http\Controllers\Trainer;

use App\Models\Usr\Users;
use Illuminate\Http\Request;
use App\Models\Log\Activities;
use App\Models\Trainer\Trainer;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Ref\IdentificationTypes;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\AccessController;

class TrainerController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index()
    {
        $trainers = Trainer::where([
            ['status_id', '!=', 0]
        ])->get();

        return view('trainers.index', compact('trainers'));
    }

    public function create()
    {
        $route = 'trainers/store';
        $title = 'Add New Trainer';

        $trainer = new Trainer();
        $identification = IdentificationTypes::orderBy('id', 'ASC')->pluck('name', 'id');

        return view('trainers.form', compact('route', 'trainer', 'identification', 'title'));
    }

    public function store(Request $request)
    {
        // Role-Based Access Control *******************************************
        (new AccessController)->permission(); 
        // *********************************************************************

        // $request->validate([
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|email|unique:trainers,email',
        //     'gender' => 'required|in:male,female,other',
        //     'certificate' => 'nullable|file|mimes:jpeg,png,pdf|max:2048',
        // ]);

        $certificatePath = null;

        if ($request->hasFile('certificate')) {
            $certificatePath = $request->file('certificate')->store('certificates', 'public');
        }

        $phone_mobile = $request->phone_mobile;
            if($phone_mobile != null && substr($request->phone_mobile, 0, 1) != "6") {
                $phone_mobile = '6'.$request->phone_mobile;
            }

        $trainer = Trainer::create([
            'name' => $request->name,
            'identification_type_id' => $request->profile_identification_type_id,
            'identification_no' => $request->identification_no,
            'email' => $request->email,
            'gender' => $request->gender,
            'phone_no' => $phone_mobile,
            'certificate' => $certificatePath,
            'status_id' => $request->status_id,
            'created_by' => Auth::id(), // Add the ID of the authenticated user
        ]);

        // Log Activity System **************************************************************************************************
        $logActivity = Activities::create([
            'user_id' => Auth::id(),
            'path' => 'trainers/create',
            'remarks' => 'Create new trainer : '.$trainer->name.' ('.$trainer->id.')',
            'created_at' => NOW(),
        ]);
        // End Log Activity System **********************************************************************************************

        return Redirect::to($request->url_previous)->with('success','New Trainer Registration Successfully Saved.');
    }

    public function emailchecking($id,$val)
    {
        $result = "";
        $check_val = Trainer::where('email', '=', $val)->first();
        
        if($id == 0)
        {
            $email_old = "";
            if($check_val != null) {
                $result = 1;
            }
        }
        else
        {
            $trainer = Trainer::where('id', '=', $id)->first();
            $email_old = $trainer->email;

            if($check_val != null && $check_val != $trainer) {
                $result = 1;
            }
        }

        return response()->json([
            'status' =>200,
            'result' => $result,
            'email_old' => $email_old
        ]);
    }

    public function identificationcardchecking($id,$val)
    {
        $result = "";
        $check_identification_card = Trainer::where('identification_no', '=', $val)->first();

        if($id == 0) 
        { 
            $identification_card_old = null;
        }
        else
        {
            $trainer = Trainer::where('id', '=', $id)->first();
            $identification_card_old = $trainer->identification_no;
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

    public function view($id)
    {
        $trainer = Trainer::find($id);

        return view('trainers.view', compact('trainer'));
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

        $route = 'trainers/update';
        $title = 'Update Trainer Information';

        $trainer = Trainer::find($id);
        $identification = IdentificationTypes::orderBy('id', 'ASC')->pluck('name', 'id');

        return view('trainers.form', compact('title', 'route', 'trainer', 'identification'));
    }

    public function update(Request $request)
    {
        // Role-Based Access Control *******************************************
        (new AccessController)->permission(); 
        // *********************************************************************

        try
        {
            // $user = Users::find($request->id);
            // $status_id = $user->status_id;
            // if($user->role_id <= 2) {
            //     $status_id = $request->status_id;
            // }
            
            // Find the trainer by ID
            $trainer = Trainer::findOrFail($request->id);

            // Update the trainer details
            $trainer->name = $request->name;
            $trainer->identification_no = $request->identification_no;
            $trainer->email = $request->email;
            $trainer->gender = $request->gender;
            $trainer->phone_no = $request->phone_mobile;
            $trainer->updated_by = Auth::id();
            

            // Check if a new certificate file is uploaded
            if ($request->hasFile('certificate')) {
                // Delete the old certificate if exists
                if ($trainer->certificate && Storage::exists($trainer->certificate)) {
                    Storage::delete($trainer->certificate);
                }

                // Store the new certificate
                $path = $request->file('certificate')->store('certificates');
                $trainer->certificate = $path; // Save the file path to the database
            }

            // Save the updated trainer information
            $trainer->save();

            $phone_mobile = $request->phone_mobile;
            if($phone_mobile != null && substr($request->phone_mobile, 0, 1) != "6") {
                $phone_mobile = '6'.$request->phone_mobile;
            }

            // Log Activity System **************************************************************************************************
            $logActivity = Activities::create([
                'user_id' => Auth::id(),
                'path' => 'trainers/edit',
                'remarks' => 'Update trainer information : '.$request->name.' ('.$request->id.')',
                'created_at' => NOW(),
            ]);
            // End Log Activity System **********************************************************************************************

            return Redirect::to($request->url_previous)->with('success','Trainer information update successfully saved.');
        }
        catch (\Exception $e) 
        {
            return Redirect::to($request->url_previous)->with('error',$e->getMessage());
        }
    }

    public function delete($id)
    {
        // Role-Based Access Control *******************************************
        (new AccessController)->permission(); 
        // *********************************************************************
        
        $trainer = Trainer::find($id);

        Trainer::find($trainer->id)->update([
            'name' => 'REMOVE-'.$trainer->name,
            'email' => 'REMOVE-'.$trainer->email,
            'status_id' => 0,
            'updated_at' => NOW(),
            'updated_by' => Auth::id(),
        ]);

        // $delete_role_user = RoleUsers::where('user_id', $user->id)->delete();

        // Log Activity System **************************************************************************************************
        $logActivity = Activities::create([
            'user_id' => Auth::id(),
            'path' => 'trainers/delete',
            'remarks' => 'Padam Pengguna Sistem : '.$trainer->name.' ('.$trainer->id.')',
            'created_at' => NOW(),
        ]);
        // End Log Activity System **********************************************************************************************

        return redirect()->back()->with('success','Trainer Information Successfully Deleted');
    }
}
