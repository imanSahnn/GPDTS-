<!-- layouts/app.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <!-- Include any CSS files here -->
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        @include('tutor.sidebar')

        <!-- Main Content -->
        <div class="content">
            @yield('content')
        </div>
    </div>
    <!-- Include any JS files here -->
</body>
</html>
