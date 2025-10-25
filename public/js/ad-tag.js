(function() {
    const scriptTag = document.currentScript;
    const params = new URLSearchParams(scriptTag.src.split('?')[1]);
    const zoneId = params.get('zone_id');
    const adContainer = document.getElementById(`ad-zone-${zoneId}`);

    if (adContainer) {
        // We'll need an API endpoint to serve the ad content.
        // For now, this is just a placeholder.
        const apiUrl = `/api/serve-ad?zone_id=${zoneId}`;

        fetch(apiUrl)
            .then(response => response.json())
            .then(data => {
                if (data.html) {
                    const iframe = document.createElement('iframe');
                    iframe.srcdoc = data.html;
                    iframe.width = data.width;
                    iframe.height = data.height;
                    iframe.style.border = 'none';
                    iframe.scrolling = 'no';
                    adContainer.appendChild(iframe);
                }
            })
            .catch(error => console.error('Error fetching ad:', error));
    }
})();
