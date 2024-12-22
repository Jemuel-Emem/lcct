<div>

    <div x-data="{ showModal: @entangle('editModal') }" class="flex items-start justify-end">

        <button
            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 w-64"
            @click="showModal = true">
            Add Patient
        </button>

        <div
            x-show="showModal"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0">

            <div
                class="bg-white rounded-lg shadow-xl w-3/4 max-w-xl"
                @click.away="showModal = false">
                <div class="flex justify-between items-center p-4 border-b">
                    <h2 class="text-lg font-semibold">{{ $patientId ? 'Edit Patient' : 'Add Patient' }}</h2>
                    <button
                        class="text-gray-600 hover:text-gray-900"
                        @click="showModal = false">
                        &times;
                    </button>
                </div>

                <div>
                    <div>
                        <form wire:submit.prevent="save">
                            <div class="p-4 space-y-4">
                                <!-- Student Number Field -->
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

                                <!-- Diagnose Field -->
                                <div>
                                    <label for="diagnose" class="block text-sm font-medium">Diagnose</label>
                                    <textarea id="diagnose" wire:model="diagnose" class="w-full p-2 border rounded-md"></textarea>
                                    @error('diagnose') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <!-- Treatment Dropdown -->
                                <div>
                                    <label for="treatment" class="block text-sm font-medium">Treatment</label>
                                    <select id="treatment" wire:model="treatment" class="w-full p-2 border rounded-md text-black bg-white">
                                        <option value="" disabled>Select a treatment</option>
                                        @foreach($treatments as $treatment)
                                            <option  value="{{ $treatment->id }}">{{ $treatment->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('treatment') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="flex justify-end p-4 border-t">
                                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                                    {{ $patientId ? 'Update' : 'Save' }}
                                </button>
                            </div>
                        </form>
                    </div>

                </div>

            </div>
        </div>
    </div>


    <div class="mt-6 overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-300 rounded-md shadow-md">
            <thead class="bg-gray-200">
                <tr class="text-left text-sm font-medium text-gray-700">
                    <th class="py-3 px-4 border-b">Student Number</th>
                    <th class="py-3 px-4 border-b">Name</th>
                    <th class="py-3 px-4 border-b">Grade/Section</th>
                    <th class="py-3 px-4 border-b">Date</th>
                    <th class="py-3 px-4 border-b">Complain</th>
                    <th class="py-3 px-4 border-b">Time In</th>
                    <th class="py-3 px-4 border-b">Time Out</th>
                    <th class="py-3 px-4 border-b">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($patients as $patient)
                    <tr class="hover:bg-gray-50">
                        <td class="py-3 px-4 border-b">{{ $patient->student_number }}</td>
                        <td class="py-3 px-4 border-b">
                            {{ $patient->user ? $patient->user->name : 'N/A' }}  <!-- Ensure user is available -->
                        </td>
                        <td class="py-3 px-4 border-b">
                            {{ $patient->user ? $patient->user->grade_section : 'N/A' }}  <!-- Ensure grade_section is available -->
                        </td>
                        <td class="py-3 px-4 border-b">{{ \Carbon\Carbon::parse($patient->date)->format('M d, Y') }}</td>
                        <td class="py-3 px-4 border-b">{{ $patient->diagnose ?? 'No complain' }}</td>
                        <td class="py-3 px-4 border-b">
                            {{ $patient->time_in ? \Carbon\Carbon::createFromFormat('H:i:s', $patient->time_in)->setTimezone('Asia/Manila')->format('h:i A') : '-' }}
                        </td>
                        <td class="py-3 px-4 border-b">
                            {{ $patient->time_out ? \Carbon\Carbon::createFromFormat('H:i:s', $patient->time_out)->setTimezone('Asia/Manila')->format('h:i A') : 'Pending' }}
                        </td>

                        <td class="py-3 px-4 border-b space-x-2">
                            @if ($patient->time_out)
                                <span class="px-3 py-1 bg-gray-200 text-gray-600 rounded-md">Done</span>
                            @else
                                <button
                                    wire:click="timeout({{ $patient->id }})"
                                    class="px-3 py-1 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 transition">
                                    Time Out
                                </button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>


</div>
