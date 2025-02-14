<div>
    <div x-data="{ showMedicalModal: @entangle('editModal') }" class="flex items-start justify-end">
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
            @click="showMedicalModal = true">
            Add Medical Record
        </button>
        </div>


        <!-- Modal -->
        <div
            x-show="showMedicalModal"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0">

            <div
                class="bg-white rounded-lg shadow-xl w-3/4 max-w-xl"
                @click.away="showMedicalModal = false">
                <div class="flex justify-between items-center p-4 border-b">
                    <h2 class="text-lg font-semibold">
                        Add Medical Record
                    </h2>
                    <button
                        class="text-gray-600 hover:text-gray-900"
                        @click="showMedicalModal = false">
                        &times;
                    </button>
                </div>

                <!-- Form -->
                <form wire:submit.prevent="saveMedicalRecord">
                    <div class="grid grid-cols-3 gap-4 p-4">

                        <div>
                            <label for="studentNumber" class="block text-sm font-medium">Student Number</label>
                            <input type="text" id="studentNumber" wire:model="studentNumber" wire:keyup="loadStudentName" class="w-full p-2 border rounded-md" />
                            @error('studentNumber') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Name (Auto-filled) -->
                        <div>
                            <label for="name" class="block text-sm font-medium">Name</label>
                            <input type="text" id="name" wire:model="name" class="w-full p-2 border rounded-md" readonly />
                        </div>

                        <!-- Sex -->
                        <div>
                            <label for="sex" class="block text-sm font-medium">Sex</label>
                            <input type="text" id="sex" wire:model="sex" class="w-full p-2 border rounded-md" readonly />
                        </div>

                        <!-- Date of Birth -->
                        <div>
                            <label for="dateOfBirth" class="block text-sm font-medium">Date of Birth</label>
                            <input type="date" id="dateOfBirth" wire:model="dateOfBirth" class="w-full p-2 border rounded-md" />
                        </div>

                        <!-- Address -->
                        <div>
                            <label for="address" class="block text-sm font-medium">Address</label>
                            <input type="text" id="address" wire:model="address" class="w-full p-2 border rounded-md" />
                        </div>

                        <!-- Grade -->
                        <div>
                            <label for="grade" class="block text-sm font-medium">Grade</label>
                            <input type="text" id="grade" wire:model="grade" class="w-full p-2 border rounded-md" />
                        </div>

                        <!-- Age (Auto-calculated) -->
                        <div>
                            <label for="age" class="block text-sm font-medium">Age</label>
                            <input type="text" id="age" wire:model="age" class="w-full p-2 border rounded-md" readonly />
                        </div>

                        <!-- Height -->
                        <div>
                            <label for="height" class="block text-sm font-medium">Height</label>
                            <input type="text" id="height" wire:model="height" class="w-full p-2 border rounded-md" />
                        </div>

                        <!-- Weight -->
                        <div>
                            <label for="weight" class="block text-sm font-medium">Weight</label>
                            <input type="text" id="weight" wire:model="weight" class="w-full p-2 border rounded-md" />
                        </div>

                        <!-- Vision -->
                        <div>
                            <label for="vision" class="block text-sm font-medium">Vision</label>
                            <input type="text" id="vision" wire:model="vision" class="w-full p-2 border rounded-md" />
                        </div>

                        <!-- Blood Pressure (BP) -->
                        <div>
                            <label for="bp" class="block text-sm font-medium">Blood Pressure</label>
                            <input type="text" id="bp" wire:model="bp" class="w-full p-2 border rounded-md" />
                        </div>

                        <!-- Name of Father -->
                        <div>
                            <label for="nameoffather" class="block text-sm font-medium">Father's Name</label>
                            <input type="text" id="nameoffather" wire:model="nameoffather" class="w-full p-2 border rounded-md" />
                        </div>

                        <!-- Father's Occupation -->
                        <div>
                            <label for="fatheroccupation" class="block text-sm font-medium">Father's Occupation</label>
                            <input type="text" id="fatheroccupation" wire:model="fatheroccupation" class="w-full p-2 border rounded-md" />
                        </div>

                        <!-- Name of Mother -->
                        <div>
                            <label for="nameofmother" class="block text-sm font-medium">Mother's Name</label>
                            <input type="text" id="nameofmother" wire:model="nameofmother" class="w-full p-2 border rounded-md" />
                        </div>

                        <!-- Mother's Occupation -->
                        <div>
                            <label for="motheroccupation" class="block text-sm font-medium">Mother's Occupation</label>
                            <input type="text" id="motheroccupation" wire:model="motheroccupation" class="w-full p-2 border rounded-md" />
                        </div>

                        <!-- Upload Document (Full Width) -->
                        <div class="col-span-2">
                            <label for="document" class="block text-sm font-medium">Upload Document</label>
                            <input type="file" id="document" wire:model="document" class="w-full p-2 border rounded-md" />
                        </div>
                    </div>

                    <div class="flex  p-4 border-t">
                        <button
                            type="submit"
                            class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                            Save
                        </button>
                        <button
                            type="button"
                            class="ml-2 px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700"
                            @click="showMedicalModal = false; @this.resetForm()">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="overflow-x-auto mt-4">
        <table class="min-w-full bg-white border border-gray-300 rounded-lg">
            <thead>
                <tr class="bg-gray-200 text-gray-600 text-sm leading-normal">
                    <th class="py-3 px-6 text-left">Student Number</th>
                    <th class="py-3 px-6 text-left">Name</th>
                    <th class="py-3 px-6 text-left">Sex</th>
                    <th class="py-3 px-6 text-left">Date of Birth</th>
                    <th class="py-3 px-6 text-left">Address</th>
                    <th class="py-3 px-6 text-left">Grade</th>
                    <th class="py-3 px-6 text-left">Age</th>
                    <th class="py-3 px-6 text-left">Height</th>
                    <th class="py-3 px-6 text-left">Weight</th>
                    <th class="py-3 px-6 text-left">Vision</th>
                    <th class="py-3 px-6 text-left">BP</th>
                    <th class="py-3 px-6 text-left">Father's Name</th>
                    <th class="py-3 px-6 text-left">Father's Occupation</th>
                    <th class="py-3 px-6 text-left">Mother's Name</th>
                    <th class="py-3 px-6 text-left">Mother's Occupation</th>
                    <th class="py-3 px-6 text-left">Document</th>
                    <th class="py-3 px-6 text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($dentalRecords as $record)
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6">{{ $record->student_number }}</td>
                        <td class="py-3 px-6">{{ $record->name }}</td>
                        <td class="py-3 px-6">{{ $record->sex }}</td>
                        <td class="py-3 px-6">{{ $record->date_of_birth }}</td>
                        <td class="py-3 px-6">{{ $record->address }}</td>
                        <td class="py-3 px-6">{{ $record->grade }}</td>
                        <td class="py-3 px-6">{{ $record->age }}</td>
                        <td class="py-3 px-6">{{ $record->height }}</td>
                        <td class="py-3 px-6">{{ $record->weight }}</td>
                        <td class="py-3 px-6">{{ $record->vision }}</td>
                        <td class="py-3 px-6">{{ $record->bp }}</td>
                        <td class="py-3 px-6">{{ $record->nameoffather }}</td>
                        <td class="py-3 px-6">{{ $record->fatheroccupation }}</td>
                        <td class="py-3 px-6">{{ $record->nameofmother }}</td>
                        <td class="py-3 px-6">{{ $record->motheroccupation }}</td>
                        <td class="py-3 px-6">
                            @if($record->document_path)
                                <button
                                    class="text-blue-600 hover:underline"
                                    wire:click="showDocument('{{ asset('storage/' . $record->document_path) }}')">
                                    View Document
                                </button>
                            @else
                                No Document
                            @endif
                        </td>
                        <td class="py-3 px-6 text-center space-x-2 flex">
                            <button
                                class="w-20 px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 transition"
                                wire:click="editMedicalRecord({{ $record->id }})"
                                @click="showMedicalModal = true">
                                Edit
                            </button>
                            <button
                                class="w-20 px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition"
                                wire:click="deleteMedicalRecord({{ $record->id }})">
                                Delete
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @if($showModal)
    <div class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50">
        <div class="bg-white p-5 rounded-lg shadow-lg w-full max-w-3xl h-[80vh] flex flex-col relative">
            <!-- Close Button -->
            <button wire:click="closeModal" class="absolute top-3 right-3 text-gray-600 hover:text-gray-800 text-xl">
                ✖
            </button>

            <!-- Title -->
            <h2 class="text-lg font-semibold mb-3 text-center">Document Preview</h2>

            <!-- Document Viewer -->
            <div class="flex-grow overflow-hidden">
                <iframe id="documentFrame" src="{{ $documentUrl }}" class="w-full h-full border rounded"></iframe>
            </div>

            <!-- Action Buttons -->
            <div class="mt-4 flex justify-between">
                <button
                    onclick="printDocument()"
                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    Print
                </button>
                <button
                    wire:click="closeModal"
                    class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">
                    Close
                </button>
            </div>
        </div>
    </div>




@endif
<script>
    function printDocument() {
        let iframe = document.getElementById('documentFrame');
        iframe.contentWindow.print();
    }
</script>
</div>
