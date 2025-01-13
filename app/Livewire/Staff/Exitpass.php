<?php

namespace App\Livewire\Staff;
use App\Models\exitpass as exitPasss;;
use App\Models\User as Student;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

use App\Models\Patient as Patients;
//use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class Exitpass extends Component
{
    public $studentNumber,$qr, $name, $gradeSection, $diagnose, $destination, $responsible_person, $relationship,$date, $time;
    public $isModalOpen = false;

    public function createExitPass()
    {

        $this->validate([
            'studentNumber' => 'required',
            'name' => 'required',
            'gradeSection' => 'required',
            'diagnose' => 'required',
            'destination' => 'required',
            'responsible_person' => 'required',
            'relationship' => 'required',
            'date' => 'required',
            'time' => 'required',
        ]);


        $qrData = [
            'Student Number' => $this->studentNumber,
            'Name' => $this->name,
            'Diagnose' => $this->diagnose,
            'Grade/Section' => $this->gradeSection,
            'Date' => $this->date,
            'Time' => $this->time,
            'Destination' => $this->destination,
            'Responsible Person' => $this->responsible_person,
            'Relationship to Student' => $this->relationship,
            'Noted By' => 'Nurse',
            'Approved By' => 'Student Affairs',
        ];

        $qrCode = new QrCode(json_encode($qrData));



        $qrCode = new QrCode(json_encode($qrData));


        $writer = new PngWriter();
        $qrImage = $writer->write($qrCode)->getString();


        $fileName = 'qrcodes/exitpass-' . $this->studentNumber . '.png';
        Storage::disk('public')->put($fileName, $qrImage);


        exitPasss::create([
            'student_number' => $this->studentNumber,
            'destination' => $this->destination,
            'responsible_person' => $this->responsible_person,
            'relationship_to_student' => $this->relationship,
            'diagnose' => $this->diagnose,
            'exit_date' => $this->date,
            'exit_time' => $this->time,
            'qr' => $fileName,
        ]);


        $this->toggleModal();
        $this->resetForm();
        session()->flash('message', 'Exit Pass created successfully!');
    }

    // public function downloadQR($id)
    // {
    //     $patient = Patients::with('user')->find($id);

    //     if (!$patient) {
    //         session()->flash('error', 'Patient not found.');
    //         return;
    //     }

    //     $qrData = [
    //         'Student Number' => $patient->studentNumber,
    //         'Name' => $patient->user->name,
    //         'Diagnose' => $patient->diagnose,
    //         'Grade/Section' => $patient->grade_section,
    //         'Date' => $patient->date,
    //     ];

    //     $qrCode = QrCode::format('png')->size(300)->generate(json_encode($qrData));

    //     $fileName = 'qrcodes/patient-' . $patient->id . '.png';
    //     Storage::disk('public')->put($fileName, $qrCode);

    //     return response()->download(storage_path('app/public/' . $fileName))->deleteFileAfterSend(true);
    // }

    public function resetForm()
    {

        $this->studentNumber = '';
        $this->name = '';
        $this->gradeSection = '';
        $this->diagnose = '';
        $this->destination = '';
        $this->responsible_person = '';
        $this->relationship = '';
        $this->date = '';
        $this->time = '';

    }

    public function fetchStudentDetails()
    {

        $student = Student::where('student_number', $this->studentNumber)->first();


        if ($student) {

            $this->name = $student->name;
            $this->gradeSection = $student->grade_section;


            $patient = Patients::where('student_number', $this->studentNumber)->first();


            if ($patient) {
                $this->diagnose = $patient->diagnose;
            } else {
                $this->diagnose = '';
            }
        } else {

            $this->name = '';
            $this->gradeSection = '';
            $this->diagnose = '';
        }
    }



    public function toggleModal()
    {
        $this->isModalOpen = !$this->isModalOpen;
    }


    public function render()
    {
        $exitPasses = ExitPasss::all();
        $patients = Patients::with('user')->get();


        return view('livewire.staff.exitpass', compact('exitPasses', 'patients'));
    }

}
