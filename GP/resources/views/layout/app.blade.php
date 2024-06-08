<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'My Website')</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            background-color: #f0f0f0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;

        }
        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #164863;
            padding: 10px 20px;
            color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2), 0 0 10px #DDF2FD;
            border-bottom: 5px solid #122d3e;
            position: relative;
        }
        .top-bar .logo img {
            height: 40px;
        }
        .top-bar .menu ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
        }
        .top-bar .menu ul li {
            margin: 0 10px;
        }
        .top-bar .menu ul li a {
            color: white;
            text-decoration: none;
            padding: 5px 10px;
            transition: background-color 0.3s, color 0.3s;
        }
        .top-bar .menu ul li a:hover {
            background-color: #122d3e;
            border-radius: 5px;
        }
        .top-bar .profile-picture img {
            height: 60px;
            width: 60px;
            border-radius: 50%;
            border: 2px solid #9BBEC8;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .top-bar .menu-icon {
            display: none;
            font-size: 30px;
            cursor: pointer;
        }
        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.9);
            color: white;
            z-index: 1000;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }
        .overlay ul {
            list-style: none;
            margin: 0;
            padding: 0;
            text-align: center;
        }
        .overlay ul li {
            margin: 20px 0;
        }
        .overlay ul li a {
            color: white;
            text-decoration: none;
            font-size: 24px;
            transition: color 0.3s;
        }
        .overlay ul li a:hover {
            color: #DDF2FD;
        }
        .overlay .close-btn {
            position: absolute;
            top: 20px;
            right: 30px;
            font-size: 40px;
            cursor: pointer;
        }
        .content {
            padding: 20px;
            min-height: calc(100vh - 100px);
            display: flex;
            flex-direction:column;
            background: #DDF2FD;
            justify-content: space-between;

        }
        .content-box {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 1200px;
        }
        .bg-yellow-500:hover {
    background-color: #d97706;
}

.bg-red-500:hover {
    background-color: #b91c1c;
}

.bg-green-500:hover {
    background-color: #15803d;
}
        footer {
            background-color: #164863;
            color: white;
            text-align: center;
            padding: 10px ;
justify-content: center;
            width: 100%;
            bottom: 0;
            box-shadow: 0 -4px 8px rgba(0, 0, 0, 0.2), 0 0 10px #DDF2FD;
            border-top: 5px solid #122d3e;
            margin-top: auto;
            display: flex;
        }
        .overflow-x-auto {
    white-space: nowrap;
}
        @media (max-width: 768px) {
            .top-bar .menu,
            .top-bar .profile-picture {
                display: none;
            }
            .top-bar .menu-icon {
                display: block;
            }

        }
    </style>
</head>
<body>
    <div class="top-bar">
        <div class="logo">
            <img src="{{ asset('images/resized_logo.png') }}" alt="Logo">
        </div>
        <div class="menu">
            <ul>
                <li><a href="{{ route('shomepage') }}">Home</a></li>
                <li><a href="{{ route('bookings') }}">Booking</a></li>
                <li><a href="#">Profile</a></li>
                <li><a href="{{ route('learning_progress') }}">Learning Progress</a></li>
                <li><a href="{{ route('course_list') }}">Course</a></li>
                <li><a href="{{ route('tutor_list') }}">Tutor List</a></li>
                <li><a href="{{ route('show_payment_form') }}">Payment</a></li>
            </ul>
        </div>
        <div class="profile-picture">
            @if(isset($profilePicture) && $profilePicture)
                <img src="{{ asset('storage/' . $profilePicture) }}" alt="Profile Picture">
            @else
                <img src="{{ asset('images/resized_logo.png') }}" alt="Profile">
            @endif
        </div>
        <div class="menu-icon" onclick="toggleMenu()">
            &#9776; <!-- Menu icon (hamburger) -->
        </div>
    </div>

    <div class="overlay" id="overlay-menu">
        <div class="close-btn" onclick="toggleMenu()">&times;</div>
        <ul>
            <li><a href="{{ route('shomepage') }}">Home</a></li>
            <li><a href="{{ route('bookings') }}">Booking</a></li>
            <li><a href="#">Profile</a></li>
            <li><a href="{{ route('learning_progress') }}">Learning Progress</a></li>
            <li><a href="{{ route('course_list') }}">Course</a></li>
            <li><a href="{{ route('tutor_list') }}">Tutor List</a></li>
            <li><a href="{{ route('show_payment_form') }}">Payment</a></li>
        </ul>
    </div>

    <main class="content">
        <div >
            @yield('content')
        </div>
    </main>


        @include('partials.footer')


    <script>
        function toggleMenu() {
            const overlay = document.getElementById('overlay-menu');
            overlay.style.display = overlay.style.display === 'flex' ? 'none' : 'flex';
        }
    </script>
</body>
</html>
