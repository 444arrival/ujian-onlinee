@extends('layouts.auth')


@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="bg-white rounded-lg shadow-md p-8 w-full max-w-md">

        <h2 class="text-2xl font-bold text-center mb-6">Login Guru</h2>

        <form method="POST" action="{{ route('login.guru.post') }}">
            @csrf

            <div class="mb-4">
                <label>Email</label>
                <input type="email" name="email" required class="w-full border rounded px-3 py-2">
                @error('email') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                <label>Password</label>
                <input type="password" name="password" required class="w-full border rounded px-3 py-2">
                @error('password') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded">Masuk</button>
        </form>
    </div>
</div>
@endsection
