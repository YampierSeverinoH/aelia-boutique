<!DOCTYPE html>
<html class="light" lang="es">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Aelia Boutique - Elegancia Sin Esfuerzo</title>
    
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:ital,wght@0,100..900;1,100..900&family=Libre+Caslon+Text:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />

    <style>
        .bio-bg {
            background-color: #0A0A0A;
            background-image: radial-gradient(circle at 50% 30%, rgba(130, 81, 89, 0.2) 0%, rgba(10, 10, 10, 1) 75%);
            min-height: 100vh;
        }

        .glass-btn {
            background: rgba(255, 255, 255, 0.04);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(197, 160, 89, 0.15);
            transition: all 0.3s ease;
        }

        .glass-btn:hover {
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(197, 160, 89, 0.4);
            transform: translateY(-2px);
        }

        .primary-glass-btn {
            background: linear-gradient(135deg, rgba(197, 160, 89, 0.85) 0%, rgba(130, 81, 89, 0.85) 100%);
            box-shadow: 0 8px 32px 0 rgba(197, 160, 89, 0.25);
            backdrop-filter: blur(4px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .primary-glass-btn:hover {
            box-shadow: 0 12px 40px 0 rgba(197, 160, 89, 0.4);
            transform: translateY(-2px);
        }
    </style>
</head>
<body class="bio-bg text-white antialiased flex flex-col items-center justify-center p-6 min-h-screen">
    @yield('content')
</body>
</html>
