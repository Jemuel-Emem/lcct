<?php

namespace App\Livewire\Staff;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\User as Student;
use Illuminate\Support\Facades\Storage;
use App\Models\DentalRecord;

class Dental extends Component
{
    use WithFileUploads;

    public $studentNumber;
    public $name;
    public $document;
    public $dentalRecords;
    public $recordId;
    public $editModal = false;
    public $search = '';

    protected $rules = [
        'studentNumber' => 'required|string|max:255',
        'name' => 'required|string|max:255',
        'document' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
    ];

    public function mount()
    {
        $this->fetchRecords();
    }

    public function loadStudentName()
    {
        $student = Student::where('student_number', $this->studentNumber)->first();
        $this->name = $student ? $student->name : '';
    }

    public function fetchRecords()
    {
        $query = DentalRecord::query();

        if (!empty($this->search)) {
            $query->where('student_number', 'like', '%' . $this->search . '%')
                  ->orWhere('name', 'like', '%' . $this->search . '%');
        }

        $this->dentalRecords = $query->get();
    }

    public function ser(){

    }
    public function updatedSearch()
    {
        $this->fetchRecords();
    }

    public function saveDentalRecord()
    {
        $this->validate();

        $data = [
            'student_number' => $this->studentNumber,
            'name' => $this->name,
        ];

        if ($this->document) {
            $data['document_path'] = $this->document->store('dental_documents', 'public');
        }

        if ($this->recordId) {
            $record = DentalRecord::findOrFail($this->recordId);
            $record->update($data);
        } else {
            DentalRecord::create($data);
        }

        $this->resetForm();
        $this->fetchRecords();
        $this->editModal = false;
    }

    public function editDentalRecord($id)
    {
        $record = DentalRecord::findOrFail($id);

        $this->recordId = $record->id;
        $this->studentNumber = $record->student_number;
        $this->name = $record->name;
        $this->document = null; // Reset document for editing

        $this->editModal = true;
    }

    public function deleteDentalRecord($id)
    {
        $record = DentalRecord::findOrFail($id);

        if ($record->document_path && Storage::disk('public')->exists($record->document_path)) {
            Storage::disk('public')->delete($record->document_path);
        }

        $record->delete();
        $this->fetchRecords();
    }

    public function resetForm()
    {
        $this->reset(['studentNumber', 'name', 'document', 'recordId']);
    }

    public function render()
    {
        return view('livewire.staff.dental');
    }
}
