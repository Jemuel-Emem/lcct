<?php

namespace App\Livewire\Admin;
use App\Models\Medicine;
use Livewire\Component;

class AddMedicine extends Component
{
    public $medicineName;
    public $description;
    public $medicineId;
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

            $medicine = Medicine::find($this->medicineId);
            $medicine->update([
                'name' => $this->medicineName,
                'description' => $this->description,
                'quantity' => $this->quantity,
            ]);
        } else {

            Medicine::create([
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
        $medicine = Medicine::find($id);
        $this->medicineId = $id;
        $this->medicineName = $medicine->name;
        $this->description = $medicine->description;
        $this->quantity = $medicine->quantity;
        $this->editModal = true;
    }


    public function delete($id)
    {
        Medicine::find($id)->delete();
    }

    public function resetForm()
    {
        $this->reset(['medicineName', 'description', 'quantity', 'medicineId']);
    }
    public function render()
    {
        return view('livewire.admin.add-medicine', [
            'medicines' => Medicine::all(),
        ]);
    }

}
