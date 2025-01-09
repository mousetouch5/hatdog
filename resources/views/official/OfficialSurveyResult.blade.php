<x-app-layout>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>

    <div class="flex h-full min-h-screen">
        <!-- Sidebar -->
        <x-sidebar class="custom-sidebar-class" />
        <!-- End Sidebar -->

        <!-- Main content section -->
        <div class="flex flex-col w-full">
            <!-- Content Section -->
            <main class="flex-1 px-8 py-6 space-y-6 bg-gray-50">
                <!-- Survey Responses Section -->
                <section>
                    <div class="p-4">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-2xl font-semibold">Survey Responses</h2>
                        </div>

                        <div class="stats shadow mb-4">
                            <div class="stat">
                                <div class="stat-title">Total Responses</div>
                                <div class="stat-value">{{ $totalResponses }}</div>
                            </div>
                        </div>

                        <!-- Grid of Cards -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <!-- Participation Levels Card -->
                            <div class="card bg-base-100 shadow-xl">
                                <div class="card-body">
                                    <h2 class="card-title">Participation Levels</h2>
                                    @if ($participationCounts->isEmpty())
                                        <p>No participation data available.</p>
                                    @else
                                        <ul class="space-y-2">
                                            @foreach ($participationCounts as $participation)
                                                <li class="flex justify-between">
                                                    <span>{{ $participation->participation }}</span>
                                                    <span class="badge badge-primary">{{ $participation->count }}
                                                        responses</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            </div>

                            <!-- Event Types Card -->
                            <div class="card bg-base-100 shadow-xl">
                                <div class="card-body">
                                    <h2 class="card-title">Event Types</h2>
                                    @if ($eventTypeCounts->isEmpty())
                                        <p>No event type data available.</p>
                                    @else
                                        <ul class="space-y-2">
                                            @foreach ($eventTypeCounts as $eventType)
                                                <li class="flex justify-between">
                                                    <span>{{ $eventType->event_type }}</span>
                                                    <span class="badge badge-secondary">{{ $eventType->count }}
                                                        responses</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            </div>
                        </div>




                        <!-- Survey Data Overview Card -->
                        <div class="card bg-base-100 shadow-xl mb-6">
                            <div class="card-body">
                                <h2 class="card-title">Survey Data Overview</h2>
                                <p>A visual representation of survey participation levels and event types.</p>
                                <div id="chart-container">
                                    <canvas id="surveyChart"></canvas>
                                </div>
                            </div>
                        </div>

                        <!-- Conclusions Card -->
                        <div class="card bg-base-100 shadow-xl mb-6">
                            <div class="card-body">
                                <h2 class="card-title">Conclusions</h2>
                                <p>
                                    Based on the survey data, the most popular participation level is
                                    {{ $mostLikedEvent->like_count }} likes,
                                    while event or project "{{ $mostLikedEventName }}" was the most liked activity type.
                                </p>
                            </div>
                        </div>

                        <!-- All Responses Card -->
                        <div class="card bg-base-100 shadow-xl">
                            <div class="card-body">
                                <h2 class="card-title">All Responses</h2>
                                @if ($surveyResponses->isEmpty())
                                    <p>No survey responses available.</p>
                                @else
                                    <div class="overflow-x-auto">
                                        <table class="table table-zebra">
                                            <thead>
                                                <tr>
                                                    <th>User</th>
                                                    <th>Participation</th>
                                                    <th>Event Types</th>
                                                    <th>Response</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($surveyResponses as $response)
                                                    <tr>
                                                        <td>{{ $response->user->name }}</td>
                                                        <td>{{ $response->participation }}</td>
                                                        <td>
                                                            @if (is_array($response->event_types))
                                                                @foreach ($response->event_types as $event)
                                                                    <span
                                                                        class="badge badge-outline mr-1">{{ $event }}</span>
                                                                @endforeach
                                                            @else
                                                                @foreach (json_decode($response->event_types) as $event)
                                                                    <span
                                                                        class="badge badge-outline mr-1">{{ $event }}</span>
                                                                @endforeach
                                                            @endif
                                                        </td>
                                                        <td>{{ $response->response }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </section>
            </main>
        </div>

    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var ctx = document.getElementById('surveyChart').getContext('2d');
        var surveyChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($eventNames->values()),
                datasets: [{
                    label: 'Number of Responses',
                    data: @json($eventCounts->pluck('total_responses')),
                    backgroundColor: ['#4CAF50', '#FF9800', '#2196F3'],
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

</x-app-layout>
