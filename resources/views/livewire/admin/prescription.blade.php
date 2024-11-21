<div>
    <button wire:click="openAddModal" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
        Add Prescription
    </button>

    <!-- Add Prescription Modal -->
    @if($addModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">


        <div class="bg-white p-4 w-1/2 rounded-lg">
            <h2 class="text-lg font-semibold">Add Prescription</h2>
            <form wire:submit.prevent="save">
                @if (session()->has('error'))
                <div class="bg-red-500 text-white p-4 rounded-md">
                    {{ session('error') }}
                </div>
            @endif
                <div class="mt-4">
                    <label for="studentId" class="block">Student ID</label>
                    <input type="text" id="studentId" wire:model="studentId" class="w-full p-2 border rounded-md" placeholder="Enter Student ID">
                    @error('studentId') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mt-4">
                    <label for="treatmentId" class="block">Treatment</label>
                    <select id="treatmentId" wire:model="treatmentId" class="w-full p-2 border rounded-md">
                        <option value="">Select Treatment</option>
                        @foreach($treatments as $treatment)
                            <option value="{{ $treatment->id }}">{{ $treatment->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mt-4">
                    <label for="medicineId" class="block">Medicine</label>
                    <select id="medicineId" wire:model="medicineId" class="w-full p-2 border rounded-md">
                        <option value="">Select Medicine</option>
                        @foreach($medicines as $medicine)
                            <option value="{{ $medicine->id }}">{{ $medicine->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mt-4">
                    <label for="medicineQuantity" class="block">Medicine Quantity</label>
                    <input type="number" id="medicineQuantity" wire:model="medicineQuantity" class="w-full p-2 border rounded-md" placeholder="Enter Quantity">
                    @error('medicineQuantity') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>


                <div class="mt-6 flex justify-end">
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md">
                        Save
                    </button>
                    <button type="button" class="ml-2 px-4 py-2 bg-gray-600 text-white rounded-md" wire:click="resetForm">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif


    @if($editModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white p-4 w-1/2 rounded-lg">
            <h2 class="text-lg font-semibold">Edit Prescription</h2>
            <form wire:submit.prevent="save">
                <div class="mt-4">
                    <label for="studentId" class="block">Student ID</label>
                    <input type="text" id="studentId" wire:model="studentId" class="w-full p-2 border rounded-md" placeholder="Enter Student ID">
                    @error('studentId') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mt-4">
                    <label for="treatmentId" class="block">Treatment</label>
                    <select id="treatmentId" wire:model="treatmentId" class="w-full p-2 border rounded-md">
                        <option value="">Select Treatment</option>
                        @forelse($treatments as $treatment)
                            <option value="{{ $treatment->id }}">{{ $treatment->name }}</option>
                        @empty
                            <option>No treatments available</option>
                        @endforelse
                    </select>
                </div>


                <div class="mt-4">
                    <label for="medicineId" class="block">Medicine</label>
                    <select id="medicineId" wire:model="medicineId" class="w-full p-2 border rounded-md">
                        <option value="">Select Medicine</option>
                        @foreach($medicines as $medicine)
                            <option value="{{ $medicine->id }}">{{ $medicine->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mt-6 flex justify-end">
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md">
                        Update
                    </button>
                    <button type="button" class="ml-2 px-4 py-2 bg-gray-600 text-white rounded-md" wire:click="resetForm">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

    <div class="mt-6 overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-300 rounded-md shadow-md">
            <thead class="bg-gray-200">
                <tr class="text-left text-sm font-medium text-gray-700">
                    <th class="py-3 px-4 border-b">Patient Name</th>
                    <th class="py-3 px-4 border-b">Treatment</th>
                    <th class="py-3 px-4 border-b">Medicine</th>
                    <th class="py-3 px-4 border-b">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($prescriptions as $prescription)
                    <tr class="hover:bg-gray-50">
                        <td class="py-3 px-4 border-b">{{ $prescription->patient->name }}</td>
                        <td class="py-3 px-4 border-b">{{ $prescription->treatment->name }}</td>
                        <td class="py-3 px-4 border-b">{{ $prescription->medicine->name }}</td>
                        <td class="py-3 px-4 border-b space-x-2">
                            <button wire:click="edit({{ $prescription->id }})" class="px-3 py-1 bg-yellow-500 text-white rounded-md hover:bg-yellow-600">
                                Edit
                            </button>
                            <button wire:click="delete({{ $prescription->id }})" class="px-3 py-1 bg-red-500 text-white rounded-md hover:bg-red-600">
                                Delete
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="py-3 px-4 border-b text-center">No prescriptions found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
