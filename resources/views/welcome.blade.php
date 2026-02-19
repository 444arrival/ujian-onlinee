<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ujian Online</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex flex-col items-center justify-center bg-gray-100 text-gray-800 font-sans">

    <!-- LOGO -->
    <!-- <div class="flex justify-center">
        <img src="{{ asset('images/logo-1.png') }}" 
            alt="Logo Aplikasi"
            class="w-60 md:w-60 object-contain">
    </div> -->


    <div class="text-center space-y-6 p-6">
        <h1 class="text-4xl md:text-5xl font-bold">
            Selamat Datang di <br>
            <span class="text-gray-700">Aplikasi Ujian Online</span>
        </h1>

        <p class="text-lg md:text-xl max-w-xl mx-auto">
            Platform ujian untuk siswa & guru masa kini
        </p>

        <div class="flex flex-col md:flex-row gap-4 justify-center mt-6">
            <a href="{{ route('login.siswa') }}"
               class="px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition"
>
               Masuk Sebagai Siswa
            </a>
            <a href="{{ route('login.guru') }}"
               class="px-6 py-3 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 transition">
               Masuk Sebagai Guru
            </a>
        </div>

        <footer class="mt-10 text-sm text-gray-500">
            © {{ date('Y') }} Ujian Online • Dibuat oleh Daffa
        </footer>
    </div>

</body>
</html>
