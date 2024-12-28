<div>
    <div class="overflow-x-auto">

        <div class="mb-4 flex items-center">
            <input
                type="text"
                wire:model.debounce.300ms="search"
                placeholder="Search by student number or name"
                class="border border-gray-300 rounded-lg px-4 py-2 w-1/3 focus:outline-none focus:ring focus:ring-blue-300"
            >
            <button
                class="ml-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700"
                wire:click="searchh">
                Search
            </button>
        </div>

        <!-- Attendance Table -->
        <table class="min-w-full bg-white border border-gray-300 rounded-lg">
            <thead>
                <tr class="bg-gray-200 text-gray-600 text-sm leading-normal">
                    <th class="py-3 px-6 text-left">Student Number</th>
                    <th class="py-3 px-6 text-left">Name</th>
                    <th class="py-3 px-6 text-left">Time In</th>
                    <th class="py-3 px-6 text-left">Time Out</th>
                    <th class="py-3 px-6 text-left">Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($patients as $patient)
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6">{{ $patient->student_number }}</td>
                        <td class="py-3 px-6">{{ $patient->user->name }}</td>
                        <td class="py-3 px-4 border-b">
                            {{ $patient->time_in ? \Carbon\Carbon::createFromFormat('H:i:s', $patient->time_in)->setTimezone('Asia/Manila')->format('h:i A') : '-' }}
                        </td>
                        <td class="py-3 px-4 border-b">
                            {{ $patient->time_out ? \Carbon\Carbon::createFromFormat('H:i:s', $patient->time_out)->setTimezone('Asia/Manila')->format('h:i A') : 'Pending' }}
                        </td>
                        <td class="py-3 px-6">{{ $patient->created_at->format('F d, Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-3 px-6 text-center">No patients found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination Links -->
        <div class="mt-4">
            {{ $patients->links() }}
        </div>
    </div>
</div>
