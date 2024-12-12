<div class="bg-white shadow-lg rounded-lg p-6 relative">
    <!-- added 'relative' to allow absolute positioning of the emoji -->
    <h4 class="text-lg font-semibold">Community Outreach</h4>
    <canvas id="pieChart" class="mt-4 h-32"></canvas> <!-- Pie chart -->



<!-- Like and Unlike Section -->
<div class="mt-4 space-y-6 mb-7">
    <!-- Like Section -->
    <div class="flex items-center justify-center space-x-6">
        <div class="flex items-center justify-center w-10 h-10 rounded-full bg-[#4CD7F6]">
            <svg class="w-5 h-5 text-white" version="1.1" id="Icons" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
                <style type="text/css">
                    .st0{fill:none;stroke:#000000;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;}
                </style>
                <path class="st0" d="M11,24V14H5v12h6v-2.4l0,0c1.5,1.6,4.1,2.4,6.2,2.4h6.5c1.1,0,2.1-0.8,2.3-2l1.5-8.6c0.3-1.5-0.9-2.4-2.3-2.4
                    H20V6.4C20,5.1,18.7,4,17.4,4h0C16.1,4,15,5.1,15,6.4v0c0,1.6-0.5,3.1-1.4,4.4L11,13.8"></path>
            </svg>
        </div>
        <span id="likePercentage" class="text-sm font-semibold text-gray-700">0%</span>
    </div>
    <!-- Unlike Section -->
    <div class="flex items-center justify-center space-x-6">
        <div class="flex items-center justify-center w-10 h-10 rounded-full bg-[#CDF3FF]">
            <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64">
                <g id="Layer_77" data-name="Layer 77">
                    <path d="M61.7,31.82l-6-17.75A9.73,9.73,0,0,0,46.37,7.2H25.23A2,2,0,0,0,24,7.65l-2.47,2A4.8,4.8,0,0,0,17.22,7H6.81A4.81,4.81,0,0,0,2,11.81v27a4.81,4.81,0,0,0,4.81,4.81H17.22A4.8,4.8,0,0,0,22,39.19h2.11l7.34,15A4.43,4.43,0,0,0,35.57,57h4.05A4.41,4.41,0,0,0,44,52.75a2,2,0,0,0,0-.35L42.32,40H55.72a6.28,6.28,0,0,0,6-8.2ZM18,38.84a.81.81,0,0,1-.81.81H6.81A.81.81,0,0,1,6,38.84v-27A.81.81,0,0,1,6.81,11H17.22a.81.81,0,0,1,.81.81v27Zm39.52-3.75a2.26,2.26,0,0,1-1.84.93H40a2,2,0,0,0-2,2.27L40,52.7a.42.42,0,0,1-.4.3H35.57a.42.42,0,0,1-.4-.28,1.94,1.94,0,0,0-.08-.2L27.15,36.3a2,2,0,0,0-1.8-1.12H22V14.4l3.92-3.2H46.37a5.76,5.76,0,0,1,5.52,4.1l6,17.75A2.26,2.26,0,0,1,57.55,35.08Z"/>
                    <circle cx="11.57" cy="17.02" r="3.55"/>
                </g>
            </svg>
        </div>
        <span id="unlikePercentage" class="text-sm font-semibold text-gray-700">0%</span>
    </div>
</div>























        <!-- Like and Unlike Section 
<div class="mt-4 space-y-6 mb-7">

    <div class="flex items-center justify-center space-x-6">
        <svg class="w-6 h-6 text-blue-600 hover:text-blue-400" version="1.1" id="Icons" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
            <style type="text/css">
                .st0{fill:none;stroke:#000000;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;}
            </style>
            <path class="st0" d="M11,24V14H5v12h6v-2.4l0,0c1.5,1.6,4.1,2.4,6.2,2.4h6.5c1.1,0,2.1-0.8,2.3-2l1.5-8.6c0.3-1.5-0.9-2.4-2.3-2.4
                H20V6.4C20,5.1,18.7,4,17.4,4h0C16.1,4,15,5.1,15,6.4v0c0,1.6-0.5,3.1-1.4,4.4L11,13.8"></path>
        </svg>
        <span id="likePercentage" class="text-sm font-semibold text-gray-700">0%</span>
    </div>

    <div class="flex items-center justify-center space-x-6">
        <svg class="w-6 h-6 text-blue-600 hover:text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64">
            <g id="Layer_77" data-name="Layer 77">
                <path d="M61.7,31.82l-6-17.75A9.73,9.73,0,0,0,46.37,7.2H25.23A2,2,0,0,0,24,7.65l-2.47,2A4.8,4.8,0,0,0,17.22,7H6.81A4.81,4.81,0,0,0,2,11.81v27a4.81,4.81,0,0,0,4.81,4.81H17.22A4.8,4.8,0,0,0,22,39.19h2.11l7.34,15A4.43,4.43,0,0,0,35.57,57h4.05A4.41,4.41,0,0,0,44,52.75a2,2,0,0,0,0-.35L42.32,40H55.72a6.28,6.28,0,0,0,6-8.2ZM18,38.84a.81.81,0,0,1-.81.81H6.81A.81.81,0,0,1,6,38.84v-27A.81.81,0,0,1,6.81,11H17.22a.81.81,0,0,1,.81.81v27Zm39.52-3.75a2.26,2.26,0,0,1-1.84.93H40a2,2,0,0,0-2,2.27L40,52.7a.42.42,0,0,1-.4.3H35.57a.42.42,0,0,1-.4-.28,1.94,1.94,0,0,0-.08-.2L27.15,36.3a2,2,0,0,0-1.8-1.12H22V14.4l3.92-3.2H46.37a5.76,5.76,0,0,1,5.52,4.1l6,17.75A2.26,2.26,0,0,1,57.55,35.08Z"/>
                <circle cx="11.57" cy="17.02" r="3.55"/>
            </g>
        </svg>
        <span id="unlikePercentage" class="text-sm font-semibold text-gray-700">0%</span>
    </div>
</div>-->



<script>
    // Fetch survey data from the server
    fetch('/survey-data') // Replace '/survey-data' with your actual API endpoint
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to fetch survey data');
            }
            return response.json(); // Parse JSON response
        })
        .then(data => {
            // Calculate total likes and unlikes
            let totalLikes = 0;
            let totalUnlikes = 0;

            data.forEach(item => {
                const totalResponses = item.likes_percentage + item.unlikes_percentage;
                totalLikes += (item.likes_percentage / 100) * totalResponses;
                totalUnlikes += (item.unlikes_percentage / 100) * totalResponses;
            });

            const grandTotal = totalLikes + totalUnlikes;

            // Calculate percentages
            const likesPercentage = grandTotal > 0 ? ((totalLikes / grandTotal) * 100).toFixed(2) : 0;
            const unlikesPercentage = grandTotal > 0 ? ((totalUnlikes / grandTotal) * 100).toFixed(2) : 0;

            // Update the DOM with calculated percentages
            document.querySelector('#likePercentage').textContent = `${likesPercentage}%`;
            document.querySelector('#unlikePercentage').textContent = `${unlikesPercentage}%`;
        })
        .catch(error => {
            console.error('Error:', error.message);
            alert('Failed to load survey data. Please try again later.');
        });
</script>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Fetch survey data from the server
    fetch('/survey-data') // Replace '/survey-data' with the actual API endpoint
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to fetch survey data');
            }
            return response.json(); // Parse JSON response
        })
        .then(data => {
            // Extract labels (event names) and data (like percentages)
            const labels = data.map(item => item.event_name);
            const likesData = data.map(item => item.likes_percentage);

            // Create the chart
            var ctx = document.getElementById('pieChart').getContext('2d');
            var pieChart = new Chart(ctx, {
                type: 'pie', // Pie chart type
                data: {
                    labels: labels, // Event names as labels
                    datasets: [{
                        label: 'Likes Percentage',
                        data: likesData, // Like percentages as data points
                        backgroundColor: ['#4CD7F6', '#CDF3FF',
                            '#5B93FF'
                        ], // Colors for each segment
                        borderColor: '#ffffff',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top' // Position of the legend
                        },
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    var label = tooltipItem.label || '';
                                    var value = tooltipItem.raw || 0;
                                    return label + ': ' + value + '%'; // Tooltip with label and value
                                }
                            }
                        }
                    }
                }
            });
        })
        .catch(error => {
            console.log('Error:', error.message); // Log any errors to the console
            console.log('Failed to load survey data. Please try again later.');
        });
</script>
