<div class="bg-white shadow-lg rounded-lg p-6" data-aos="fade-left" data-aos-duration="2000">
    <h4 class="text-lg font-semibold">Barangay Officials</h4>
    <ul id="officials-list" class="mt-4 space-y-4">
        <!-- Officials will be rendered here -->
    </ul>
</div>

<script>
    // Fetch the data from the API endpoint
    fetch('/barangay/officials')
        .then(response => response.json())
        .then(data => {
            // Get the list container
            const officialsList = document.getElementById('officials-list');

            // Clear any existing data
            officialsList.innerHTML = '';

            // Loop through the data and render each official
            data.forEach(official => {
                const listItem = document.createElement('li');
                listItem.classList.add('flex', 'items-center', 'space-x-4');

                const img = document.createElement('img');
                img.src = official.profile_photo_path ? official.profile_photo_path :
                    'https://via.placeholder.com/40';
                img.alt = 'Official';
                img.classList.add('w-10', 'h-10', 'rounded-full');
                console.log(official.profile_photo_path);

                const infoDiv = document.createElement('div');

                const name = document.createElement('p');
                name.classList.add('text-sm', 'font-semibold');
                name.textContent = official.name;

                const role = document.createElement('p');
                role.classList.add('text-xs', 'text-gray-500');
                role.textContent = official.position;

                infoDiv.appendChild(name);
                infoDiv.appendChild(role);

                listItem.appendChild(img);
                listItem.appendChild(infoDiv);

                officialsList.appendChild(listItem);
            });
        })
        .catch(error => console.error('Error fetching barangay officials:', error));
</script>
