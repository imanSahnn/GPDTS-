<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tutor Dashboard</title>
    <style>
        body {
            display: flex;
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .sidebar {
            width: 250px;
            background-color: #2c3e50;
            color: white;
            height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
        }
        .sidebar h2 {
            margin: 0 0 20px;
        }
        .profile-pic {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background-color: #ecf0f1;
            margin-bottom: 20px;
        }
        .sidebar ul {
            list-style-type: none;
            padding: 0;
            width: 100%;
        }
        .sidebar ul li {
            width: 100%;
        }
        .sidebar ul li a {
            text-decoration: none;
            color: white;
            display: block;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .sidebar ul li a:hover {
            background-color: #34495e;
        }
        .logout {
            margin-top: auto;
        }
        .logout a {
            text-decoration: none;
            color: white;
            display: block;
            padding: 10px 20px;
            border-radius: 5px;
            background-color: #e74c3c;
            text-align: center;
            transition: background-color 0.3s;
        }
        .logout a:hover {
            background-color: #c0392b;
        }
        .content {
            flex-grow: 1;
            padding: 20px;
        }
        .booking-card {
            background-color: #fff;
            border-radius: 0.5rem;
            padding: 1.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="flex">
    <div class="sidebar bg-gray-800 text-white h-screen w-64 flex flex-col items-center p-4">
        <h2 class="text-2xl mb-4">Gentina Padu</h2>
        <div class="profile-pic bg-gray-400 w-24 h-24 rounded-full mb-4"></div>
        <ul class="w-full">
            <li class="mb-2"><a href="{{ route('tutorhomepage') }}" class="block p-2 hover:bg-gray-700">Home</a></li>
            <li class="mb-2"><a href="{{ route('tutor_bookings') }}" class="block p-2 hover:bg-gray-700">Booking</a></li>
            <li class="mb-2"><a href="{{ route('tutor.profile') }}" class="block p-2 hover:bg-gray-700">Profile</a></li>
            <li class="mb-2"><a href="{{ route('tutor.students') }}" class="block p-2 hover:bg-gray-700">Students</a></li>
        </ul>
        <div class="logout mt-auto">
            <a href="{{ route('logout') }}" class="block p-2 bg-red-600 hover:bg-red-500">Log Out</a>
        </div>
    </div>
    <div class="content flex-1 p-6">
        @yield('content')
    </div>
</body>
</html>
