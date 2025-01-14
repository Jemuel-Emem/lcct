<div>
    <div class="mb-2">
        <input
            type="text"
            wire:model.debounce.300ms="search"
            placeholder="Search by Student Number or Name"
            class="border rounded-md p-2"
        />
        <button wire:click="ser" class="bg-green-500 hover:bg-green-600 p-1 w-32 text-white rounded h-10">
            Search
        </button>
    </div >
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-300 rounded-lg">
            <thead>
                <tr class="bg-gray-200 text-gray-600 text-sm leading-normal">
                    <th class="py-3 px-6 text-left">Patient Name</th>
                    <th class="py-3 px-6 text-left">Student Number</th>
                    <th class="py-3 px-6 text-left">Prescription</th>
                    <th class="py-3 px-6 text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($patientsWithPrescriptions as $record)
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6">{{ $record->patient->name }}</td>
                        <td class="py-3 px-6">{{ $record->patient->student_number }}</td>
                        <td class="py-3 px-6">{{ $record->treatment->name }}</td>
                        <td class="py-3 px-6 text-center">
                            <button
                                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition"
                                wire:click="printCertificate({{ $record->id }})">
                                Print Certificate
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
