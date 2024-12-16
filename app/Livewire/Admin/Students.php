<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;

class Students extends Component
{
    public $userId, $name, $email, $password, $year, $course, $section, $student_number;
    public $editModal = false; // Add this property to control modal visibility
    public function resetForm()
    {
        $this->userId = null;
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->year = '';
        $this->course = '';
        $this->section = '';
        $this->student_number = '';
        $this->resetValidation();
        $this->resetErrorBag();
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->userId = $user->id;
        $this->student_number = $user->student_number;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->year = $user->year;
        $this->course = $user->course;
        $this->section = $user->section;

        $this->password = '';
        $this->editModal = true; // Show the modal after data is loaded
    }

    public function save()
    {
        $data = $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->userId,
            'password' => 'nullable|min:6',
            'year' => 'nullable|string',
            'course' => 'nullable|string',
            'section' => 'nullable|string',
            'student_number' => 'nullable|string',
        ]);

        if (!empty($this->password)) {
            $data['password'] = Hash::make($this->password);
        } else {

            unset($data['password']);
        }

        $data['is_admin'] = 0; // Default is_admin as 0

        User::updateOrCreate(
            ['id' => $this->userId],
            $data
        );

        session()->flash('message', $this->userId ? 'Student updated successfully!' : 'Student added successfully!');

        $this->editModal = false; // Hide the modal after saving
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
