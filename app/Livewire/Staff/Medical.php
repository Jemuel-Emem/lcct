<?php

namespace App\Livewire\Staff;
use Livewire\WithFileUploads;
use App\Models\User as Student;
use Illuminate\Support\Facades\Storage;
use App\Models\MedicalRecord;
use Livewire\Component;

class Medical extends Component
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

    // public function fetchRecords()
    // {
    //     $this->dentalRecords = MedicalRecord::all();
    // }

    public function fetchRecords()
    {
        $query = MedicalRecord::query();

        if (!empty($this->search)) {
            $query->where('student_number', 'like', '%' . $this->search . '%');
        }

        $this->dentalRecords = $query->get();
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
            $record = MedicalRecord::findOrFail($this->recordId);
            $record->update($data);
        } else {
            MedicalRecord::create($data);
        }

        $this->resetForm();
        $this->fetchRecords();
        $this->editModal = false;
    }

    public function editDentalRecord($id)
    {
        $record = MedicalRecord::findOrFail($id);

        $this->recordId = $record->id;
        $this->studentNumber = $record->student_number;
        $this->name = $record->name;
        $this->document = null; // Reset document for editing

        $this->editModal = true;
    }

    public function deleteDentalRecord($id)
    {
        $record = MedicalRecord::findOrFail($id);

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

    public function updatedSearch()
    {
        $this->fetchRecords();
    }
public function ser(){

}
    public function render()
    {
        return view('livewire.staff.medical');
    }
}
