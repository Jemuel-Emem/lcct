<div>
    <div>

        <div class="mb-4">
            <button wire:click="toggleModal" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Create Exit Pass
            </button>
        </div>
        <div class="mt-8">

            <table class="min-w-full border-collapse border border-gray-300">
                <thead>
                    <tr>
                        <th class="border px-4 py-2">Student Number</th>
                        <th class="border px-4 py-2">Name</th>
                        <th class="border px-4 py-2">Destination</th>
                        <th class="border px-4 py-2">Responsible Person</th>
                        <th class="border px-4 py-2">Exit Date</th>
                        <th class="border px-4 py-2">Exit Time</th>
                        <th class="border px-4 py-2">QR Code</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($exitPasses as $exitPass)
                        <tr>
                            <td class="border px-4 py-2">{{ $exitPass->student_number }}</td>
                            <td class="border px-4 py-2">{{ $exitPass->student->name ?? 'N/A' }}</td>
                            <td class="border px-4 py-2">{{ $exitPass->destination }}</td>
                            <td class="border px-4 py-2">{{ $exitPass->responsible_person }}</td>
                            <td class="border px-4 py-2">{{ $exitPass->exit_date }}</td>
                            <td class="border px-4 py-2">{{ $exitPass->exit_time }}</td>
                            <td class="border px-4 py-2">
                                <a href="{{ asset('storage/' . $exitPass->qr) }}" target="_blank">
                                    <img src="{{ asset('storage/' . $exitPass->qr) }}" alt="QR Code" class="w-16 h-16">
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- Modal -->
        <div id="createModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center {{ $isModalOpen ? '' : 'hidden' }}">
            <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-3xl">
                <h2 class="text-lg font-semibold mb-4">Create Exit Pass</h2>
                <form wire:submit.prevent="createExitPass">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="studentNumber" class="block text-sm font-medium">Student Number</label>
                            <input
                                type="text"
                                id="studentNumber"
                                wire:model="studentNumber"
                                wire:keyup="fetchStudentDetails"
                                class="w-full p-2 border rounded-md"
                            />
                            @error('studentNumber') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Name Field -->
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

                        <!-- Grade/Section Field -->
                        <div>
                            <label for="gradeSection" class="block text-sm font-medium">Grade/Section</label>
                            <input
                                type="text"
                                id="gradeSection"
                                wire:model="gradeSection"
                                class="w-full p-2 border rounded-md"
                                readonly
                            />
                            @error('gradeSection') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="diagnose" class="block text-sm font-medium">Diagnose</label>
                            <textarea id="diagnose" wire:model="diagnose" class="w-full p-2 border rounded-md"></textarea>
                            @error('diagnose') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Destination -->
                        <div class="mb-4">
                            <label for="destination" class="block text-sm font-medium">Destination</label>
                            <input type="text" id="destination" wire:model="destination" class="w-full border border-gray-300 rounded-lg p-2">
                        </div>

                        <!-- Person Responsible -->
                        <div class="mb-4">
                            <label for="responsible_person" class="block text-sm font-medium">Person Responsible</label>
                            <input type="text" id="responsible_person" wire:model="responsible_person" class="w-full border border-gray-300 rounded-lg p-2">
                        </div>

                        <div class="mb-4">
                            <label for="date" class="block text-sm font-medium">Date</label>
                            <input
                                type="date"
                                id="date"
                                wire:model="date"
                                class="w-full border border-gray-300 rounded-lg p-2"
                            />
                        </div>

                        <div class="mb-4">
                            <label for="time" class="block text-sm font-medium">Time</label>
                            <input
                                type="time"
                                id="time"
                                wire:model="time"
                                class="w-full border border-gray-300 rounded-lg p-2"
                            />
                        </div>


                        <div class="mb-4 col-span-2">
                            <label for="relationship" class="block text-sm font-medium">Relationship to Student</label>
                            <input type="text" id="relationship" wire:model="relationship" class="w-full border border-gray-300 rounded-lg p-2">
                        </div>
                    </div>

                    <div class="flex justify-end mt-4">
                        <button type="button" wire:click="toggleModal" class="px-4 py-2 bg-gray-300 rounded-lg mr-2">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
