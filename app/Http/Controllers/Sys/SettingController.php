<?php

namespace App\Http\Controllers\Sys;

use App\Models\Sys\Settings;
use Illuminate\Http\Request;
use App\Models\Sys\RoleUsers;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use App\Models\Training\TrainingType;
use App\Http\Controllers\AccessController;

class SettingController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function edit()
    {
        $setting = Settings::find(1);
        
        return view('sys.setting.form', compact('setting'));
    }

    public function update(Request $request)
    {
        // Role-Based Access Control *******************************************
        (new AccessController)->permission(); 
        // *********************************************************************
        
        $setting = Settings::find($request->id)->update([
            'title' => $request->title,
            'title_favicon' => $request->title_favicon,
            'updated_at' => NOW(),
        ]);

        // Upload Favicon Image ******************************************************************************
        $directory = 'uploads\images\favicon';
        File::isDirectory($directory) or File::makeDirectory($directory, 0777, true, true);
        if($request->file('favicon_path') != null)
        {
            $fileName = 'favicon.'.$request->file('favicon_path')->extension();  
            $request->file('favicon_path')->move(public_path($directory), $fileName);

            Settings::where('id', $request->id)->update([
                'favicon_path' => $directory.'\\'.$fileName,
            ]);
        }
        // ***************************************************************************************************

        // Upload Logo Image *********************************************************************************
        $directory = 'uploads\images\logo';
        File::isDirectory($directory) or File::makeDirectory($directory, 0777, true, true);
        if($request->file('logo_path') != null)
        {
            $fileName = 'logo.'.$request->file('logo_path')->extension();  
            $request->file('logo_path')->move(public_path($directory), $fileName);

            Settings::where('id', $request->id)->update([
                'logo_path' => $directory.'\\'.$fileName,
            ]);
        }
        // ***************************************************************************************************
        
        return redirect()->route('/')->with('success','Update data successfully');
    }

    public function trainingType()
    {
        $trainingTypes = TrainingType::all();

        return view('sys.setting.training-type', compact('trainingTypes'));
    }

    public function createTraining()
    {
        $route = 'setting/store-training';
        $title = 'Create new Training Type'; 

        $trainingtype = new TrainingType();

        return view('sys.setting.create-training', compact('route', 'title', 'training_type'));
    }

    public function storeTraining(Request $request)
    {
        // Role-Based Access Control *******************************************
        (new AccessController)->permission(); 
        // *********************************************************************

        try {
            // Create a new training record
            $trainingType = TrainingType::create([
                'name' => $request->trainer_id,
                'status_id' => $request->status_id,
            ]);

            // Log activity (optional)
            $logActivity = Activities::create([
                'user_id' => Auth::id(),
                'path' => 'setting/create-training',
                'remarks' => 'Created new training type: ' . $trainingType->title . ' (' . $trainingType->id . ')',
                'created_at' => now(),
            ]);

            // Redirect to the training index or show the QR code
            return Redirect::to($request->url_previous)->with('success','New Training Type Successfully Saved.');
        } catch (\Exception $e) 
        {
            return Redirect::to($request->url_previous)->with('error',$e->getMessage());
        }
    }

    public function viewTraining($id)
    {
        $trainingType = TrainingType::findOrFail($id);

        return view('sys.setting.view-training', compact('trainingType'));
    }

    public function editTraining($id)
    {
        // Check User Access ***********************************************************************************
        if(Auth::User()->role_id > 2) {
            if($id != Auth::id()) {
                return redirect()->route('/')->with('info','Sorry. You do not have access to edit this information.');
            }
        }
        // End Check User Access *******************************************************************************

        // Find the training session by ID
        $trainingType = TrainingType::findOrFail($id);

        $route = 'setting/update-training'; // The route for form submission
        $title = 'Update Training Type'; // Title for the form

        return view('sys.setting.create-training', compact('title', 'route', 'trainingType'));
    }

    public function updateTraining(Request $request)
    {
       
        try {
            // Find the training by ID
            $trainingType = TrainingType::findOrFail($request->id);

            // Update the training details
            $trainingType->name = $request->trainer_id;
            $trainingType->status_id = $request->status_id;

            // Save the changes
            $trainingType->save();

            // Log Activity (optional)
            Activities::create([
                'user_id' => Auth::id(),
                'path' => 'setting/edit-training',
                'remarks' => 'Updated training type: ' . $request->name . ' (' . $request->id . ')',
                'created_at' => NOW(),
            ]);

            return redirect()->route('trainings/index')->with('success', 'Training session updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('trainings/index')->with('error', $e->getMessage());
        }
    }

    public function deleteTraining($id)
    {
        // Role-Based Access Control *******************************************
        (new AccessController)->permission(); 
        // *********************************************************************
        
        $trainingType = TrainingType::find($id);

        TrainingType::find($trainingType->id)->update([
            'name' => 'REMOVE-'.$trainingType->name,
            'status_id' => 0,
        ]);

        // $delete_role_user = RoleUsers::where('user_id', $user->id)->delete();

        // Log Activity System **************************************************************************************************
        $logActivity = Activities::create([
            'user_id' => Auth::id(),
            'path' => 'setting/delete-training',
            'remarks' => 'Padam Pengguna Sistem : '.$trainingType->name.' ('.$trainingType->id.')',
            'created_at' => NOW(),
        ]);
        // End Log Activity System **********************************************************************************************

        return redirect()->back()->with('success','Training Type Information Successfully Deleted');
    }
}