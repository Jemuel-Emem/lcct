<div>
    <div x-data="{ showModal: @entangle('editModal') }" class="flex items-start justify-end">

        {{-- <button
            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 w-64"
            @click="showModal = true; @this.resetForm()">
            Add New Prescription
        </button> --}}
        <div class="flex gap-4 items-center">
            <div>
                <input
                    type="text"
                    wire:model.debounce.300ms="search"
                    placeholder="Search by Student Number "
                    class="border rounded-md p-2"
                />
                <button wire:click="ser" class="bg-green-500 hover:bg-green-600 p-1 w-32 text-white rounded h-10">
                    Search
                </button>
            </div>
            <button
            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 w-64"
            @click="showModal = true; @this.resetForm()">
            Add New Prescription
        </button>
        </div>


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
                    <h2 class="text-lg font-semibold">
                        {{ $prescriptionId ? 'Edit Prescription' : 'Add New Prescription' }}
                    </h2>
                    <button
                        class="text-gray-600 hover:text-gray-900"
                        @click="showModal = false; @this.resetForm()">
                        &times;
                    </button>
                </div>


                <form wire:submit.prevent="save">
                    <div class="p-4 space-y-4">
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
                            <label for="treatment" class="block text-sm font-medium">Treatment</label>
                            <select id="treatment" wire:model="treatment" class="w-full p-2 border rounded-md">
                                <option value="" disabled>Select a treatment</option>
                                @foreach($treatments as $treatment)
                                    <option value="{{ $treatment->id }}">{{ $treatment->name }}</option>
                                @endforeach
                            </select>
                            @error('treatment') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="diagnose" class="block text-sm font-medium">Diagnose</label>
                            <textarea
                                id="diagnose"
                                wire:model="diagnose"
                                class="w-full p-2 border rounded-md"
                            ></textarea>
                            @error('diagnose') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="flex justify-end p-4 border-t">
                        <button
                            type="submit"
                            class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                            {{ $prescriptionId ? 'Update' : 'Save' }}
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


    <div class="overflow-x-auto mt-4">
        <table id="printPage" class="min-w-full bg-white border border-gray-300 rounded-lg">
            <thead>
                <tr class="bg-gray-200 text-gray-600 text-sm leading-normal">
                    <th class="py-3 px-6 text-left">Student Number</th>
                    <th class="py-3 px-6 text-left">Grade/Section</th>
                    <th class="py-3 px-6 text-left">Treatment</th>
                    <th class="py-3 px-6 text-left">Diagnose</th>
                    <th class="py-3 px-6 text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($prescriptions as $prescription)
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6">{{ $prescription->student_number }}</td>
                        <td class="py-3 px-6">{{ $prescription->grade_section }}</td>
                        <td class="py-3 px-6">{{ $prescription->treatment->name }}</td>
                        <td class="py-3 px-6">{{ $prescription->diagnose }}</td>
                        <td class="py-3 px-6 text-center space-x-2">
                            <button
                                class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 transition"
                                wire:click="edit({{ $prescription->id }})"
                               >
                                Edit
                            </button>
                            <button
                                class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition"
                                wire:click="delete({{ $prescription->id }})">
                                Delete
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="flex justify-end mt-4">
            <button  onclick="printOnlyTable()" class="bg-gray-500 w-64 text-white px-4 py-2 rounded-lg">Print</button>
        </div>
    </div>

    <style>
        @media print {

            body * {
                visibility: hidden;
            }


            #printPage, #printPage * {
                visibility: visible;
            }


            #printPage {
                width: 100%;
                margin: 0 auto;
                border-collapse: collapse;
            }


            h2 {
                text-align: center;
                font-size: 20px;
                font-weight: bold;
                margin-bottom: 20px;
                visibility: visible;
            }

            @page {
                margin: 1cm;
            }


            body {
                margin: 0;
                padding: 0;
            }
        }
    </style>
    <script>
        function printOnlyTable() {

            const originalContent = document.body.innerHTML;


            const printContent = document.getElementById('printPage').outerHTML;


            const header = "<h2>Prescriptions</h2>";


            document.body.innerHTML = header + printContent;


            window.print();


            window.onafterprint = () => {
                document.body.innerHTML = originalContent;
            };
        }
    </script>
</div>
