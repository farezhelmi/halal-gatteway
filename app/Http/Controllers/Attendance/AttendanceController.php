<?php

namespace App\Http\Controllers\Attendance;

use ZipArchive;
// use Barryvdh\DomPDF\PDF;
use App\Models\Sys\Settings;
use Illuminate\Http\Request;
use App\Models\Trainer\Trainer;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Training\Training;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Models\Attendance\Attendance;
use Illuminate\Support\Facades\Storage;

class AttendanceController extends Controller
{
    public function form($trainingId, $trainer_id)
    {
        // $attendance = Attendance::with(['trainer', 'training.training'])->findOrFail($trainingId);
        $settings = Settings::where('id', '=', 1)->first();
        $training = Training::findOrFail($trainingId);
        $trainer = Trainer::findOrFail($trainer_id);
        return view('attendance.form', compact('settings','training','trainer'));
    }

    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'name' => 'required|string|max:255',
            'army_id' => 'nullable|string|max:255',
            'identification_no' => 'required|string|max:255',
            'email' => 'required|email',
            'gender' => 'required|in:Male,Female',
            'phone_no' => 'required|string|max:15',
        ]);

        try {
            // Check if the identification_no is already registered for this training_id
            $existingAttendance = Attendance::where('training_id', $request->training_id)
            ->where('identification_no', $request->identification_no)
            ->first();
            
            if ($existingAttendance) {
                // Redirect back with an error if already registered
                return back()->with('error', 'This identification number is already registered for the selected training.');
            }

            // Store the attendance record
            $attendance = new Attendance();
            $attendance->training_id = $request->training_id; // Get training_id from request
            $attendance->trainer_id = $request->trainer_id;   // Get trainer_id from request
            $attendance->name = $request->name;
            $attendance->army_id = $request->army_id;
            $attendance->identification_no = $request->identification_no;
            $attendance->email = $request->email;
            $attendance->gender = $request->gender;
            $attendance->phone_no = $request->phone_no;

            // Save the attendance
            $attendance->save();

            // Redirect to thank you page
            return redirect()->route('attendance/registered')->with('success', 'Attendance registered successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function thanks()
    {
        $settings = Settings::where('id', '=', 1)->first();

        return view('attendance.thanks', compact('settings'));
    }

    public function listAttendance($id)
    {
        $training = Training::where('id', '=', $id)->first();
        $attendances = Attendance::where('training_id','=',$training->id)->get();

        return view('attendance.list-attendance', compact('training', 'attendances'));
    }

    public function generateCertificate($trainingId, $attendanceId)
    {
        $attendance = Attendance::findOrFail($attendanceId);
        $training = Training::findOrFail($trainingId);

        // Load the certificate template (make sure to store it in public/certificates)
        $imgPath = public_path('certificates/template.png');

        // Data to insert into the certificate
        $data = [
            'name' => $attendance->name,
            'trainingTitle' => $training->title,
            'date' => $training->training_date->format('F j, Y')
        ];

        // Generate the PDF
        $pdf = PDF::loadView('pdf.certificate', compact('data', 'imgPath'))
                ->setPaper([0, 0, 1061, 1500], 'landscape');
                // ->setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])
                // ->setWarnings(false);

        // // Set margins to 0
        // $pdf->getDomPDF()->set_option('defaultMediaType', 'print');
        // $pdf->getDomPDF()->set_option('isHtml5ParserEnabled', true);
        // $pdf->getDomPDF()->getCanvas()->set_opacity(1);

        return $pdf->download('Certificate-' . $attendance->name . '.pdf');
    }

    public function bulkGenerateCertificates($trainingId)
    {
        // Fetch the training details and all related attendances
        $training = Training::findOrFail($trainingId);
        $attendances = Attendance::where('training_id', $trainingId)->get();

        // Prepare a temporary directory for zip file storage
        $tempPath = public_path('certificates/temp');
        if (!file_exists($tempPath)) {
            mkdir($tempPath, 0755, true);
        }

        // Create a new zip file
        $zipFileName = 'Certificates_' . $training->title . '_' . date('YmdHis') . '.zip';
        $zipFilePath = $tempPath . '/' . $zipFileName;
        $zip = new \ZipArchive();
        $zip->open($zipFilePath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

        foreach ($attendances as $attendance) {
            // Load the certificate template
            $imgPath = public_path('certificates/template.png');

            // Prepare data for the PDF
            $data = [
                'name' => $attendance->name,
                'trainingTitle' => $training->title,
                'date' => $training->training_date->format('F j, Y')
            ];

            // Generate the PDF
            $pdf = PDF::loadView('pdf.certificate', compact('data', 'imgPath'))
                ->setPaper([0, 0, 1061, 1500], 'landscape');
                // ->setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true]);

            // Save the PDF to the temp directory
            $pdfFileName = 'Certificate_' . $attendance->name . '.pdf';
            $pdfFilePath = $tempPath . '/' . $pdfFileName;
            $pdf->save($pdfFilePath); // Save the PDF to a file

            // Add the PDF file to the zip archive
            $zip->addFile($pdfFilePath, $pdfFileName);
        }

        // Close the zip file
        $zip->close();

        // Return the zip file for download
        return response()->download($zipFilePath)->deleteFileAfterSend(true);
    }

    public function printAttendancePDF($trainingId)
    {
        $training = Training::findOrFail($trainingId);
        $attendances = Attendance::where('training_id', $training->id)->get();
    
        // Load view for the PDF
        $pdf = PDF::loadView('pdf.attendance-list', compact('training', 'attendances'))
                  ->setPaper('a4', 'portrait'); // Paper size and orientation
    
        return $pdf->download('Attendance_Report_' . $training->title . '.pdf');
    }
}
