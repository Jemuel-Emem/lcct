<div>
    <h2 class="text-2xl font-semibold text-gray-700 mb-4">Dashboard</h2>
    <div class="min-h-screen flex flex-col items-center py-10">

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 w-full max-w-6xl">

            <div class="bg-white shadow-lg rounded-lg p-6 flex flex-col items-center">
                <h2 class="text-xl font-semibold text-gray-700">Today's Patients</h2>
                <p class="text-3xl font-bold text-cyan-500 mt-4">{{ $todayPatients }}</p>

            </div>


            <div class="bg-white shadow-lg rounded-lg p-6 flex flex-col items-center">
                <h2 class="text-xl font-semibold text-gray-700">This Week</h2>
                <p class="text-3xl font-bold text-cyan-500 mt-4">{{ $weekPatients }}</p>

            </div>


            <div class="bg-white shadow-lg rounded-lg p-6 flex flex-col items-center">
                <h2 class="text-xl font-semibold text-gray-700">This Month</h2>
                <p class="text-3xl font-bold text-cyan-500 mt-4">{{ $monthPatients }}</p>

            </div>


            <div class="bg-white shadow-lg rounded-lg p-6 flex flex-col items-center">
                <h2 class="text-xl font-semibold text-gray-700">This Year</h2>
                <p class="text-3xl font-bold text-cyan-500 mt-4">{{ $yearPatients }}</p>

            </div>
        </div>

        <div class="w-full mt-8">

                <h2 class="text-2xl font-semibold text-gray-700 mb-4">Daily Patient Statistics</h2>
                <canvas id="dailyPatientsChart" height="100"></canvas>

        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const dailyPatients = @json($dailyPatients);
            const labels = dailyPatients.map(data => data.date);
            const counts = dailyPatients.map(data => data.count);

            const ctx = document.getElementById('dailyPatientsChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Number of Patients',
                        data: counts,
                        backgroundColor: 'rgba(56, 178, 172, 0.5)',
                        borderColor: 'rgba(56, 178, 172, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
    </div>

</div>
