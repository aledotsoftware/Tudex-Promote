@php
    // Generate unique ID for this ad to avoid conflicts
    $adId = 'ad-' . substr(md5(uniqid(rand(), true)), 0, 8);
    
    // Ensure colors have defaults
    $bgColor = $bg_color ?? '#ffffff';
    $titleColor = $title_color ?? '#0f172a';
    $textColor = $text_color ?? '#64748b';
    $buttonColor = $button_color ?? '#3b82f6';
    $borderColor = $border_color ?? '#e2e8f0';
    $clickUrl = $click_url ?? '#';
    
    // Generate button gradient colors
    // Not needed in CSS-only version if we use simpler hex manipulation or CSS vars, but we can keep PHP logic if needed.
    // However, to match default.php exactly, we will try to use the same CSS logic.
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
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

        #{{ $adId }} {
            display: flex;
            flex-direction: column;
            width: 100%;
            height: 100%;
            padding: 20px;
            background: {{ $bgColor }};
            text-decoration: none;
            border: 1px solid {{ $borderColor }};
            border-radius: 16px;
            box-shadow: 0 4px 20px -5px rgba(0, 0, 0, 0.08);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        #{{ $adId }}::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, {{ $buttonColor }}, {{ $buttonColor }}cc);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        #{{ $adId }}:hover {
            transform: translateY(-4px) scale(1.005);
            box-shadow: 0 20px 30px -10px rgba(0, 0, 0, 0.12);
            border-color: {{ $buttonColor }};
        }

        #{{ $adId }}:hover::before {
            opacity: 1;
        }

        #{{ $adId }} .tudex-ad-header {
            display: flex;
            align-items: center;
            margin-bottom: 12px;
            font-size: 11px;
            letter-spacing: 0.5px;
            opacity: 0.9;
        }

        #{{ $adId }} .tudex-ad-badge {
            background-color: {{ $buttonColor }}15;
            color: {{ $buttonColor }};
            border-radius: 6px;
            padding: 4px 8px;
            margin-right: 10px;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 9px;
            letter-spacing: 0.5px;
        }

        #{{ $adId }} .tudex-ad-domain {
            color: {{ $textColor }};
            font-weight: 500;
            opacity: 0.8;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        #{{ $adId }} .tudex-ad-content {
            display: flex;
            flex-direction: column;
            flex: 1;
            justify-content: space-between;
        }

        #{{ $adId }} .tudex-ad-main {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        #{{ $adId }} .tudex-ad-title {
            font-size: 18px;
            font-weight: 800;
            color: {{ $titleColor }};
            margin: 0;
            line-height: 1.25;
            letter-spacing: -0.02em;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            transition: color 0.3s ease;
        }

        #{{ $adId }}:hover .tudex-ad-title {
            color: {{ $buttonColor }};
        }

        #{{ $adId }} .tudex-ad-description {
            font-size: 14px;
            color: {{ $textColor }};
            margin: 4px 0 0 0;
            line-height: 1.5;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            opacity: 0.9;
        }

        #{{ $adId }} .tudex-ad-cta {
            margin-top: 16px;
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }

        #{{ $adId }} .tudex-ad-button {
            background: {{ $buttonColor }};
            color: #fff;
            padding: 10px 24px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 600;
            white-space: nowrap;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 12px {{ $buttonColor }}40;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        #{{ $adId }} .tudex-ad-button::after {
            content: '→';
            font-size: 14px;
            transition: transform 0.3s ease;
        }

        #{{ $adId }}:hover .tudex-ad-button {
            padding-right: 28px;
            box-shadow: 0 6px 16px {{ $buttonColor }}60;
            transform: translateY(-1px);
        }

        #{{ $adId }}:hover .tudex-ad-button::after {
            transform: translateX(4px);
        }

        /* Shine effect */
        #{{ $adId }}::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 50%;
            height: 100%;
            background: linear-gradient(
                to right,
                transparent,
                rgba(255, 255, 255, 0.3),
                transparent
            );
            transform: skewX(-25deg);
            transition: 0.5s;
            pointer-events: none;
        }

        #{{ $adId }}:hover::after {
            animation: shine-{{ $adId }} 0.75s;
        }

        @keyframes shine-{{ $adId }} {
            100% { left: 125%; }
        }

        /* Responsive */
        @media (max-height: 120px) {
            #{{ $adId }} {
                flex-direction: row;
                padding: 12px;
                align-items: center;
            }
            
            #{{ $adId }} .tudex-ad-header {
                margin: 0 16px 0 0;
                margin-bottom: 0;
            }

            #{{ $adId }} .tudex-ad-content {
                flex-direction: row;
                align-items: center;
                width: 100%;
            }

            #{{ $adId }} .tudex-ad-main {
                flex: 1;
                margin-right: 12px;
                gap: 4px;
            }

            #{{ $adId }} .tudex-ad-description {
                display: none;
            }

            #{{ $adId }} .tudex-ad-title {
                font-size: 15px;
                -webkit-line-clamp: 1;
                margin-bottom: 0;
            }

            #{{ $adId }} .tudex-ad-cta {
                margin: 0;
            }

            #{{ $adId }} .tudex-ad-button {
                padding: 8px 16px;
                font-size: 12px;
            }

            #{{ $adId }} .tudex-ad-button::after {
                display: none;
            }

            #{{ $adId }}:hover .tudex-ad-button {
                padding-right: 16px;
            }
        }
    </style>
</head>
<body>
    <a href="{{ $clickUrl }}" target="_blank" id="{{ $adId }}">
        <div class="tudex-ad-header">
            <span class="tudex-ad-badge">Ad</span>
            <span class="tudex-ad-domain">{{ parse_url($clickUrl, PHP_URL_HOST) ?? 'promoted' }}</span>
        </div>
        <div class="tudex-ad-content">
            <div class="tudex-ad-main">
                <h1 class="tudex-ad-title">{{ $title }}</h1>
                <p class="tudex-ad-description">{{ $description }}</p>
            </div>
            <div class="tudex-ad-cta">
                <span class="tudex-ad-button">Open</span>
            </div>
        </div>
    </a>
</body>
</html>
