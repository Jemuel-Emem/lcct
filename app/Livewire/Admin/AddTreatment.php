<?php

namespace App\Livewire\Admin;
use App\Models\treatment;
use Livewire\Component;

class AddTreatment extends Component
{
    public $treatmentName;
    public $description;
    public $treatmentId;
    public $editModal = false;

    protected $rules = [
        'treatmentName' => 'required|string|max:255',
        'description' => 'nullable|string|max:1000',
    ];

    public function save()
    {
        $this->validate();

        if ($this->treatmentId) {

            $treatment = Treatment::find($this->treatmentId);
            $treatment->update([
                'name' => $this->treatmentName,
                'description' => $this->description,
            ]);
        } else {

            Treatment::create([
                'name' => $this->treatmentName,
                'description' => $this->description,
            ]);
        }

        $this->resetForm();
        $this->editModal = false;
    }

    public function edit($id)
    {
        $treatment = Treatment::find($id);
        $this->treatmentId = $id;
        $this->treatmentName = $treatment->name;
        $this->description = $treatment->description;
        $this->editModal = true;
    }

    public function delete($id)
    {
        $treatment = Treatment::find($id);
        $treatment->delete();
    }

    public function resetForm()
    {
        $this->reset(['treatmentName', 'description', 'treatmentId']);
    }

    public function render()
    {
        return view('livewire.admin.add-treatment', [
            'treatments' => Treatment::all(),
        ]);

    }
}
