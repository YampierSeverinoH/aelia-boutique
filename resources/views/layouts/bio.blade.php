<!DOCTYPE html>
<html class="light" lang="es">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Aelia Boutique - Elegancia Sin Esfuerzo</title>
    
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Libre+Caslon+Text:ital,wght@0,400;0,700;1,400&family=Hanken+Grotesk:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet" />

    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "on-tertiary": "#ffffff",
                        "tertiary": "#42664c",
                        "on-tertiary-fixed": "#00210e",
                        "ink-black": "#1A1A1A",
                        "secondary-fixed-dim": "#e9c176",
                        "on-tertiary-fixed-variant": "#2a4e35",
                        "on-surface-variant": "#514345",
                        "surface-container-high": "#f0e6e6",
                        "surface-variant": "#ebe0e0",
                        "on-secondary-fixed-variant": "#5d4201",
                        "on-primary": "#ffffff",
                        "secondary-container": "#fed488",
                        "on-tertiary-container": "#2c5037",
                        "on-primary-container": "#693b43",
                        "tertiary-container": "#9ac2a2",
                        "inverse-on-surface": "#f9eeee",
                        "on-surface": "#1f1a1b",
                        "outline": "#837375",
                        "soft-gray": "#F5F5F5",
                        "tertiary-fixed": "#c3edcb",
                        "background": "#fff8f7",
                        "inverse-primary": "#f5b6bf",
                        "surface": "#fff8f7",
                        "tertiary-fixed-dim": "#a8d0b0",
                        "on-secondary": "#ffffff",
                        "blush-silk": "#FDF3F4",
                        "antique-gold": "#B38B4D",
                        "error": "#ba1a1a",
                        "secondary": "#775a19",
                        "on-secondary-container": "#785a1a",
                        "primary-container": "#e5a8b1",
                        "surface-container-highest": "#ebe0e0",
                        "error-container": "#ffdad6",
                        "on-background": "#1f1a1b",
                        "primary-fixed": "#ffd9de",
                        "inverse-surface": "#352f2f",
                        "surface-bright": "#fff8f7",
                        "outline-variant": "#d5c2c4",
                        "on-error": "#ffffff",
                        "surface-tint": "#825159",
                        "on-primary-fixed": "#330f17",
                        "primary-fixed-dim": "#f5b6bf",
                        "on-secondary-fixed": "#261900",
                        "secondary-fixed": "#ffdea5",
                        "on-error-container": "#93000a",
                        "surface-container-low": "#fcf1f1",
                        "surface-dim": "#e2d8d8",
                        "surface-container": "#f6ebec",
                        "surface-container-lowest": "#ffffff",
                        "primary": "#825159",
                        "on-primary-fixed-variant": "#673a42"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.125rem",
                        "lg": "0.25rem",
                        "xl": "0.5rem",
                        "full": "0.75rem"
                    },
                    "spacing": {
                        "stack-lg": "32px",
                        "margin-mobile": "20px",
                        "stack-sm": "8px",
                        "container-max": "1440px",
                        "stack-md": "16px",
                        "gutter": "24px",
                        "margin-desktop": "64px",
                        "section-gap": "120px"
                    },
                    "fontFamily": {
                        "headline-md": ["Libre Caslon Text"],
                        "label-sm": ["Hanken Grotesk"],
                        "headline-lg": ["Libre Caslon Text"],
                        "display-lg": ["Libre Caslon Text"],
                        "body-lg": ["Hanken Grotesk"],
                        "headline-lg-mobile": ["Libre Caslon Text"],
                        "body-md": ["Hanken Grotesk"],
                        "label-md": ["Hanken Grotesk"],
                        "title-lg": ["Hanken Grotesk"]
                    },
                    "fontSize": {
                        "headline-md": ["28px", { "lineHeight": "36px", "fontWeight": "400" }],
                        "label-sm": ["12px", { "lineHeight": "16px", "letterSpacing": "0.08em", "fontWeight": "600" }],
                        "headline-lg": ["40px", { "lineHeight": "48px", "fontWeight": "400" }],
                        "display-lg": ["64px", { "lineHeight": "72px", "letterSpacing": "-0.02em", "fontWeight": "400" }],
                        "body-lg": ["18px", { "lineHeight": "28px", "fontWeight": "400" }],
                        "headline-lg-mobile": ["32px", { "lineHeight": "40px", "fontWeight": "400" }],
                        "body-md": ["16px", { "lineHeight": "24px", "fontWeight": "400" }],
                        "label-md": ["14px", { "lineHeight": "20px", "letterSpacing": "0.1em", "fontWeight": "500" }],
                        "title-lg": ["20px", { "lineHeight": "28px", "letterSpacing": "0.05em", "fontWeight": "600" }]
                    }
                },
            },
        }
    </script>
    <style>
        .link-btn {
            background: #ffffff;
            border: 1px solid rgba(130, 81, 89, 0.15);
            transition: all 0.3s ease;
        }

        .link-btn:hover {
            border-color: rgba(130, 81, 89, 0.4);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(130, 81, 89, 0.05);
        }

        .primary-link-btn {
            background: linear-gradient(135deg, #825159 0%, #a26b74 100%);
            box-shadow: 0 4px 12px rgba(130, 81, 89, 0.2);
        }

        .primary-link-btn:hover {
            box-shadow: 0 6px 16px rgba(130, 81, 89, 0.3);
            transform: translateY(-2px);
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 300, 'GRAD' 0, 'opsz' 24;
        }
    </style>
</head>
<body class="bg-surface text-on-surface antialiased min-h-screen flex flex-col md:flex-row">
    @yield('content')
</body>
</html>
