<?php

namespace App\Livewire\Admin;

use App\Models\Patient;
use Livewire\Component;
use Livewire\WithPagination;

class History extends Component
{
    use WithPagination;

    public function render()
    {
        $patients = Patient::with(['user:name,student_number', 'treatment:name,id'])
            ->orderBy('date', 'desc')
            ->paginate(10);

        return view('livewire.admin.history', [
            'patients' => $patients,
        ]);
    }
}
