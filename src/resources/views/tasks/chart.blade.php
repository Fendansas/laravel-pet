<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            📊 Аналитика задач
        </h2>
    </x-slot>

    <div class="py-6 max-w-6xl mx-auto px-4">
        <div class="bg-white p-6 rounded-xl shadow space-y-6">

            <div class="flex justify-between items-center">
                <h3 class="text-lg font-semibold">
                    Задачи по статусам
                </h3>
            </div>

            <div class="relative">
                <canvas id="tasksChart" height="120"></canvas>
            </div>

        </div>
    </div>

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ctx = document.getElementById('tasksChart');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($labels),
                datasets: [{
                    label: 'Количество задач',
                    data: @json($data),
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
    </script>
</x-app-layout>
