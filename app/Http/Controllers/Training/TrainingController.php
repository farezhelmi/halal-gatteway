<?php

namespace App\Http\Controllers\Training;

use Illuminate\Http\Request;
use App\Models\Log\Activities;
use App\Models\Trainer\Trainer;
use App\Models\Training\Training;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance\Attendance;
use App\Models\Training\TrainingType;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\AccessController;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TrainingController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index()
    {
        $trainings = Training::with('trainer')
        ->where([
            ['status_id', '!=', 0]
        ])->get();

        return view('training.index', compact('trainings'));
    }

    public function create()
    {
        $route = 'trainings/store';
        $title = 'Create new training'; 

        $training = new Training();

        $trainers = Trainer::where([
            ['status_id', '!=', 0]
        ])->get();
        $training_types = TrainingType::where([
            ['status_id', '!=', 0]
        ])->get();

        return view('training.form', compact('training', 'route', 'title', 'trainers', 'training_types'));
    }

    public function store(Request $request)
    {
        // Role-Based Access Control *******************************************
        (new AccessController)->permission(); 
        // *********************************************************************

        // Validate the request
        // $request->validate([
        //     'trainer_id' => 'required|exists:trainers,id',
        //     'title' => 'required|string|max:255',
        //     'training_date' => 'required|date',
        //     'training_type_id' => 'required|exists:training_type,id',
        // ]);

        try {
            // Create a new training record
            $training = Training::create([
                'trainer_id' => $request->trainer_id,
                'title' => $request->title,
                'training_date' => $request->training_date,
                'training_type_id' => $request->training_type_id,
                'created_by' => Auth::id(),
            ]);

            // Generate the QR code link for attendance registration
            $qrCodeLink = route('attendance/form', ['training_id' => $training->id, 'trainer_id' => $training->trainer_id]);
            $qrCode = QrCode::size(200)->generate($qrCodeLink);

            // Log activity (optional)
            $logActivity = Activities::create([
                'user_id' => Auth::id(),
                'path' => 'trainings/create',
                'remarks' => 'Created new training: ' . $training->title . ' (' . $training->id . ')',
                'created_at' => now(),
            ]);

            // Redirect to the training index or show the QR code
            return Redirect::to($request->url_previous)->with('success','New Training Registration Successfully Saved.');
        } catch (\Exception $e) 
        {
            return Redirect::to($request->url_previous)->with('error',$e->getMessage());
        }
    }

    public function view($id)
    {
        $training = Training::with('trainer')->findOrFail($id);

        return view('training.view', compact('training'));
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

        // Find the training session by ID
        $training = Training::findOrFail($id);
        $trainers = Trainer::all(); // Fetch trainers list for dropdown
        $training_types = TrainingType::all();

        $route = 'trainings/update'; // The route for form submission
        $title = 'Update Training Session'; // Title for the form

        return view('training.form', compact('title', 'route', 'training', 'trainers', 'training_types'));
    }

    public function update(Request $request)
    {
        // Validate the request
        // $request->validate([
        //     'trainer_id' => 'required|exists:trainers,id',
        //     'title' => 'required|string|max:255',
        //     'training_date' => 'required|date',
        // ]);

        try {
            // Find the training by ID
            $training = Training::findOrFail($request->id);

            // Update the training details
            $training->trainer_id = $request->trainer_id;
            $training->title = $request->title;
            $training->training_date = $request->training_date;
            $training->training_type_id = $request->training_type_id; 
            $training->status_id = $request->status_id;
            $training->updated_by = Auth::id(); // Update the user who made the change

            // Save the changes
            $training->save();

            // Log Activity (optional)
            Activities::create([
                'user_id' => Auth::id(),
                'path' => 'trainings/edit',
                'remarks' => 'Updated training session: ' . $request->title . ' (' . $request->id . ')',
                'created_at' => NOW(),
            ]);

            return redirect()->route('trainings/index')->with('success', 'Training session updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('trainings/index')->with('error', $e->getMessage());
        }
    }

    public function delete($id)
    {
        // Role-Based Access Control *******************************************
        (new AccessController)->permission(); 
        // *********************************************************************
        
        $training = Training::find($id);

        Training::find($training->id)->update([
            'title' => 'REMOVE-'.$training->title,
            'status_id' => 0,
            'updated_at' => NOW(),
            'updated_by' => Auth::id(),
        ]);

        // $delete_role_user = RoleUsers::where('user_id', $user->id)->delete();

        // Log Activity System **************************************************************************************************
        $logActivity = Activities::create([
            'user_id' => Auth::id(),
            'path' => 'trainings/delete',
            'remarks' => 'Padam Pengguna Sistem : '.$training->title.' ('.$training->id.')',
            'created_at' => NOW(),
        ]);
        // End Log Activity System **********************************************************************************************

        return redirect()->back()->with('success','Training Information Successfully Deleted');
    }

}
