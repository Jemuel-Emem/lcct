<?php

namespace App\Livewire\Staff;

use App\Models\Patient as Patients;
use App\Models\User as Student;
use App\Models\treatment;
use Carbon\Carbon;
use Livewire\Component;

class Patient extends Component
{
    public $search = '';
    public $studentNumber;
    public $name;
    public $gradeSection;
    public $date;
    public $diagnose;
    public $treatment;
    public $timeIn;
    public $timeOut;
    public $patientId; // This will be used for editing
    public $editModal = false; // Boolean to track modal state
    public $disabledTimeouts = [];

    protected $rules = [
        'studentNumber' => 'required|string|max:255',
        'name' => 'required|string|max:255',
        'gradeSection' => 'required|string|max:255',
        'diagnose' => 'required|string|max:1000',
        'treatment' => 'required|exists:treatments,id', // Validate treatment exists
        'date' => 'nullable|date',
        'timeIn' => 'nullable|date_format:H:i',
        'timeOut' => 'nullable|date_format:H:i',
    ];

    public function fetchStudentDetails()
    {
        $student = Student::where('student_number', $this->studentNumber)->first();

        if ($student) {
            $this->name = $student->name;
            $this->gradeSection = $student->grade_section;
        } else {
            $this->name = '';
            $this->gradeSection = '';
        }
    }

    public function save()
    {
        $this->validate();

        if ($this->patientId) {
            $patient = Patients::find($this->patientId);
            $patient->update([
                'student_number' => $this->studentNumber,
                //'name' => $this->name,
               // 'grade_section' => $this->gradeSection,
                'diagnose' => $this->diagnose,
                'treatment_id' => $this->treatment, // Save treatment ID
                'date' => $this->date ?? Carbon::now()->format('Y-m-d'),
                'time_in' => $this->timeIn ?? Carbon::now()->format('H:i'),
                'time_out' => $this->timeOut,
            ]);
        } else {
            Patients::create([
                'student_number' => $this->studentNumber,
               // 'name' => $this->name,
               // 'grade_section' => $this->gradeSection,
                'diagnose' => $this->diagnose,
                'treatment_id' => $this->treatment, // Save treatment ID
                'date' => $this->date ?? Carbon::now()->format('Y-m-d'),
                'time_in' => Carbon::now()->format('H:i'),
                'time_out' => $this->timeOut,
            ]);
        }

        $this->resetForm();
        $this->editModal = false;
    }

    public function timeout($id)
    {
        $patient = Patients::find($id);

        if ($patient) {
            $patient->update([
                'time_out' => Carbon::now()->format('H:i'),
            ]);

            $this->disabledTimeouts[] = $id;

            session()->flash('success', 'Time out updated successfully for the patient.');
        } else {
            session()->flash('error', 'Patient not found.');
        }
    }

    public function cancel()
    {
        $this->reset(['studentNumber', 'name', 'gradeSection', 'date', 'complain']);
        $this->editModal = false;
    }

    public function edit($id)
    {
        $patient = Patients::find($id);
        $this->patientId = $id;
        $this->studentNumber = $patient->student_number;
        $this->name = $patient->name;
        $this->gradeSection = $patient->grade_section;
        $this->date = $patient->date;
        $this->diagnose = $patient->diagnose;
        $this->timeIn = $patient->time_in;
        $this->timeOut = $patient->time_out;

        $this->editModal = true;
    }

    public function delete($id)
    {
        $patient = Patients::find($id);
        $patient->delete();
    }

    public function resetForm()
    {
        $this->reset(['studentNumber', 'name', 'gradeSection', 'diagnose', 'treatment', 'date', 'timeIn', 'timeOut', 'patientId']);
    }

public function ser(){

}

    // public function render()
    // {
    //     // Eager load the 'user' relationship with patients
    //     $patients = Patients::with('user')->get();

    //     return view('livewire.staff.patient', [
    //         'patients' => $patients,
    //         'treatments' => Treatment::all(), // Pass treatments to the view
    //     ]);
    // }
    public function render()
    {
        // Apply search filter
        $patients = Patients::with('user')
            ->where('student_number', 'like', '%' . $this->search . '%')
            ->orWhereHas('user', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->get();

        return view('livewire.staff.patient', [
            'patients' => $patients,
            'treatments' => Treatment::all(),
        ]);
    }

}


