<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Student Dashboard')</title>
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }
        .top-bar {
            width: 100%;
            height: 50px;
            background-color: #333;
            color: #fff;
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            box-sizing: border-box;
            z-index: 1000;
        }
        .top-bar .menu-button {
            display: none;
            font-size: 24px;
            cursor: pointer;
        }
        .sidebar {
            height: calc(100vh - 50px);
            width: 200px;
            background-color: #333;
            color: #fff;
            position: fixed;
            top: 50px;
            left: 0;
            padding-top: 20px;
            transition: width 0.3s, max-height 0.3s, transform 0.3s;
            z-index: 900;
        }
        .sidebar.dropdown {
            width: 100%;
            height: auto;
            max-height: 0;
            top: 50px;
            left: 0;
            overflow: hidden;
            transform: translateY(-100%);
            position: absolute;
        }
        .sidebar.show {
            max-height: calc(100vh - 50px);
            transform: translateY(0);
        }
        .sidebar h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .sidebar ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }
        .sidebar li {
            padding: 10px 0;
            text-align: center;
        }
        .sidebar a {
            color: #fff;
            text-decoration: none;
        }
        .content {
            margin-left: 200px;
            padding: 70px 20px 20px 20px;
            transition: margin-left 0.3s;
        }
        .content.full-width {
            margin-left: 0;
        }
        .profile-picture {
            border-radius: 50%;
            overflow: hidden;
            width: 80px;
            height: 80px;
            margin: 0 auto;
            display: block;
        }
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                max-height: 0;
                transform: translateY(-100%);
                position: absolute;
            }
            .sidebar.show {
                max-height: calc(100vh - 50px);
                transform: translateY(0);
            }
            .content {
                margin-left: 0;
                margin-top: 50px;
            }
            .top-bar .menu-button {
                display: block;
            }
            .sidebar h1 {
                font-size: 16px;
            }
            .sidebar ul li {
                padding: 5px 0;
            }
        }
    </style>
</head>
<body>
    <div class="top-bar">
        <span class="menu-button" onclick="toggleSidebar()">&#9776;</span>
        <span>Logo</span>
    </div>

    <div class="sidebar">
        <h1>
            @if(isset($profilePicture) && $profilePicture)
                <img src="{{ asset('storage/' . $profilePicture) }}" alt="Profile Picture" class="profile-picture">
            @else
                Your Logo
            @endif
        </h1>
        <ul>
            <li><a href="{{ route('shomepage') }}">Home</a></li>
            <li><a href="{{ route('bookings') }}">Booking</a></li>
            <li><a href="#">Profile</a></li>
            <li><a href="{{ route('tutor_list') }}">Learning Progress</a></li>
            <li><a href="{{ route('course_list') }}">Course</a></li>
        </ul>
    </div>

    <div class="content">
        @yield('content')
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            sidebar.classList.toggle('show');
        }

        function checkScreenSize() {
            const sidebar = document.querySelector('.sidebar');
            const content = document.querySelector('.content');
            if (window.innerWidth <= 768) {
                sidebar.classList.add('dropdown');
                sidebar.classList.remove('show');
                content.classList.add('full-width');
            } else {
                sidebar.classList.remove('dropdown');
                sidebar.classList.remove('show');
                content.classList.remove('full-width');
            }
        }

        window.addEventListener('resize', checkScreenSize);
        window.addEventListener('load', checkScreenSize);
    </script>
</body>
</html>
