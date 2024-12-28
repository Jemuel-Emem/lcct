<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;

class Students extends Component
{
    public $userId, $name, $email, $password, $year, $course, $section, $student_number;
    public $sex, $number, $grade_section, $guardian, $guardian_number , $age, $address, $civil_status;
    public $editModal = false;

    public function resetForm()
    {
        $this->userId = null;
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->age = '';
        $this->address = '';
        $this->civil_status = '';
        $this->year = '';
        $this->course = '';
        $this->section = '';
        $this->student_number = '';
        $this->sex = '';
        $this->number = '';
        $this->grade_section = '';
        $this->guardian = '';
        $this->guardian_number = '';
        $this->resetValidation();
        $this->resetErrorBag();
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->userId = $user->id;
        $this->student_number = $user->student_number;
        $this->name = $user->name;
        $this->age = $user->age;
        $this->address = $user->address;
        $this->civil_status = $user->civil_status;
        $this->email = $user->email;
        $this->year = $user->year;
        $this->course = $user->course;
        $this->section = $user->section;
        $this->sex = $user->sex;
        $this->number = $user->number;
        $this->grade_section = $user->grade_section;
        $this->guardian = $user->guardian;
        $this->guardian_number = $user->guardian_number;

        $this->password = '';
        $this->editModal = true;
    }

    public function save()
    {
        $data = $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->userId,
            'password' => 'nullable|min:6',
            'year' => 'nullable|string',
            'age' => 'nullable|string',
            'address' => 'nullable|string',
            'civil_status' => 'nullable|string',
            'course' => 'nullable|string',
            'grade_section' => 'nullable|string',
            'student_number' => 'nullable|string',
            'sex' => 'nullable|string',
            'number' => 'nullable|string',
            'grade_section' => 'nullable|string',
            'guardian' => 'nullable|string',
            'guardian_number' => 'nullable|string',
        ]);

        if (!empty($this->password)) {
            $data['password'] = Hash::make($this->password);
        } else {
            unset($data['password']);
        }

        $data['is_admin'] = 0;

        User::updateOrCreate(
            ['id' => $this->userId],
            $data
        );

        session()->flash('message', $this->userId ? 'Student updated successfully!' : 'Student added successfully!');
        $this->editModal = false;
        $this->resetForm();
    }

    public function delete($id)
    {
        User::destroy($id);
    }

    public function render()
    {
        $users = User::where('is_admin', 0)->get();
        return view('livewire.admin.students', compact('users'));
    }
}
