<?php

namespace App\Livewire\Staff;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\User as Student;
use Illuminate\Support\Facades\Storage;
use App\Models\MedicalRecord;

class Medical extends Component
{
    use WithFileUploads;
    public $documentUrl;
    public $showModal = false;
    public $studentNumber;
    public $name;
    public $address;
    public $sex;
    public $dateOfBirth;
    public $grade;
    public $age;
    public $height;
    public $weight;
    public $vision;
    public $nameoffather;
    public $nameofmother;
    public $motheroccupation;
    public $fatheroccupation;
    public $bp;
    public $document;
    public $dentalRecords;
    public $recordId;
    public $editModal = false;
    public $search = '';
    public $year_uploaded;

    protected $rules = [
        'studentNumber' => 'required|string|max:255',
        'name' => 'required|string|max:255',
        'sex' => 'required|string|max:10',
        'dateOfBirth' => 'required|date',
        'grade' => 'required|string|max:255',
        'age' => 'required|integer',
        'height' => 'required|string|max:255',
        'weight' => 'required|string|max:255',
        'vision' => 'required|string|max:255',
        'bp' => 'required|string|max:255',
        'document' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
    ];

    public function showDocument($url)
    {
        $this->documentUrl = $url;
        $this->showModal = true;
    }
    public function closeModal()
    {
        $this->showModal = false;
    }
    public function mount()
    {
        $this->fetchRecords();
    }

    public function loadStudentName()
    {
        $student = Student::where('student_number', $this->studentNumber)->first();
        $this->name = $student ? $student->name : '';

        $this->sex= $student ? $student->sex: '';
        $this->age= $student ? $student->age: '';
        $this->address= $student ? $student->address: '';
        $this->grade= $student ? $student->grade_section: '';
    }

    public function fetchRecords()
    {
        $query = MedicalRecord::query();

        if (!empty($this->search)) {
            $query->where('student_number', 'like', '%' . $this->search . '%')
                  ->orWhere('name', 'like', '%' . $this->search . '%');
        }

        $this->dentalRecords = $query->get();
    }

    public function saveMedicalRecord()
    {
        $this->validate();

        $data = [
            'student_number' => $this->studentNumber,
            'name' => $this->name,
            'address' => $this->address,
            'sex' => $this->sex,
            'date_of_birth' => $this->dateOfBirth,
            'grade' => $this->grade,
            'age' => $this->age,
            'height' => $this->height,
            'weight' => $this->weight,
            'vision' => $this->vision,
            'bp' => $this->bp,
            'nameoffather' => $this->nameoffather,
            'fatheroccupation' => $this->fatheroccupation,
            'nameofmother' => $this->nameofmother,
            'motheroccupation' => $this->motheroccupation,
            'year_uploaded' => now()->year, // Automatically set the upload year
        ];

        if ($this->document) {
            $data['document_path'] = $this->document->store('medical_records', 'public');
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

    public function editMedicalRecord($id)
    {
        $record = MedicalRecord::findOrFail($id);

        $this->recordId = $record->id;
        $this->studentNumber = $record->student_number;
        $this->name = $record->name;
        $this->sex = $record->sex;
        $this->dateOfBirth = $record->date_of_birth;
        $this->grade = $record->grade;
        $this->age = $record->age;
        $this->height = $record->height;
        $this->weight = $record->weight;
        $this->vision = $record->vision;
        $this->bp = $record->bp;
        $this->year_uploaded = $record->year_uploaded;
        $this->document = null; // Reset document input

        $this->editModal = true;
    }

    public function deleteMedicalRecord($id)
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
        $this->reset([
            'studentNumber', 'name', 'sex', 'dateOfBirth', 'grade', 'age', 'height',
            'weight', 'vision', 'bp', 'document', 'recordId', 'year_uploaded'
        ]);
    }

    public function updatedSearch()
    {
        $this->fetchRecords();
    }

    public function render()
    {
        return view('livewire.staff.medical');
    }
}
