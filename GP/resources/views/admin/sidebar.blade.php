<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Homepage')</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            display: flex;
            min-height: 100vh;
            background-color: #f8f9fa;
            margin: 0;
        }
        .sidebar {
            width: 280px;
            background-color: #632626;
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 20px;
        }
        .content {
            flex-grow: 1;
            padding: 20px;
        }
        .sidebar hr {
            border-top-color: rgba(255, 255, 255, 0.1);
            width: 80%;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
        }
        .sidebar a:hover {
            color: #ff5252;
        }
        .sidebar .nav-link.active {
            background-color: #ff5252;
            border-radius: 5px;
        }
        .sidebar .brand-logo {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
            text-align: center;
        }
        .sidebar .brand-logo img {
            border-radius: 50%;
            margin-right: 10px;
        }
        .sidebar .user-info {
            text-align: center;
            margin-bottom: 1rem;
        }
        .sidebar .user-info h4 {
            margin: 0.5rem 0 0.2rem;
        }
        .sidebar .user-info p {
            margin: 0;
            color: #e1e1e1;
        }
        .sidebar .nav-item {
            width: 100%;
            text-align: center;
        }
        .sidebar .nav-item a {
            padding: 0.75rem 1.25rem;
            display: block;
            width: 100%;
        }
        .sidebar .btn-logout {
            margin-top: auto;
            margin-bottom: 1rem;
            width: 80%;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="brand-logo d-flex align-items-center mb-3 mb-md-0 me-md-auto link-light text-decoration-none">
            <img src="{{ asset('gp/resources/views/admin/sakapp1.png') }}" class="rounded-circle" width="50" height="50">
            <span class="fs-4 ms-2">Brand</span>
        </div>
        <hr>
        <div class="user-info">
            <img src="{{ Storage::url('public/adminpage/adminpp.jpg') }}" class="rounded-circle" width="100" height="100">
            <h4 class="mt-2">Admin Satu</h4>
            <p class="text-muted">Adminsatu1@gentianpadu.com</p>
        </div>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <a href="{{ route('homepage') }}" class="nav-link {{ request()->is('homepage') ? 'active' : '' }}">
                    <i class="bi bi-house-fill"></i>
                    Home
                </a>
            </li>
            <li>
                <a href="{{ route('student') }}" class="nav-link {{ request()->is('student') ? 'active' : '' }}">
                    <i class="bi bi-person-fill"></i>
                    Student
                </a>
            </li>
            <li>
                <a href="{{ route('tutor') }}" class="nav-link {{ request()->is('tutor') ? 'active' : '' }}">
                    <i class="bi bi-person-badge-fill"></i>
                    Tutor
                </a>
            </li>
            <li>
                <a href="{{ route('course') }}" class="nav-link {{ request()->is('course') ? 'active' : '' }}">
                    <i class="bi bi-book-fill"></i>
                    Course
                </a>
            </li>
            <li>
                <a href="{{ route('show_confirm_payment') }}" class="nav-link {{ request()->is('payment') ? 'active' : '' }}">
                    <i class="bi bi-book-fill"></i>
                    Payment
                </a>
            </li>
            <li>
                <a href="{{ route('pendingTutors') }}" class="nav-link {{ request()->is('pendingTutors') ? 'active' : '' }}">
                    <i class="bi bi-book-fill"></i>
                    Pending
                </a>
            </li>
            <li>
                <a href="{{ route('report.index') }}" class="nav-link {{ request()->is('admin/reports') ? 'active' : '' }}">
                    <i class="bi bi-book-fill"></i>
                    Report
                </a>
            </li>
        </ul>

    </ul>
        <a href="{{ route('logout') }}" class="btn btn-danger btn-logout">Logout</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
