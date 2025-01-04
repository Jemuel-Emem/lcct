<div>

    <div x-data="{ showModal: @entangle('editModal') }" class="mb-6">
        <button class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">
            <a href="{{ route('admin.user') }}">Back</a>
        </button>
        <button class="mb-4 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700" @click="showModal = true">
            Add Student
        </button>
        <div
        x-show="showModal"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 "
        x-transition:enter="transition ease-out duration-300"
        x-transition:leave="transition ease-in duration-200"
    >
        <div
            class="bg-white rounded-lg shadow-xl w-3/4 max-w-3xl "
            @click.away="showModal = false"
        >
            <div class="flex justify-between items-center p-4 border-b">
                <h2 class="text-lg font-semibold">{{ $userId ? 'Edit User' : 'Add User' }}</h2>
                <button class="text-gray-600 hover:text-gray-900" @click="showModal = false">
                    &times;
                </button>
            </div>

            <form wire:submit.prevent="save">
                <div class="p-4 grid grid-cols-2 gap-4">
                    <!-- Left Column -->
                    <div>
                        <label for="student_number" class="block text-sm font-medium">Student Number</label>
                        <input type="text" id="student_number" wire:model="student_number" class="w-full p-2 border rounded-md" />
                        @error('student_number') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="name" class="block text-sm font-medium">Name</label>
                        <input type="text" placeholder="last name, first name,middle name" id="name" wire:model="name" class="w-full p-2 border rounded-md" />
                        @error('name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="age" class="block text-sm font-medium">Age</label>
                        <input type="text" id="age" wire:model="age" class="w-full p-2 border rounded-md" />
                        @error('age') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="address" class="block text-sm font-medium">Address</label>
                        <input type="text" id="address" wire:model="address" class="w-full p-2 border rounded-md" />
                        @error('address') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="civil_status" class="block text-sm font-medium">Civil Status</label>
                        <input type="text" id="civil_status" wire:model="civil_status" class="w-full p-2 border rounded-md" />
                        @error('civil_status') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
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

                    <!-- Right Column -->
                    <div>
                        <label for="sex" class="block text-sm font-medium">Sex</label>
                        <input type="text" id="sex" wire:model="sex" class="w-full p-2 border rounded-md" />
                    </div>

                    <div>
                        <label for="number" class="block text-sm font-medium">Phone Number</label>
                        <input type="text" id="number" wire:model="number" class="w-full p-2 border rounded-md" />
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
                        <label for="grade_section" class="block text-sm font-medium">Grade Section</label>
                        <input type="text" id="grade_section" wire:model="grade_section" class="w-full p-2 border rounded-md" />
                    </div>

                    <div>
                        <label for="guardian" class="block text-sm font-medium">Guardian</label>
                        <input type="text" id="guardian" wire:model="guardian" class="w-full p-2 border rounded-md" />
                    </div>

                    <div>
                        <label for="guardian_number" class="block text-sm font-medium">Guardian's Phone Number</label>
                        <input type="text" id="guardian_number" wire:model="guardian_number" class="w-full p-2 border rounded-md" />
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
 <!-- Users Table -->
 <div class="overflow-x-auto">
    <table class="min-w-full bg-white border border-gray-300 rounded-md shadow-md">
        <thead class="bg-gray-200">
            <tr class="text-left text-sm font-medium text-gray-700">
                <th class="py-3 px-4 border-b">Student Number</th>
                <th class="py-3 px-4 border-b">Name</th>
                <th class="py-3 px-4 border-b">Age</th>
                <th class="py-3 px-4 border-b">Address</th>
                <th class="py-3 px-4 border-b">Civil Status</th>
                <th class="py-3 px-4 border-b">Email</th>
                <th class="py-3 px-4 border-b">Year</th>
                <th class="py-3 px-4 border-b">Section</th>
                <th class="py-3 px-4 border-b">Course</th>
                <th class="py-3 px-4 border-b">Sex</th>
                <th class="py-3 px-4 border-b">Phone</th>
                <th class="py-3 px-4 border-b">Guardian</th>
                <th class="py-3 px-4 border-b">Guardian's Phone</th>
                <th class="py-3 px-4 border-b">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr class="hover:bg-gray-50">
                    <td class="py-3 px-4 border-b">{{ $user->student_number }}</td>
                    <td class="py-3 px-4 border-b">{{ $user->name }}</td>
                    <td class="py-3 px-4 border-b">{{ $user->age }}</td>
                    <td class="py-3 px-4 border-b">{{ $user->address }}</td>
                    <td class="py-3 px-4 border-b">{{ $user->civil_status }}</td>
                    <td class="py-3 px-4 border-b">{{ $user->email }}</td>
                    <td class="py-3 px-4 border-b">{{ $user->year }}</td>
                    <td class="py-3 px-4 border-b">{{ $user->grade_section }}</td>
                    <td class="py-3 px-4 border-b">{{ $user->course }}</td>
                    <td class="py-3 px-4 border-b">{{ $user->sex }}</td>
                    <td class="py-3 px-4 border-b">{{ $user->number }}</td>
                    <td class="py-3 px-4 border-b">{{ $user->guardian }}</td>
                    <td class="py-3 px-4 border-b">{{ $user->guardian_number }}</td>
                    <td class="flex py-3 px-4 border-b space-x-2">
                        <button wire:click="edit({{ $user->id }})" class="px-3 py-1  bg-yellow-500 text-white rounded-md hover:bg-yellow-600 transition">
                            Edit
                        </button>
                        <button wire:click="delete({{ $user->id }})" class="px-3 py-1  bg-red-500 text-white rounded-md hover:bg-red-600 transition">
                            Delete
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

</div>
