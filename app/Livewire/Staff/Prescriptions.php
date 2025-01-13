<?php

namespace App\Livewire\Staff;
use App\Models\User;
use App\Models\Prescriptions as Prescription;
use App\Models\Treatment;
use Livewire\Component;

class Prescriptions extends Component
{
    public $studentNumber;
    public $gradeSection;
    public $treatment;
    public $name;
    public $diagnose;
    public $prescriptionId;
    public $editModal = false;
    public $search = '';


    protected $rules = [
        'studentNumber' => 'required|string|max:255',
        'gradeSection' => 'required|string|max:255',
        'treatment' => 'required|exists:treatments,id',
        'diagnose' => 'required|string|max:1000',
    ];
    public function fetchStudentDetails()
    {
        $student = User::where('student_number', $this->studentNumber)->first();

        if ($student) {
            $this->name = $student->name;
            $this->gradeSection = $student->grade_section;
        } else {
            $this->name = '';
            $this->gradeSection = '';
            session()->flash('error', 'Student not found.');
        }
    }
    public function save()
    {
        $this->validate();

        if ($this->prescriptionId) {
            // Update existing prescription
            $prescription = Prescription::find($this->prescriptionId);
            $prescription->update([
                'student_number' => $this->studentNumber,
                'grade_section' => $this->gradeSection,
                'treatment_id' => $this->treatment,
                'diagnose' => $this->diagnose,
            ]);
            session()->flash('success', 'Prescription updated successfully.');
        } else {
            // Create new prescription
            Prescription::create([
                'student_number' => $this->studentNumber,
                'grade_section' => $this->gradeSection,
                'treatment_id' => $this->treatment,
                'diagnose' => $this->diagnose,
            ]);
            session()->flash('success', 'Prescription added successfully.');
        }

        $this->resetForm();
    }

    public function edit($id)
    {
        $prescription = Prescription::find($id);

        if ($prescription) {
            $this->prescriptionId = $prescription->id;
            $this->studentNumber = $prescription->student_number;
            $this->gradeSection = $prescription->grade_section;
            $this->treatment = $prescription->treatment_id;
            $this->diagnose = $prescription->diagnose;

            $this->editModal = true;
        }
    }

    public function delete($id)
    {
        $prescription = Prescription::find($id);
        if ($prescription) {
            $prescription->delete();
            session()->flash('success', 'Prescription deleted successfully.');
        } else {
            session()->flash('error', 'Prescription not found.');
        }
    }

    public function cancel()
    {
        $this->resetForm();
        $this->editModal = false;
    }

    public function resetForm()
    {
        $this->reset(['studentNumber', 'gradeSection', 'treatment', 'diagnose', 'prescriptionId']);
    }
public function ser(){

$this->render();
}
    public function render()
    {
        $query = Prescription::with('treatment');

        if (!empty($this->search)) {
            $query->where('student_number', 'like', '%' . $this->search . '%')
                  ->orWhereHas('treatment', function ($q) {
                      $q->where('name', 'like', '%' . $this->search . '%');
                  });
        }

        $prescriptions = $query->get();


        // return view('livewire.staff.prescriptions', [
        //     'prescriptions' => Prescription::with('treatment')->get(),
        //     'treatments' => Treatment::all(),
        // ]);

        return view('livewire.staff.prescriptions', [
            'prescriptions' => $prescriptions,
            'treatments' => Treatment::all(),
        ]);
    }
}
