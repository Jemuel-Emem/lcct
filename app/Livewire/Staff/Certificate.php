<?php

namespace App\Livewire\Staff;

use Livewire\Component;
use App\Models\Prescription;

class Certificate extends Component
{
    public $patientsWithPrescriptions;

    public function mount()
    {
        $this->fetchPatientsWithPrescriptions();
    }

    public function fetchPatientsWithPrescriptions()
    {
        $this->patientsWithPrescriptions = Prescription::with(['patient', 'treatment'])->get();


        logger($this->patientsWithPrescriptions);
    }

    public function printCertificate($id)
    {

        return redirect()->route('certificate.download', ['id' => $id]);

    }

    public function render()
    {
        return view('livewire.staff.certificate', [
            'patientsWithPrescriptions' => $this->patientsWithPrescriptions,
        ]);
    }
}
