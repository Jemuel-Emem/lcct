<?php
namespace App\Livewire\Staff;

use App\Models\Patient;
use Livewire\Component;
use Livewire\WithPagination;

class Attendance extends Component
{
    use WithPagination;

    public $search = ''; // Search input field

    protected $queryString = ['search'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function searchh(){

    }

    public function render()
    {
        $patients = Patient::with('user')
            ->whereNotNull('time_out')
            ->where(function ($query) {
                $query->where('student_number', 'like', '%' . $this->search . '%')
                      ->orWhereHas('user', function ($subQuery) {
                          $subQuery->where('name', 'like', '%' . $this->search . '%');
                      });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('livewire.staff.attendance', [
            'patients' => $patients,
        ]);
    }
}
