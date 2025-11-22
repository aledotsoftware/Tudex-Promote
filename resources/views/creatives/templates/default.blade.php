<head>
    <title>{{ $title }}</title>
    <style>
        :root {
            --ad-font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            --ad-bg-color: transparent;
            --ad-text-color: #4d5156;
            --ad-title-color: #1a0dab;
            --ad-desc-color: #4d5156;
            --ad-link-color: #006621;
        }
        body {
            font-family: var(--ad-font-family);
            margin: 0;
            padding: 8px;
            background-color: var(--ad-bg-color);
            box-sizing: border-box;
            width: 100%;
            height: 100%;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        a {
            text-decoration: none;
            display: block;
        }
        h1 {
            font-size: 16px;
            font-weight: 500;
            margin: 0 0 2px 0;
            color: var(--ad-title-color);
            line-height: 1.2;
        }
        h1:hover {
            text-decoration: underline;
        }
        p {
            font-size: 14px;
            margin: 0;
            color: var(--ad-desc-color);
            line-height: 1.4;
        }
        .ad-badge {
            font-size: 11px;
            color: var(--ad-text-color);
            font-weight: bold;
            margin-bottom: 2px;
            display: inline-block;
        }
    </style>
</head>
<body>
    <a href="%%CLICK_URL%%" target="_blank" class="ad-container">
        <div class="ad-header">
            <span class="ad-badge">Ad</span>
            <span class="ad-domain">{{ parse_url($click_url, PHP_URL_HOST) ?? 'example.com' }}</span>
        </div>
        <div class="ad-content">
            <div class="ad-text">
                <h1 class="ad-title">{{ $title }}</h1>
                <p class="ad-description">{{ $description }}</p>
            </div>
            <div class="ad-cta">
                <span class="cta-button">Open</span>
            </div>
        </div>
    </a>
    <style>
        :root {
            --ad-font-family: 'Roboto', 'Segoe UI', arial, sans-serif;
            --ad-bg-color: #ffffff;
            --ad-text-color: #3c4043;
            --ad-title-color: #1a0dab;
            --ad-desc-color: #3c4043;
            --ad-link-color: #202124;
            --ad-accent-color: #1a73e8;
        }
        body {
            font-family: var(--ad-font-family);
            margin: 0;
            padding: 0;
            background-color: transparent;
            width: 100%;
            height: 100%;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .ad-container {
            display: flex;
            flex-direction: column;
            width: 100%;
            height: 100%;
            box-sizing: border-box;
            padding: 12px;
            background-color: var(--ad-bg-color);
            text-decoration: none;
            border: 1px solid #dadce0;
            border-radius: 8px;
            box-shadow: 0 1px 2px rgba(60,64,67,0.3), 0 1px 3px 1px rgba(60,64,67,0.15);
            transition: box-shadow 0.2s;
        }
        .ad-container:hover {
            box-shadow: 0 1px 3px rgba(60,64,67,0.3), 0 4px 8px 3px rgba(60,64,67,0.15);
        }
        .ad-header {
            display: flex;
            align-items: center;
            margin-bottom: 8px;
            font-size: 12px;
        }
        .ad-badge {
            background-color: #fff;
            color: var(--ad-text-color);
            border: 1px solid var(--ad-text-color);
            border-radius: 3px;
            padding: 0 3px;
            margin-right: 8px;
            font-weight: bold;
            line-height: 1.2;
        }
        .ad-domain {
            color: var(--ad-link-color);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .ad-content {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            flex: 1;
        }
        .ad-text {
            flex: 1;
            min-width: 0;
            margin-right: 12px;
        }
        .ad-title {
            font-size: 18px;
            font-weight: 500;
            color: var(--ad-title-color);
            margin: 0 0 4px 0;
            line-height: 1.2;
        }
        .ad-description {
            font-size: 14px;
            color: var(--ad-desc-color);
            margin: 0;
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .ad-cta {
            display: flex;
            align-items: center;
        }
        .cta-button {
            background-color: var(--ad-accent-color);
            color: #fff;
            padding: 6px 16px;
            border-radius: 18px;
            font-size: 14px;
            font-weight: 500;
            white-space: nowrap;
        }
        /* Responsive adjustments for smaller sizes */
        @media (max-height: 60px) {
            .ad-container {
                flex-direction: row;
                align-items: center;
                padding: 4px 8px;
            }
            .ad-header {
                margin-bottom: 0;
                margin-right: 12px;
            }
            .ad-description {
                display: none;
            }
            .ad-title {
                font-size: 14px;
                margin: 0;
            }
            .cta-button {
                padding: 4px 12px;
                font-size: 12px;
            }
        }
    </style>
</body>
</html>
