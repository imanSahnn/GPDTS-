<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar Layout</title>
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
            justify-content: space-between; /* Added for spacing between elements */
            padding: 0 20px;
            box-sizing: border-box;
            z-index: 1000; /* Ensure the top bar stays on top */
        }

        .top-bar .menu-button {
            display: none; /* Hidden by default */
            font-size: 24px;
            cursor: pointer;
        }

        .sidebar {
            height: calc(100vh - 50px); /* Adjust for top bar */
            width: 200px; /* Default width for larger screens */
            background-color: #333;
            color: #fff;
            position: fixed;
            top: 50px; /* Adjust for top bar */
            left: 0;
            padding-top: 20px;
            transition: width 0.3s, max-height 0.3s, transform 0.3s; /* Add smooth transition effect */
            z-index: 900; /* Ensure it stays below the top bar */
        }

        .sidebar.dropdown {
            width: 100%;
            height: auto;
            max-height: 0;
            top: 50px;
            left: 0;
            overflow: hidden;
            transform: translateY(-100%);
            position: absolute; /* Position absolute to overlay content */
        }

        .sidebar.show {
            max-height: calc(100vh - 50px); /* Show sidebar by setting its height */
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
            margin-left: 200px; /* Adjusted for larger sidebar width */
            padding: 70px 20px 20px 20px; /* Adjust padding for top bar and sidebar */
            transition: margin-left 0.3s; /* Smooth transition for content margin */
        }

        .content.full-width {
            margin-left: 0; /* Full width when sidebar is hidden */
        }

        /* Add this CSS to make the profile picture round */
        .profile-picture {
            border-radius: 50%;
            overflow: hidden;
            width: 80px; /* Adjust the size as needed */
            height: 80px; /* Adjust the size as needed */
            margin: 0 auto;
            display: block;
        }

        /* Media query for smaller screens */
        @media (max-width: 768px) {
            .sidebar {
                width: 100%; /* Full width for smaller screens */
                height: auto;
                max-height: 0; /* Initially hide the sidebar */
                transform: translateY(-100%); /* Hide the sidebar above the viewport */
                position: absolute; /* Position absolute to overlay content */
            }

            .sidebar.show {
                max-height: calc(100vh - 50px); /* Set the height to full viewport height minus the top bar */
                transform: translateY(0); /* Show the sidebar */
            }

            .content {
                margin-left: 0; /* Full width for content on smaller screens */
                margin-top: 50px; /* Maintain content margin for top bar */
            }

            .top-bar .menu-button {
                display: block; /* Show the menu button on smaller screens */
            }

            .sidebar h1 {
                font-size: 16px; /* Adjust the font size for smaller screens */
            }

            .sidebar ul li {
                padding: 5px 0; /* Reduce padding for smaller screens */
            }
        }

        /* Additional styles for the dropdown content */
        .dropdown-content {
            display: none;
            background-color: #444;
            color: #fff;
            padding: 10px;
            text-align: left;
        }

        .dropdown-content a {
            color: #fff;
            text-decoration: none;
            display: block;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="top-bar">
        <span class="menu-button" onclick="toggleSidebar()"></span>
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
            <li>
                <a href="{{ route('bookings') }}">Booking </a>
            </li>
            <li><a href="#">Profile</a></li>
            <li><a href="{{ route('tutor_list') }}">Learning Progress</a></li>
            <li><a href="{{ route('course_list') }}">Course</a></li>
        </ul>
    </div>

    <div class="content">
        <!-- Content goes here -->
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

        function toggleDropdown() {
            const dropdown = document.getElementById('bookingDropdown');
            dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
        }

        window.addEventListener('resize', checkScreenSize);
        window.addEventListener('load', checkScreenSize);
    </script>
</body>
</html>
