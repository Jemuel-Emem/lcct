<?php

namespace App\Livewire\Admin;

use App\Models\Patient;
use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Validation\Rule;

class AddPatient extends Component
{
    public $studentNumber;
    public $name;
    public $gradeSection;
    public $date;
    public $complain;
    public $timeIn;
    public $timeOut;
    public $patientId; // This will be used for editing
    public $editModal = false; // Boolean to track modal state
    public $disabledTimeouts = [];
    protected $rules = [
        'studentNumber' => 'required|string|max:255',
        'name' => 'required|string|max:255',
        'gradeSection' => 'required|string|max:255',
        'date' => 'required|date',
        'complain' => 'required|string|max:1000',
        'timeIn' => 'nullable|date_format:H:i',
        'timeOut' => 'nullable|date_format:H:i',
    ];

    public function save()
    {
        $this->validate();

        if ($this->patientId) {

            $patient = Patient::find($this->patientId);
            $patient->update([
                'student_number' => $this->studentNumber,
                'name' => $this->name,
                'grade_section' => $this->gradeSection,
                'date' => $this->date,
                'complain' => $this->complain,
                'time_in' => $this->timeIn ?? Carbon::now()->format('H:i'),
                'time_out' => $this->timeOut,
            ]);
            $this->resetForm();
        } else {

            Patient::create([
                'student_number' => $this->studentNumber,
                'name' => $this->name,
                'grade_section' => $this->gradeSection,
                'date' => $this->date,
                'complain' => $this->complain,
             'time_in' => Carbon::now()->format('H:i'),
                'time_out' => $this->timeOut,
            ]);
        }

        $this->resetForm();
        $this->editModal = false;
    }

    public function timeout($id)
    {
        $patient = Patient::find($id);

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
        $patient = Patient::find($id);
        $this->patientId = $id;
        $this->studentNumber = $patient->student_number;
        $this->name = $patient->name;
        $this->gradeSection = $patient->grade_section;
        $this->date = $patient->date;
        $this->complain = $patient->complain;
        $this->timeIn = $patient->time_in;
        $this->timeOut = $patient->time_out;

        $this->editModal = true;
    }

    public function delete($id)
    {
        $patient = Patient::find($id);
        $patient->delete();
    }

    public function resetForm()
    {
        $this->reset(['studentNumber', 'name', 'gradeSection', 'date', 'complain', 'timeIn', 'timeOut', 'patientId']);
    }

    public function render()
    {
        return view('livewire.admin.add-patient', [
            'patients' => Patient::all(),
        ]);
    }
}
