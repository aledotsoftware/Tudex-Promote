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
            padding: 16px;
            background: {{BG_COLOR}};
            text-decoration: none;
            border: 1px solid {{BORDER_COLOR}};
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease;
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
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        .tudex-ad:hover::before {
            opacity: 1;
        }

        .tudex-ad-header {
            display: flex;
            align-items: center;
            margin-bottom: 8px;
            font-size: 11px;
            letter-spacing: 0.5px;
        }

        .tudex-ad-badge {
            background-color: {{BORDER_COLOR}};
            color: {{TEXT_COLOR}};
            border-radius: 4px;
            padding: 2px 6px;
            margin-right: 8px;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 10px;
        }

        .tudex-ad-domain {
            color: {{TEXT_COLOR}};
            font-weight: 500;
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
            justify-content: space-between;
            align-items: flex-start;
            gap: 12px;
        }

        .tudex-ad-text {
            flex: 1;
            min-width: 0;
        }

        .tudex-ad-title {
            font-size: 16px;
            font-weight: 700;
            color: {{TITLE_COLOR}};
            margin: 0 0 6px 0;
            line-height: 1.3;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .tudex-ad-description {
            font-size: 13px;
            color: {{TEXT_COLOR}};
            margin: 0;
            line-height: 1.5;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .tudex-ad-cta {
            margin-top: 12px;
            display: flex;
            justify-content: flex-end;
        }

        .tudex-ad-button {
            background: linear-gradient(135deg, {{BUTTON_COLOR}}, {{BUTTON_COLOR}}cc);
            color: #fff;
            padding: 8px 20px;
            border-radius: 9999px;
            font-size: 13px;
            font-weight: 600;
            white-space: nowrap;
            transition: all 0.2s ease;
            box-shadow: 0 2px 4px {{BUTTON_COLOR}}4d;
        }

        .tudex-ad:hover .tudex-ad-button {
            transform: scale(1.05);
            box-shadow: 0 4px 6px {{BUTTON_COLOR}}66;
        }

        /* Responsive adjustments */
        @media (max-height: 90px) {
            .tudex-ad {
                flex-direction: row;
                align-items: center;
                padding: 8px 12px;
            }
            
            .tudex-ad-header {
                margin-bottom: 0;
                margin-right: 12px;
                flex-shrink: 0;
            }

            .tudex-ad-content {
                flex-direction: row;
                align-items: center;
                width: 100%;
            }

            .tudex-ad-main {
                flex: 1;
                align-items: center;
                margin-right: 12px;
            }

            .tudex-ad-description {
                display: none;
            }

            .tudex-ad-title {
                font-size: 14px;
                margin: 0;
                -webkit-line-clamp: 1;
            }

            .tudex-ad-cta {
                margin-top: 0;
                flex-shrink: 0;
            }

            .tudex-ad-button {
                padding: 6px 16px;
                font-size: 12px;
            }
            
            .tudex-ad::before {
                height: 100%;
                width: 4px;
            }
        }
    </style>
</head>
<body>
    <a href="%%CLICK_URL%%" target="_blank" class="tudex-ad">
        <div class="tudex-ad-header">
            <span class="tudex-ad-badge">Ad</span>
            <span class="tudex-ad-domain">{{DOMAIN}}</span>
        </div>
        <div class="tudex-ad-content">
            <div class="tudex-ad-main">
                <div class="tudex-ad-text">
                    <h1 class="tudex-ad-title">{{TITLE}}</h1>
                    <p class="tudex-ad-description">{{DESCRIPTION}}</p>
                </div>
            </div>
            <div class="tudex-ad-cta">
                <span class="tudex-ad-button">Open</span>
            </div>
        </div>
    </a>
</body>
</html>
