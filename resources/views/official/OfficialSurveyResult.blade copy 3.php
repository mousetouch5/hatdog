<div class="container mx-auto p-6">
    <h1 class="text-2xl font-semibold mb-6">Survey Results</h1>

    <!-- Total Survey Responses -->
    <div class="mb-4 p-4 border rounded-lg shadow-sm bg-white">
        <h2 class="text-xl font-semibold">Total Responses</h2>
        <p class="text-lg">{{ $totalResponses }} responses received</p>
    </div>

    <!-- Participation Counts -->
    <div class="mb-6 p-4 border rounded-lg shadow-sm bg-white">
        <h2 class="text-xl font-semibold mb-2">Participation Levels</h2>
        @if ($participationCounts->isEmpty())
            <p>No participation data available.</p>
        @else
            <ul class="space-y-2">
                @foreach ($participationCounts as $participation)
                    <li class="flex justify-between">
                        <span class="text-lg">{{ $participation->participation }}</span>
                        <span class="text-lg text-blue-600">{{ $participation->count }} responses</span>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    <!-- Event Type Counts -->
    <div class="mb-6 p-4 border rounded-lg shadow-sm bg-white">
        <h2 class="text-xl font-semibold mb-2">Event Types</h2>
        @if ($eventTypeCounts->isEmpty())
            <p>No event type data available.</p>
        @else
            <ul class="space-y-2">
                @foreach ($eventTypeCounts as $eventType)
                    <li class="flex justify-between">
                        <span class="text-lg">{{ $eventType->event_type }}</span>
                        <span class="text-lg text-blue-600">{{ $eventType->count }} responses</span>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    <!-- Chart Section -->
    <div class="mb-6 p-4 border rounded-lg shadow-sm bg-white">
        <h2 class="text-xl font-semibold mb-2">Survey Data Overview</h2>
        <p class="text-lg mb-4">A visual representation of survey participation levels and event types.</p>
        <div id="chart-container">
            <!-- Chart.js -->
            <canvas id="surveyChart"></canvas>
        </div>
    </div>

    <!-- Survey Responses -->
    <div class="p-4 border rounded-lg shadow-sm bg-white">
        <h2 class="text-xl font-semibold mb-2">All Responses</h2>
        @if ($surveyResponses->isEmpty())
            <p>No survey responses available.</p>
        @else
            <table class="min-w-full table-auto border-collapse">
                <thead>
                    <tr>
                        <th class="px-4 py-2 border text-left">User</th>
                        <th class="px-4 py-2 border text-left">Participation</th>
                        <th class="px-4 py-2 border text-left">Event Types</th>
                        <th class="px-4 py-2 border text-left">Response</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($surveyResponses as $response)
                        <tr>
                            <td class="px-4 py-2 border">{{ $response->user->name }}</td>
                            <td class="px-4 py-2 border">{{ $response->participation }}</td>
                            <td class="px-4 py-2 border">
                                @if (is_array($response->event_types))
                                    @foreach ($response->event_types as $event)
                                        <span class="block">{{ $event }}</span>
                                    @endforeach
                                @else
                                    @foreach (json_decode($response->event_types) as $event)
                                        <span class="block">{{ $event }}</span>
                                    @endforeach
                                @endif
                            </td>
                            <td class="px-4 py-2 border">{{ $response->response }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <!-- Conclusion Section -->
    <div class="mt-6 p-4 border rounded-lg shadow-sm bg-white">
        <h2 class="text-xl font-semibold mb-2">Conclusions</h2>
        <p class="text-lg">
            Based on the survey data, the most popular participation level is {{ $mostLikedEvent->like_count }} likes,
            while event or project "{{ $mostLikedEventName }}" was the most liked activity type.
        </p>
    </div>

        <div class="mt-6 p-4 border rounded-lg shadow-sm bg-white">
        <h2 class="text-xl font-semibold mb-2">Conclusions</h2>
        <p class="text-lg">
            Based on the survey data, the most popular participation level is {{ $mostLikedEvent->like_count }} likes,
            while event or project "{{ $mostLikedEventName }}" was the most liked activity type.
        </p>
    </div>



</div>

<!-- Chart Section -->
<canvas id="surveyChart" width="400" height="200"></canvas>

<!-- Script to initialize chart (using Chart.js for example) -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById('surveyChart').getContext('2d');
    var surveyChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($eventNames->values()), // Event names (not event IDs)
            datasets: [{
                label: 'Number of Responses',
                data: @json($eventCounts->pluck('total_responses')), // Total responses for each event
                backgroundColor: ['#4CAF50', '#FF9800',
                    '#2196F3'
                ], // Use dynamic colors or change as needed
                borderColor: ['#388E3C', '#F57C00', '#1976D2'],
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
</script>
