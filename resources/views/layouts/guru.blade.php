<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title') | Panel Guru</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f1f3f6;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
        }

        /* TOPBAR */
        .topbar {
            height: 60px;
            background: #1E90FF;
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1050;
        }

        /* SIDEBAR */
        .sidebar {
            width: 240px;
            height: 100vh;
            position: fixed;
            top: 60px;
            left: 0;
            background: #1f2a37;
            color: white;
            padding-top: 20px;
            z-index: 1000;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
        }

        .sidebar a {
            color: #cfd8dc;
            padding: 14px 20px;
            display: block;
            text-decoration: none;
            transition: all 0.3s;
            font-size: 15px;
        }

        .sidebar a:hover {
            background: #2d3b4f;
            color: white;
            padding-left: 25px; /* Efek geser sedikit saat hover */
        }

        /* ACTIVE MENU */
        .active-menu {
            background: #1E90FF;
            color: white !important;
            font-weight: 600;
            border-left: 5px solid white;
        }

        /* CONTENT */
        .main-content {
            margin-left: 240px;
            margin-top: 60px;
            padding: 25px;
            min-height: calc(100vh - 60px);
        }

        /* USER DROPDOWN STYLE */
        .user-dropdown .dropdown-toggle {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 5px 12px;
            border-radius: 50px;
            transition: 0.3s;
        }

        .user-dropdown .dropdown-toggle:hover {
            background: rgba(255, 255, 255, 0.15);
        }

        .user-img-circle {
            width: 32px;
            height: 32px;
            background: #6f5bd6;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            border: 2px solid rgba(255,255,255,0.2);
        }

        /* FIX: Dropdown tabel agar tidak terpotong */
        .table-responsive {
            overflow: visible !important;
        }

        /* CUSTOM CARD COMPONENTS */
        .dashboard-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            background: white;
            margin-bottom: 20px;
        }

        .card-header-custom {
            background: white;
            border-bottom: 1px solid #edf2f7;
            padding: 18px 25px;
            border-top-left-radius: 12px !important;
            border-top-right-radius: 12px !important;
        }

        /* Responsive Mobile */
        @media (max-width: 768px) {
            .sidebar { width: 70px; }
            .sidebar a span { display: none; }
            .main-content { margin-left: 70px; }
            .user-dropdown span { display: none; }
        }
    </style>
</head>

<body>

<div class="topbar shadow-sm">
    <div class="d-flex align-items-center">
        <h5 class="mb-0 fw-bold">Ujian Online</h5>
    </div>
    
    <div class="dropdown user-dropdown">
        <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="fw-medium">{{ Auth::user()->name ?? 'Administrator' }}</span>
            <div class="user-img-circle">👤</div>
        </a>
        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
            <li>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="dropdown-item text-danger">
                        ➔ Logout
                    </button>
                </form>
            </li>
        </ul>
    </div>
</div>

@php
    // Ambil data pertama untuk link Hasil Ujian agar tidak error
    $sidebar_exam = \App\Models\Exam::first();
@endphp

<div class="sidebar shadow">
    <a href="{{ route('guru.exams.index') }}"
       class="{{ request()->routeIs('guru.exams.index') ? 'active-menu' : '' }}">
        🏠 <span>Dashboard</span>
    </a>

    <a href="{{ route('guru.exams.results.page') }}"
   class="{{ request()->routeIs('guru.exams.results*') ? 'active-menu' : '' }}">
    📑 <span>Hasil Ujian</span>
</a>



    <a href="#" class="{{ request()->is('guru/siswa*') ? 'active-menu' : '' }}">
        <!-- 👥 <span>Data Siswa</span> -->
    </a>

    <a href="#" class="{{ request()->is('guru/laporan*') ? 'active-menu' : '' }}">
        <!-- 📁 <span>Laporan Nilai</span> -->
    </a>
</div>

<div class="main-content">
    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>