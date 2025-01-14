<div>
    <div x-data="{ showDentalModal: @entangle('editModal') }" class="flex items-start justify-end">
        <!-- Add Dental Record Button -->
        {{-- <button
            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 w-64"
            @click="showDentalModal = true">
            Add Dental Record
        </button> --}}

        <div class="flex gap-4 items-center">
            <div>
                <input
                    type="text"
                    wire:model.debounce.300ms="search"
                    placeholder="Search by Student Number or Name"
                    class="border rounded-md p-2"
                />
                <button wire:click="ser" class="bg-green-500 hover:bg-green-600 p-1 w-32 text-white rounded h-10">
                    Search
                </button>
            </div>
            <button
            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 w-64"
            @click="showDentalModal = true">
            Add Medical Record
        </button>
        </div>


        <!-- Modal -->
        <div
            x-show="showDentalModal"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0">

            <div
                class="bg-white rounded-lg shadow-xl w-3/4 max-w-xl"
                @click.away="showDentalModal = false">
                <div class="flex justify-between items-center p-4 border-b">
                    <h2 class="text-lg font-semibold">
                        Add Medical Record
                    </h2>
                    <button
                        class="text-gray-600 hover:text-gray-900"
                        @click="showDentalModal = false">
                        &times;
                    </button>
                </div>

                <!-- Form -->
                <form wire:submit.prevent="saveDentalRecord">
                    <div class="p-4 space-y-4">
                        <!-- Student Number -->
                        <div>
                            <label for="studentNumber" class="block text-sm font-medium">Student Number</label>
                            <input
                                type="text"
                                id="studentNumber"
                                wire:model="studentNumber"
                                wire:keyup="loadStudentName"
                                class="w-full p-2 border rounded-md"
                            />
                            @error('studentNumber') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium">Name</label>
                            <input
                                type="text"
                                id="name"
                                wire:model="name"
                                class="w-full p-2 border rounded-md"
                                readonly
                            />
                            @error('name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Upload Document -->
                        <div>
                            <label for="document" class="block text-sm font-medium">Upload Document</label>
                            <input
                                type="file"
                                id="document"
                                wire:model="document"
                                class="w-full p-2 border rounded-md"
                            />
                            @error('document') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="flex justify-end p-4 border-t">
                        <button
                            type="submit"
                            class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                            Save
                        </button>
                        <button
                            type="button"
                            class="ml-2 px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700"
                            @click="showDentalModal = false; @this.resetForm()">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto mt-4">
        <table class="min-w-full bg-white border border-gray-300 rounded-lg">
            <thead>
                <tr class="bg-gray-200 text-gray-600 text-sm leading-normal">
                    <th class="py-3 px-6 text-left">Student Number</th>
                    <th class="py-3 px-6 text-left">Name</th>
                    <th class="py-3 px-6 text-left">Document</th>
                    <th class="py-3 px-6 text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($dentalRecords as $record)
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6">{{ $record->student_number }}</td>
                        <td class="py-3 px-6">{{ $record->name }}</td>
                        <td class="py-3 px-6">
                            @if($record->document_path)
                                <a href="{{ asset('storage/' . $record->document_path) }}" target="_blank" class="text-blue-600 hover:underline">
                                    View Document
                                </a>
                            @else
                                No Document
                            @endif
                        </td>


                        <td class="py-3 px-6 text-center space-x-2">
                            <button
                                class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 transition"
                                wire:click="editDentalRecord({{ $record->id }})"
                                @click="showDentalModal = true">
                                Edit
                            </button>
                            <button
                                class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition"
                                wire:click="deleteDentalRecord({{ $record->id }})">
                                Delete
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
