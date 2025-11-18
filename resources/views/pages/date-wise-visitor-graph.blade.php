@vite(['resources/css/app.css'])
<div class="max-w-5xl mx-auto py-10 px-4">
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center space-x-3">
            <h1 class="text-2xl font-bold">
                Visitor Count (Date-wise)
            </h1>
            <a
                href="{{ route('schedule.index') }}"
                class="inline-flex items-center px-3 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-md text-sm font-medium"
            >Back</a>
        </div>

    </div>

    {{-- Filter form: Start / End date + Generate --}}
    <form method="GET" action="{{ route('visitors.daily') }}" class="mb-8">
        <div class="flex flex-col md:flex-row md:items-end md:space-x-4 space-y-4 md:space-y-0">
            <div class="flex-1">
                <label for="start_date" class="block text-sm font-medium mb-1">Start Date</label>
                <input
                    type="date"
                    id="start_date"
                    name="start_date"
                    value="{{ request('start_date', now()->toDateString()) }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white"
                    required
                />
            </div>

            <div class="flex-1">
                <label for="end_date" class="block text-sm font-medium mb-1">End Date</label>
                <input
                    type="date"
                    id="end_date"
                    name="end_date"
                    value="{{ request('end_date', now()->addDays(7)->toDateString()) }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white"
                    required
                />
            </div>

            <div>
                <button
                    type="submit"
                    class="inline-flex items-center px-5 py-2.5 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                    Generate
                </button>
            </div>
        </div>
    </form>

    {{-- Chart container in the middle, standard height/width --}}
    <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-4">
        <div class="mx-auto" style="max-width: 900px;">
            {{-- Standard chart size: width responsive, height fixed --}}
            <div class="relative">
                <div id="visitorChart" style="width: 100%; height: 400px;"></div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    // Example data from backend (adjust keys to match what your controller passes)
    const chartLabels = @json($dates ?? []);
    const chartData = @json($number_of_visitors ?? []);

    var options = {
        chart: {
            type: 'line'
        },
        series: [{
            name: 'Number of Visitors',
            data: chartData
        }],
        xaxis: {
            categories: chartLabels
        }
    }

    var chart = new ApexCharts(document.querySelector("#visitorChart"), options);

    chart.render();
</script>
