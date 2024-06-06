<!-- resources/views/layouts/app.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Homepage')</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css">
    <style>
        body {
            display: flex;
            background-color: #151709;
            background-image: url('{{ asset('storage/adminpage/background1.jpg') }}'); /* Correct path to your background image */
            background-size: cover; /* Cover the entire content area */
            background-position: center; /* Center the image */
            background-repeat: no-repeat; /* Do not repeat the image */
        }
        .content {
            flex-grow: 1;
            margin-left: 280px; /* Adjust for sidebar width */
            padding: 20px;
            background-color: rgba(67, 120, 225, 0.8); /* Semi-transparent blue to overlay */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: 20px;
            border-radius: 8px;
            color: #000; /* Ensure text is readable */
        }
    </style>
</head>
<body>
    @include('admin.sidebar')
    <div class="content">
        @yield('content')
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
