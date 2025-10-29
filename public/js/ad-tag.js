/**
 * Ad Server Tag
 *
 * This script scans the host page for ad placeholders and injects ad content
 * served from our ad server. It also tracks ad visibility (viewability).
 */
(function() {
    // Configuration
    const API_BASE_URL = 'http://127.0.0.1:8000/api'; // In production, this should be dynamic
    const PLACEHOLDER_CLASS = 'ad-server-placeholder';
    const VIEWABILITY_THRESHOLD = 0.5; // 50% of the ad must be visible
    const VIEWABILITY_TIME = 1000; // for at least 1 second

    /**
     * Finds all ad placeholders on the page and loads an ad for each.
     */
    function init() {
        const placeholders = document.querySelectorAll(`.${PLACEHOLDER_CLASS}`);
        if (placeholders.length === 0) {
            console.log('Ad Server: No ad placeholders found on this page.');
            return;
        }

        placeholders.forEach(loadAd);
    }

    /**
     * Fetches and injects an ad for a single placeholder.
     * @param {HTMLElement} placeholder - The div element for the ad.
     */
    function loadAd(placeholder) {
        const adZoneId = placeholder.dataset.adzoneId;
        if (!adZoneId) {
            console.error('Ad Server: Placeholder is missing "data-adzone-id".', placeholder);
            return;
        }

        const adUrl = `${API_BASE_URL}/ad-request/${adZoneId}`;

        fetch(adUrl)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Network response was not ok: ${response.statusText}`);
                }
                return response.json();
            })
            .then(ad => {
                if (ad.html_content && ad.placement_id) {
                    injectAd(placeholder, ad);
                }
            })
            .catch(error => {
                console.error(`Ad Server: Failed to load ad for Zone ${adZoneId}:`, error);
                placeholder.style.display = 'none'; // Hide placeholder on failure
            });
    }

    /**
     * Creates an iframe and injects the ad content, then sets up visibility tracking.
     * @param {HTMLElement} placeholder - The div element for the ad.
     * @param {object} ad - The ad object from the API.
     */
    function injectAd(placeholder, ad) {
        const iframe = document.createElement('iframe');
        iframe.srcdoc = ad.html_content;
        iframe.width = placeholder.dataset.width || '100%';
        iframe.height = placeholder.dataset.height || '100%';
        iframe.style.border = 'none';
        iframe.style.overflow = 'hidden';

        // Clear the placeholder and append the iframe
        placeholder.innerHTML = '';
        placeholder.appendChild(iframe);

        // Set up the Intersection Observer to track viewability
        setupVisibilityObserver(iframe, ad.placement_id);
    }

    /**
     * Sets up an Intersection Observer to track when the ad is visible.
     * @param {HTMLIFrameElement} iframe - The ad iframe.
     * @param {string} placementId - The unique ID for this specific ad placement.
     */
    function setupVisibilityObserver(iframe, placementId) {
        const observer = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    // Start a timer when the ad becomes visible
                    const visibilityTimer = setTimeout(() => {
                        // If the ad is still visible after the required time, record the impression
                        if (entry.intersectionRatio >= VIEWABILITY_THRESHOLD) {
                            recordImpression(placementId);
                            // Stop observing to prevent duplicate impression records
                            observer.unobserve(iframe);
                        }
                    }, VIEWABILITY_TIME);

                    // Store the timer on the iframe so we can clear it if it becomes hidden
                    iframe.dataset.visibilityTimer = visibilityTimer;
                } else {
                    // If the ad is no longer intersecting, clear any pending timer
                    if (iframe.dataset.visibilityTimer) {
                        clearTimeout(iframe.dataset.visibilityTimer);
                    }
                }
            });
        }, { threshold: VIEWABILITY_THRESHOLD });

        observer.observe(iframe);
    }

    /**
     * Sends a request to the server to record a valid ad impression.
     * @param {string} placementId - The unique placement ID.
     */
    function recordImpression(placementId) {
        // This is where we will send the telemetry data in Phase 2.
        // For now, it just hits the impression endpoint.
        const impressionUrl = `${API_BASE_URL}/impression/${placementId}`;
        const telemetryData = {
            page_url: window.location.href,
            timestamp: new Date().toISOString(),
            viewport_width: window.innerWidth,
            viewport_height: window.innerHeight,
        };

        // Use sendBeacon for reliable background sending
        const blob = new Blob([JSON.stringify(telemetryData)], { type: 'application/json; charset=UTF-8' });
        navigator.sendBeacon(impressionUrl, blob);

        console.log(`Ad Server: Impression recorded for placement ${placementId}.`);
    }

    // Run the script once the DOM is fully loaded.
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

})();
