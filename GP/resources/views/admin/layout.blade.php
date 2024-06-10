<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel Project</title>
    <link href="https://cdn.jsdelivr.net/npm/@picocss/pico@1/css/pico.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            min-height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #dc7f57; /* Background color for the body */
        }
        .sidebar {
            width: 250px;
            background-color: #FFCF9D; /* Sidebar background color */
            padding: 20px;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            overflow-y: auto;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
            flex-grow: 1;
        }
        .nav-link {
            display: flex;
            align-items: center;
            padding: 10px 15px;
            color: #333;
            text-decoration: none;
        }
        .nav-link:hover {
            background-color: #FFB000; /* Hover color for links */
        }
        .nav-link.active {
            background-color: #004225; /* Active link color */
            color: #fff;
        }
        .nav-link i {
            margin-right: 10px;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        .btn-primary {
            background-color: #FFB000; /* Primary button color */
            color: white;
        }
        .btn-primary:hover {
            background-color: #FFCF9D; /* Primary button hover color */
        }
        .alert-success {
            background-color: #FFCF9D; /* Alert success background color */
            color: white;
        }
    </style>
</head>
<body>
    @include('admin.sidebar')
    <div class="content">
        @yield('content')
    </div>
</body>
</html>
