<div>

    <div x-data="{ showModal: @entangle('editModal') }" class="mb-6">
        <button class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-graye-700" >
       <a href="{{ route('admin.user') }}">    Back</a>
        </button>
        <button class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700" @click="showModal = true">
            Add Patients
        </button>

        <div
            x-show="showModal"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
            x-transition:enter="transition ease-out duration-300"
            x-transition:leave="transition ease-in duration-200"
        >
            <div
                class="bg-white rounded-lg shadow-xl w-3/4 max-w-md"
                @click.away="showModal = false"
            >
                <div class="flex justify-between items-center p-4 border-b">
                    <h2 class="text-lg font-semibold">{{ $userId ? 'Edit User' : 'Add User' }}</h2>
                    <button class="text-gray-600 hover:text-gray-900" @click="showModal = false">
                        &times;
                    </button>
                </div>

                <form wire:submit.prevent="save">
                    <div class="p-4 space-y-4">

                        <div>
                            <label for="name" class="block text-sm font-medium">Student Number</label>
                            <input type="text" id="name" wire:model="student_number" class="w-full p-2 border rounded-md" />
                            @error('student_number') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label for="name" class="block text-sm font-medium">Name</label>
                            <input type="text" id="name" wire:model="name" class="w-full p-2 border rounded-md" />
                            @error('name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium">Email</label>
                            <input type="email" id="email" wire:model="email" class="w-full p-2 border rounded-md" />
                            @error('email') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium">Password</label>
                            <input
                                type="password"
                                id="password"
                                wire:model="password"
                                class="w-full p-2 border rounded-md"
                                placeholder="Enter new password (leave blank to keep current password)"
                            />
                            @error('password') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>


                        <div>
                            <label for="year" class="block text-sm font-medium">Year</label>
                            <input type="text" id="year" wire:model="year" class="w-full p-2 border rounded-md" />
                        </div>

                        <div>
                            <label for="course" class="block text-sm font-medium">Course</label>
                            <input type="text" id="course" wire:model="course" class="w-full p-2 border rounded-md" />
                        </div>

                        <div>
                            <label for="section" class="block text-sm font-medium">Section</label>
                            <input type="text" id="section" wire:model="section" class="w-full p-2 border rounded-md" />
                        </div>
                    </div>

                    <div class="flex justify-end p-4 border-t">
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                            {{ $userId ? 'Update' : 'Save' }}
                        </button>
                        <button type="button" class="ml-2 px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700"
                                @click="showModal = false; @this.resetForm()">
                            Cancel
                        </button>
                    </div>
                </form>

            </div>
        </div>

    </div>
 <!-- Users Table -->
 <div class="overflow-x-auto">
    <table class="min-w-full bg-white border border-gray-300 rounded-md shadow-md">
        <thead class="bg-gray-200">
            <tr class="text-left text-sm font-medium text-gray-700">
                <th class="py-3 px-4 border-b">Student Number</th>
                <th class="py-3 px-4 border-b">Name</th>
                <th class="py-3 px-4 border-b">Email</th>
                <th class="py-3 px-4 border-b">Year</th>
                <th class="py-3 px-4 border-b">Section</th>
                <th class="py-3 px-4 border-b">Course</th>

                <th class="py-3 px-4 border-b">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr class="hover:bg-gray-50">
                    <td class="py-3 px-4 border-b">{{ $user->student_number }}</td>
                    <td class="py-3 px-4 border-b">{{ $user->name }}</td>
                    <td class="py-3 px-4 border-b">{{ $user->email }}</td>
                    <td class="py-3 px-4 border-b">{{ $user->year }}</td>
                    <td class="py-3 px-4 border-b">{{ $user->section }}</td>
                    <td class="py-3 px-4 border-b">{{ $user->course }}</td>

                    <td class="py-3 px-4 border-b space-x-2">
                        <button wire:click="edit({{ $user->id }})" class="px-3 py-1 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 transition">
                            Edit
                        </button>
                        <button wire:click="delete({{ $user->id }})" class="px-3 py-1 bg-red-500 text-white rounded-md hover:bg-red-600 transition">
                            Delete
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

</div>
