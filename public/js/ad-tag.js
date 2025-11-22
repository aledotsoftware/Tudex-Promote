/**
 * Tudex Ads - Ad Tag
 *
 * Supports 3 Standard Display Types:
 * 1. Wide (Ancho) - data-type="wide"
 * 2. Tall (Alto) - data-type="tall"
 * 3. Square (Cuadrado) - data-type="square"
 */
(function () {
    const API_BASE_URL = 'http://127.0.0.1:8000/api';

    function init() {
        const placeholders = document.querySelectorAll('.ad-server-placeholder');
        placeholders.forEach(loadAd);

        // Automatically try to load special formats if site ID is available
        // We can get site ID from the first placeholder if available, or it should be passed in script tag
        // For now, let's check if we can find a site ID
        let siteId = null;
        const scriptTag = document.currentScript || document.querySelector('script[data-site-id]');
        if (scriptTag) {
            siteId = scriptTag.dataset.siteId;
        } else if (placeholders.length > 0) {
            siteId = placeholders[0].dataset.siteId;
        }

        if (siteId) {
            loadSpecialFormat(siteId, 'popup');
            loadSpecialFormat(siteId, 'interstitial');
        }
    }

    function loadSpecialFormat(siteId, type) {
        fetch(`${API_BASE_URL}/ad-request?site_id=${siteId}&type=${type}`)
            .then(res => {
                if (!res.ok) throw new Error(res.statusText);
                return res.json();
            })
            .then(ad => {
                if (ad.html_content) {
                    injectSpecialAd(ad, type);
                }
            })
            .catch(() => {
                // Silently fail if no special ad is returned
            });
    }

    function injectSpecialAd(ad, type) {
        const container = document.createElement('div');
        container.style.position = 'fixed';
        container.style.zIndex = '999999';
        container.style.top = '0';
        container.style.left = '0';
        container.style.width = '100%';
        container.style.height = '100%';
        container.style.display = 'flex';
        container.style.alignItems = 'center';
        container.style.justifyContent = 'center';
        container.style.backgroundColor = 'rgba(0,0,0,0.5)'; // Dimmed background

        const iframe = document.createElement('iframe');
        iframe.style.border = 'none';
        iframe.style.overflow = 'hidden';

        if (type === 'popup') {
            iframe.style.width = '300px';
            iframe.style.height = '250px';
            iframe.style.boxShadow = '0 0 20px rgba(0,0,0,0.5)';
            iframe.style.borderRadius = '10px';
        } else if (type === 'interstitial') {
            iframe.style.width = '100%';
            iframe.style.height = '100%';
        }

        // Inject content
        iframe.srcdoc = ad.html_content + '<style>body{margin:0;display:flex;align-items:center;justify-content:center;height:100%;}</style>';

        // Close button
        const closeBtn = document.createElement('button');
        closeBtn.innerText = '×';
        closeBtn.style.position = 'absolute';
        closeBtn.style.top = '10px';
        closeBtn.style.right = '10px';
        closeBtn.style.background = '#fff';
        closeBtn.style.border = 'none';
        closeBtn.style.borderRadius = '50%';
        closeBtn.style.width = '30px';
        closeBtn.style.height = '30px';
        closeBtn.style.cursor = 'pointer';
        closeBtn.style.fontSize = '20px';
        closeBtn.style.fontWeight = 'bold';
        closeBtn.style.zIndex = '1000000';

        if (type === 'popup') {
            // For popup, put close button relative to the container or just absolute on screen?
            // Let's put it on the container for simplicity, but positioned relative to the iframe would be better.
            // For now, top right of screen is easiest to implement reliably.
        }

        closeBtn.onclick = () => {
            document.body.removeChild(container);
        };

        container.appendChild(iframe);
        container.appendChild(closeBtn);
        document.body.appendChild(container);

        setupVisibilityObserver(iframe, ad.placement_id);
    }

    function loadAd(placeholder) {
        const siteId = placeholder.dataset.siteId;
        const type = placeholder.dataset.type || 'wide'; // Default to wide

        if (!siteId) {
            console.error('Tudex Ads: Placeholder missing "data-site-id".');
            return;
        }

        // Request the ad
        fetch(`${API_BASE_URL}/ad-request?site_id=${siteId}&type=${type}`)
            .then(res => {
                if (!res.ok) throw new Error(res.statusText);
                return res.json();
            })
            .then(ad => {
                if (ad.html_content) {
                    injectAd(placeholder, ad, type);
                }
            })
            .catch(err => {
                console.error('Tudex Ads: Failed to load ad.', err);
                placeholder.style.display = 'none';
            });
    }

    function injectAd(placeholder, ad, type) {
        const iframe = document.createElement('iframe');

        // Define Standard Sizes
        let width, height;

        switch (type) {
            case 'tall': // Alto (Vertical)
                width = '160px'; // Standard Skyscraper width
                height = '600px';
                break;
            case 'square': // Cuadrado (MREC)
                width = '300px';
                height = '250px';
                break;
            case 'wide': // Ancho (Banner)
            default:
                width = '100%'; // Responsive width
                height = '90px'; // Standard Leaderboard height
                break;
        }

        // Override if manual width/height provided
        if (placeholder.dataset.width) width = placeholder.dataset.width + 'px';
        if (placeholder.dataset.height) height = placeholder.dataset.height + 'px';

        // CSS Variables for the Creative to adapt
        const styles = {
            '--ad-width': width,
            '--ad-height': height,
            '--ad-type': type
        };

        let styleInjection = '<style>:root {';
        for (const [key, value] of Object.entries(styles)) {
            styleInjection += `${key}: ${value} !important;`;
        }
        styleInjection += '} body { margin: 0; overflow: hidden; display: flex; align-items: center; justify-content: center; }</style>';

        let finalHtml = ad.html_content;
        if (finalHtml.includes('<head>')) {
            finalHtml = finalHtml.replace('<head>', `<head>${styleInjection}`);
        } else {
            finalHtml = styleInjection + finalHtml;
        }

        iframe.srcdoc = finalHtml;
        iframe.style.width = width;
        iframe.style.height = height;
        iframe.style.border = 'none';
        iframe.style.overflow = 'hidden';
        iframe.style.backgroundColor = 'transparent';

        // Handle responsive wide banners (max-width constraint)
        if (type === 'wide') {
            iframe.style.maxWidth = '100%';
            iframe.style.minWidth = '300px';
        }

        placeholder.innerHTML = '';
        placeholder.appendChild(iframe);

        setupVisibilityObserver(iframe, ad.placement_id);
    }

    function setupVisibilityObserver(iframe, placementId) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting && entry.intersectionRatio >= 0.5) {
                    setTimeout(() => {
                        recordImpression(placementId);
                        observer.unobserve(iframe);
                    }, 1000);
                }
            });
        }, { threshold: 0.5 });
        observer.observe(iframe);
    }

    function recordImpression(placementId) {
        const url = `${API_BASE_URL}/impression/${placementId}`;
        const data = { page_url: window.location.href, timestamp: new Date().toISOString() };
        const blob = new Blob([JSON.stringify(data)], { type: 'application/json' });
        navigator.sendBeacon(url, blob);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
