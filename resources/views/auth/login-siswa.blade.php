@extends('layouts.auth')


@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="bg-white rounded-lg shadow-md p-8 w-full max-w-md">

        <h2 class="text-2xl font-bold text-center mb-6">Login Siswa</h2>

        @if(session('success'))
    <div class="mb-4 bg-green-100 text-green-700 px-4 py-2 rounded text-sm">
        {{ session('success') }}
    </div>
@endif


        <form method="POST" action="{{ route('login.siswa.post') }}">
            @csrf

            <div class="mb-4">
                <label>NIS</label>
                <input type="text" name="nis" required class="w-full border rounded px-3 py-2">
                @error('nis') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                <label>Password</label>
                <input type="password" name="password" required class="w-full border rounded px-3 py-2">
                @error('password') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded">Masuk</button>

            <p class="text-center mt-4 text-sm">
                Belum punya akun? <a href="{{ route('register.siswa') }}" class="text-blue-600">Daftar</a>
            </p>
        </form>
    </div>
</div>
@endsection
