<div>
    <!-- Add Medicine Button -->
    <div x-data="{ showModal: @entangle('editModal') }" class="mb-6">
        <button class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700" @click="showModal = true">
            Add Medicine
        </button>

        <!-- Modal -->
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
                    <h2 class="text-lg font-semibold">{{ $medicineId ? 'Edit Medicine' : 'Add Medicine' }}</h2>
                    <button
                        class="text-gray-600 hover:text-gray-900"
                        @click="showModal = false">
                        &times;
                    </button>
                </div>

                <form wire:submit.prevent="save">
                    <div class="p-4 space-y-4">
                        <div>
                            <label for="medicineName" class="block text-sm font-medium">Medicine Name</label>
                            <input type="text" id="medicineName" wire:model="medicineName" class="w-full p-2 border rounded-md" />
                            @error('medicineName') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium">Description</label>
                            <textarea id="description" wire:model="description" class="w-full p-2 border rounded-md"></textarea>
                            @error('description') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>


                    <div>
                        <label for="quantity" class="block text-sm font-medium">Quantity</label>
                        <input type="number" id="quantity" wire:model="quantity" class="w-full p-2 border rounded-md" />
                        @error('quantity') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    </div>


                    <div class="flex justify-end p-4 border-t">
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                            {{ $medicineId ? 'Update' : 'Save' }}
                        </button>
                        <button
                            type="button"
                            class="ml-2 px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700"
                            @click="showModal = false; @this.resetForm()">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Medicines Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-300 rounded-md shadow-md">
            <thead class="bg-gray-200">
                <tr class="text-left text-sm font-medium text-gray-700">
                    <th class="py-3 px-4 border-b">Name</th>
                    <th class="py-3 px-4 border-b">Description</th>
                    <th class="py-3 px-4 border-b">Quantity</th> <!-- Add Quantity Column -->
                    <th class="py-3 px-4 border-b">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($medicines as $medicine)
                    <tr class="hover:bg-gray-50">
                        <td class="py-3 px-4 border-b">{{ $medicine->name }}</td>
                        <td class="py-3 px-4 border-b">{{ $medicine->description }}</td>
                        <td class="py-3 px-4 border-b">{{ $medicine->quantity }}</td> <!-- Display Quantity -->
                        <td class="py-3 px-4 border-b space-x-2">
                            <button wire:click="edit({{ $medicine->id }})" class="px-3 py-1 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 transition">
                                Edit
                            </button>
                            <button wire:click="delete({{ $medicine->id }})" class="px-3 py-1 bg-red-500 text-white rounded-md hover:bg-red-600 transition">
                                Delete
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>

        </table>
    </div>
</div>
