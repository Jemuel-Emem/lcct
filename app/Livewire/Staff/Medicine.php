<?php

namespace App\Livewire\Staff;
use App\Models\Medicine as med;
use Livewire\Component;

class Medicine extends Component
{
    public $medicineName;
    public $description;
    public $medicineId;
    public $search = '';
    public $quantity;
    public $editModal = false;

    protected $rules = [
        'medicineName' => 'required|string|max:255',
        'description' => 'nullable|string|max:1000',
    ];

    public function save()
    {
        $this->validate();

        if ($this->medicineId) {

            $medicine = med::find($this->medicineId);
            $medicine->update([
                'name' => $this->medicineName,
                'description' => $this->description,
                'quantity' => $this->quantity,
            ]);
        } else {

            med::create([
                'name' => $this->medicineName,
                'description' => $this->description,
                'quantity' => $this->quantity,
            ]);
        }

        $this->resetForm();
        $this->editModal = false;
    }

    public function edit($id)
    {
        $medicine = med::find($id);
        $this->medicineId = $id;
        $this->medicineName = $medicine->name;
        $this->description = $medicine->description;
        $this->quantity = $medicine->quantity;
        $this->editModal = true;
    }


    public function delete($id)
    {
        med::find($id)->delete();
    }

    public function resetForm()
    {
        $this->reset(['medicineName', 'description', 'quantity', 'medicineId']);
    }
    // public function render()
    // {
    //     return view('livewire.staff.medicine', [
    //         'medicines' => med::all(),
    //     ]);
    // }

    public function ser(){

    }
    public function render()
    {
        $query = Med::query();

        if (!empty($this->search)) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        return view('livewire.staff.medicine', [
            'medicines' => $query->get(),
        ]);
    }


}
