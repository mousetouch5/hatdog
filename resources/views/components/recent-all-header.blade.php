                    <div class="flex justify-between items-center" data-aos="fade-down" data-aos-duration="2000">
                        <h2 class="text-lg font-semibold">Recent Activity</h2>
                        <div class="flex space-x-4">
                            <!-- Buttons for Filtering -->
                            <button onclick="showEvents('recent')" class="px-4 py-2 text-black rounded-lg filter-btn"
                                style="background: rgba(205, 243, 255, 1);" id="recent-btn">Recent Activity</button>
                            <button onclick="showEvents('ongoing')" class="px-4 py-2 bg-gray-200 rounded-lg filter-btn"
                                id="ongoing-btn">Ongoing Activity</button>

                        </div>
                    </div>

                    <script>
                        function showEvents(category) {
                            // Hide all event cards
                            document.querySelectorAll('.event-card').forEach(card => {
                                card.style.display = 'none';
                            });

                            // Show cards matching the selected category
                            document.querySelectorAll(`.event-card[data-category="${category}"]`).forEach(card => {
                                card.style.display = 'block';
                            });

                            // Update button styles
                            document.querySelectorAll('.filter-btn').forEach(btn => {
                                btn.style.background = 'rgba(229, 231, 235, 1)'; // gray background
                                btn.style.color = 'black';
                            });

                            document.getElementById(`${category}-btn`).style.background = 'rgba(205, 243, 255, 1)'; // blue background
                            document.getElementById(`${category}-btn`).style.color = 'black';
                        }

                        // Initialize: Show recent events by default
                        document.addEventListener('DOMContentLoaded', () => {
                            showEvents('recent');
                        });
                    </script>
