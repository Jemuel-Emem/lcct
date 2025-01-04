<?php

namespace App\Livewire\Staff;
use App\Models\Patient;
use Carbon\Carbon;
use Livewire\Component;

class Index extends Component
{
    public $todayPatients;
    public $weekPatients;
    public $monthPatients;
    public $yearPatients;
    public $dailyPatients;

    public function mount()
    {
        $today = Carbon::today();
        $startOfWeek = Carbon::now()->startOfWeek();
        $startOfMonth = Carbon::now()->startOfMonth();
        $startOfYear = Carbon::now()->startOfYear();

        $this->todayPatients = Patient::whereDate('date', $today)->count();
        $this->weekPatients = Patient::whereBetween('date', [$startOfWeek, Carbon::now()])->count();
        $this->monthPatients = Patient::whereBetween('date', [$startOfMonth, Carbon::now()])->count();
        $this->yearPatients = Patient::whereBetween('date', [$startOfYear, Carbon::now()])->count();

        $this->dailyPatients = Patient::selectRaw('DATE(date) as date, COUNT(*) as count')
        ->whereBetween('date', [$startOfWeek, Carbon::now()])
        ->groupBy('date')
        ->orderBy('date', 'ASC')
        ->get()
        ->toArray();
    }

    public function render()
    {
        return view('livewire.staff.index', [
            'todayPatients' => $this->todayPatients,
            'weekPatients' => $this->weekPatients,
            'monthPatients' => $this->monthPatients,
            'yearPatients' => $this->yearPatients,
            'dailyPatients' => $this->dailyPatients,
        ]);

    }
}
