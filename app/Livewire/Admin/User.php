<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User as users;
use Illuminate\Support\Facades\Hash;

class User extends Component
{
    public $userId;
    public $name;
    public $email;
    public $password;
    public $is_admin;

    public $editModal = false;

    public function render()
    {
        return view('livewire.admin.user', [
            'users' => users::all(),
        ]);
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->userId,
            'password' => $this->userId ? 'nullable|min:6' : 'required|min:6',
            'is_admin' => 'required|in:0,2,3',
        ]);

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'is_admin' => $this->is_admin,
        ];

        if ($this->password) {
            $data['password'] = Hash::make($this->password);
        }

        if ($this->userId) {
            $user = users::findOrFail($this->userId);
            $user->update($data);
        } else {
            users::create($data);
        }

        $this->resetForm();
    }

    public function edit($id)
    {
        $user = users::findOrFail($id);
        $this->userId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->is_admin = $user->is_admin;

        $this->editModal = true;
    }

    public function delete($id)
    {
        users::findOrFail($id)->delete();
    }

    public function resetForm()
    {
        $this->reset(['userId', 'name', 'email', 'password', 'is_admin', 'editModal']);
    }
}
