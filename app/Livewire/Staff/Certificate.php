<?php

namespace App\Livewire\Staff;

use Livewire\Component;
use App\Models\Prescription;

class Certificate extends Component
{
    public $patientsWithPrescriptions;
    public $search = '';

    public function mount()
    {
        $this->fetchPatientsWithPrescriptions();
    }

    // public function fetchPatientsWithPrescriptions()
    // {
    //     $this->patientsWithPrescriptions = Prescription::with(['patient', 'treatment'])->get();


    //     logger($this->patientsWithPrescriptions);
    // }

    public function fetchPatientsWithPrescriptions()
    {
        $query = Prescription::with(['patient', 'treatment']);

        if (!empty($this->search)) {
            $query->whereHas('patient', function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('student_number', 'like', '%' . $this->search . '%');
            });
        }

        $this->patientsWithPrescriptions = $query->get();
    }

    public function updatedSearch()
    {
        $this->fetchPatientsWithPrescriptions();
    }


    public function printCertificate($id)
    {

        return redirect()->route('certificate.download', ['id' => $id]);

    }

    public function ser(){

    }
    public function render()
    {
        return view('livewire.staff.certificate', [
            'patientsWithPrescriptions' => $this->patientsWithPrescriptions,
        ]);
    }
}
