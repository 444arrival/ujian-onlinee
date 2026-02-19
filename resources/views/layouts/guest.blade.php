<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Ujian Online</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            background: #f3f5fa !important;
            margin: 0;
        }
    </style>
</head>
<body>

    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="w-full max-w-xl">
            @yield('content')
        </div>
    </div>

</body>
</html>
