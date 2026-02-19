@extends('layouts.auth')

@section('title', 'Register Siswa')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="bg-white rounded-lg shadow-md p-8 w-full max-w-md text-gray-800">

        <div class="text-center mb-6">
            <h2 class="text-2xl font-bold text-gray-700">Register Siswa</h2>
            <p class="text-gray-500 text-sm">Buat akun baru siswa</p>
        </div>

        <form method="POST" action="{{ route('register.siswa.post') }}">
    @csrf

    <div class="mb-4">
        <label>Nama</label>
        <input type="text" name="name" required class="w-full border rounded px-3 py-2">
    </div>

    <div class="mb-4">
        <label>NIS</label>
        <input type="text" name="nis" required class="w-full border rounded px-3 py-2">
    </div>

    <div class="mb-4">
        <label>Password</label>
        <input type="password" name="password" required class="w-full border rounded px-3 py-2">
    </div>

    <div class="mb-6">
        <label>Konfirmasi Password</label>
        <input type="password" name="password_confirmation" required
               class="w-full border rounded px-3 py-2">
    </div>

    <button type="submit" class="w-full bg-green-600 text-white py-2 rounded">
        Daftar
    </button>
</form>


    </div>
</div>
@endsection
