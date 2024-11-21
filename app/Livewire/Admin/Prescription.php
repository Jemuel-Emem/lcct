<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Prescription as pres;
use App\Models\Patient;
use App\Models\Treatment;
use App\Models\Medicine;

class Prescription extends Component
{
    public $addModal = false;
    public $editModal = false;
    public $prescriptionId = null;
    public $studentId, $treatmentId, $medicineId;
    public $patients, $treatments, $medicines;
    public $prescriptions;
    public $medicineQuantity;

    public $medicineModal = false;
public $medicineName, $patientName;

public function showMedicineQuantity($medicineId, $patientId)
{
    // Find the medicine and patient
    $medicine = Medicine::find($medicineId);
    $patient = Patient::find($patientId);

    // Get the prescribed quantity for this patient and medicine
    $prescription = pres::where('medicine_id', $medicineId)
                                ->where('patient_id', $patientId)
                                ->first();

    // Set the modal data
    if ($prescription) {
        $this->medicineName = $medicine->name;
        $this->patientName = $patient->name;
        $this->medicineQuantity = $prescription->quantity;
    } else {
        $this->medicineName = $medicine->name;
        $this->patientName = $patient->name;
        $this->medicineQuantity = 0;  // No prescription found
    }

    // Show the modal
    $this->medicineModal = true;
}

public function closeMedicineModal()
{
    // Close the modal
    $this->medicineModal = false;
}
    public function mount()
    {
        $this->patients = Patient::all();
        $this->treatments = Treatment::all();
        $this->medicines = Medicine::all();
    }


    public function render()
    {
        $this->prescriptions = pres::with(['patient', 'treatment', 'medicine'])->get();
        return view('livewire.admin.prescription');
    }


    public function save()
    {

        $this->validate([
            'studentId' => 'required|exists:patients,student_number',
            'treatmentId' => 'required',
            'medicineId' => 'required',
            'medicineQuantity' => 'required|integer|min:1',
        ]);

        $patient = Patient::where('student_number', $this->studentId)->first();
        $medicine = Medicine::find($this->medicineId);


        if ($medicine->quantity < $this->medicineQuantity) {
            session()->flash('error', 'Not enough medicine in stock.');
            return;
        }


        if ($this->prescriptionId) {
            $prescription = pres::find($this->prescriptionId);
            $prescription->update([
                'patient_id' => $patient->id,
                'treatment_id' => $this->treatmentId,
                'medicine_id' => $this->medicineId,
                'quantity' => $this->medicineQuantity,
            ]);


            $medicine->decrement('quantity', $this->medicineQuantity);
        } else {

            pres::create([
                'patient_id' => $patient->id,
                'treatment_id' => $this->treatmentId,
                'medicine_id' => $this->medicineId,
                'quantity' => $this->medicineQuantity,
            ]);


            $medicine->decrement('quantity', $this->medicineQuantity);
        }


        $this->resetForm();
    }


    public function resetForm()
    {
        $this->reset(['prescriptionId', 'studentId', 'treatmentId', 'medicineId', 'medicineQuantity']);
        $this->addModal = false;
        $this->editModal = false;
    }
    public function edit($id)
    {

        $prescription = pres::find($id);
        $this->prescriptionId = $id;
        $this->studentId = $prescription->patient->student_number;
        $this->treatmentId = $prescription->treatment_id;
        $this->medicineId = $prescription->medicine_id;
        $this->editModal = true;
    }

    public function delete($id)
    {
        $prescription = pres::find($id);
        // $medicine = $prescription->medicine;
        // $medicine->increment('quantity', $prescription->medicine_quantity);

        $prescription->delete();

        $this->prescriptions = pres::with(['patient', 'treatment', 'medicine'])->get();
    }


    public function openAddModal()
    {

        $this->resetForm();
        $this->addModal = true;
    }
}

