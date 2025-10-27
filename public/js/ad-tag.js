(function() {
    document.addEventListener('DOMContentLoaded', function() {
        const adZones = document.querySelectorAll('.ad-zone');
        adZones.forEach(adZone => {
            const adZoneId = adZone.id.split('-')[2];
            const width = adZone.dataset.width;
            const height = adZone.dataset.height;

            fetch(`/api/ad-request/${adZoneId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.html_content) {
                        const iframe = document.createElement('iframe');
                        iframe.width = width;
                        iframe.height = height;
                        iframe.style.border = 'none';
                        iframe.srcdoc = data.html_content;
                        adZone.appendChild(iframe);

                        // Record an impression
                        fetch(`/api/impression/${data.placement_id}`, { method: 'POST' });
                    }
                })
                .catch(error => console.error('Error fetching ad:', error));
        });
    });
})();
