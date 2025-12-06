<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{TITLE}}</title>
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

        .tudex-ad {
            display: flex;
            flex-direction: column;
            width: 100%;
            height: 100%;
            padding: 20px;
            background: {{BG_COLOR}};
            text-decoration: none;
            border: 1px solid {{BORDER_COLOR}};
            border-radius: 16px;
            box-shadow: 0 4px 20px -5px rgba(0, 0, 0, 0.08);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .tudex-ad::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, {{BUTTON_COLOR}}, {{BUTTON_COLOR}}cc);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .tudex-ad:hover {
            transform: translateY(-4px) scale(1.005);
            box-shadow: 0 20px 30px -10px rgba(0, 0, 0, 0.12);
            border-color: {{BUTTON_COLOR}};
        }

        .tudex-ad:hover::before {
            opacity: 1;
        }

        .tudex-ad-header {
            display: flex;
            align-items: center;
            margin-bottom: 12px;
            font-size: 11px;
            letter-spacing: 0.5px;
            opacity: 0.9;
        }

        .tudex-ad-badge {
            background-color: {{BUTTON_COLOR}}15;
            color: {{BUTTON_COLOR}};
            border-radius: 6px;
            padding: 4px 8px;
            margin-right: 10px;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 9px;
            letter-spacing: 0.5px;
        }

        .tudex-ad-domain {
            color: {{TEXT_COLOR}};
            font-weight: 500;
            opacity: 0.8;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .tudex-ad-content {
            display: flex;
            flex-direction: column;
            flex: 1;
            justify-content: space-between;
        }

        .tudex-ad-main {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .tudex-ad-title {
            font-size: 18px;
            font-weight: 800;
            color: {{TITLE_COLOR}};
            margin: 0;
            line-height: 1.25;
            letter-spacing: -0.02em;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            transition: color 0.3s ease;
        }

        .tudex-ad:hover .tudex-ad-title {
            color: {{BUTTON_COLOR}};
        }

        .tudex-ad-description {
            font-size: 14px;
            color: {{TEXT_COLOR}};
            margin: 4px 0 0 0;
            line-height: 1.5;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            opacity: 0.9;
        }

        .tudex-ad-cta {
            margin-top: 16px;
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }

        .tudex-ad-button {
            background: {{BUTTON_COLOR}};
            color: #fff;
            padding: 10px 24px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 600;
            white-space: nowrap;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 12px {{BUTTON_COLOR}}40;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .tudex-ad-button::after {
            content: '→';
            font-size: 14px;
            transition: transform 0.3s ease;
        }

        .tudex-ad:hover .tudex-ad-button {
            padding-right: 28px;
            box-shadow: 0 6px 16px {{BUTTON_COLOR}}60;
            transform: translateY(-1px);
        }

        .tudex-ad:hover .tudex-ad-button::after {
            transform: translateX(4px);
        }

        /* Shine effect */
        .tudex-ad::after {
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

        .tudex-ad:hover::after {
            animation: shine 0.75s;
        }

        @keyframes shine {
            100% { left: 125%; }
        }

        /* Responsive */
        @media (max-height: 120px) {
            .tudex-ad {
                flex-direction: row;
                padding: 12px;
                align-items: center;
            }
            
            .tudex-ad-header {
                margin: 0 16px 0 0;
                margin-bottom: 0;
            }

            .tudex-ad-content {
                flex-direction: row;
                align-items: center;
                width: 100%;
            }

            .tudex-ad-main {
                flex: 1;
                margin-right: 12px;
                gap: 4px;
            }

            .tudex-ad-description {
                display: none;
            }

            .tudex-ad-title {
                font-size: 15px;
                -webkit-line-clamp: 1;
                margin-bottom: 0;
            }

            .tudex-ad-cta {
                margin: 0;
            }

            .tudex-ad-button {
                padding: 8px 16px;
                font-size: 12px;
            }

            .tudex-ad-button::after {
                display: none;
            }

            .tudex-ad:hover .tudex-ad-button {
                padding-right: 16px;
            }
        }
    </style>
</head>
<body>
    <a href="{{CLICK_URL}}" target="_blank" class="tudex-ad">
        <div class="tudex-ad-header">
            <span class="tudex-ad-badge">Ad</span>
            <span class="tudex-ad-domain">{{DOMAIN}}</span>
        </div>
        <div class="tudex-ad-content">
            <div class="tudex-ad-main">
                <h1 class="tudex-ad-title">{{TITLE}}</h1>
                <p class="tudex-ad-description">{{DESCRIPTION}}</p>
            </div>
            <div class="tudex-ad-cta">
                <span class="tudex-ad-button">Open</span>
            </div>
        </div>
    </a>
</body>
</html>
