<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Layout</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            min-height: 100vh;
            background-color: #f3f4f6; /* Light background for the entire page */
        }
        .sidebar {
            width: 250px;
            background-color: #abc3e5; /* Dark background for the sidebar */
            padding: 20px;
            text-align: center;
            color: rgb(0, 0, 0); /* White text color */
        }
        .sidebar h1 {
            font-size: 24px;
            margin-bottom: 10px;
        }
        .sidebar .logo {
            margin-bottom: 10px;
            border-radius: 50%; /* Make the logo circular */
        }
        .sidebar .admin-name {
            font-size: 18px;
            margin-bottom: 20px;
        }
        .sidebar .nav-item {
            margin-bottom: 20px; /* Slightly reduced spacing */
        }
        .sidebar .nav-link {
            color: rgb(0, 0, 0);
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            padding: 10px;
            transition: background-color 0.3s; /* Smooth background color transition */
        }
        .sidebar .nav-link span {
            margin-left: 10px;
        }
        .sidebar .nav-link:hover {
            background-color: #374151; /* Darker background on hover */
            border-radius: 5px;
        }
        .sidebar .nav-link.active {
            font-weight: bold;
            background-color: #4771cd; /* Blue background for active link */
            border-radius: 5px;
        }
        .content {
            flex-grow: 1;
            padding: 20px;
            max-width: 1500px;
            margin: 0 auto;
            background-color: white; /* White background for content */
            border-radius: 8px; /* Rounded corners */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Subtle shadow for content */
        }
        @media print {
            body * {
                visibility: hidden;
            }
            .content, .content * {
                visibility: visible;
            }
            .content {
                position: absolute;
                left: 0;
                top: 0;
            }
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="sidebar">
        <h1>Gentian Padu</h1>
        <img src="{{ asset('logo.png') }}" alt="Logo" class="logo w-24 h-24 mx-auto mb-4">
        <div class="admin-name">Admin 1</div>
        <ul>
            <li class="nav-item">
                <a href="{{ route('homepage') }}" class="nav-link {{ request()->routeIs('homepage') ? 'active' : '' }}">
                    <i class="bi bi-house-fill"></i> <span>Home</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('student') }}" class="nav-link {{ request()->routeIs('student') ? 'active' : '' }}">
                    <i class="bi bi-person-fill"></i> <span>Student</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('tutor') }}" class="nav-link {{ request()->routeIs('tutor') ? 'active' : '' }}">
                    <i class="bi bi-person-badge-fill"></i> <span>Tutor</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('course') }}" class="nav-link {{ request()->routeIs('course') ? 'active' : '' }}">
                    <i class="bi bi-book-half"></i> <span>Course</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('show_confirm_payment') }}" class="nav-link {{ request()->routeIs('show_confirm_payment') ? 'active' : '' }}">
                    <i class="bi bi-cash-stack"></i> <span>Payment</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('pendingTutors') }}" class="nav-link {{ request()->routeIs('pendingTutors') ? 'active' : '' }}">
                    <i class="bi bi-hourglass-split"></i> <span>Pending</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.showReportForm') }}" class="nav-link {{ request()->routeIs('admin.showReportForm') ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-text-fill"></i> <span>Report</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.jpj') }}" class="nav-link {{ request()->routeIs('admin.jpj') ? 'active' : '' }}">
                    <i class="bi bi-calendar-range-fill"></i> <span>JPJ Test</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="content">
        @yield('content')
    </div>
</body>
</html>
