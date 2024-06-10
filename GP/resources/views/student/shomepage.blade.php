<!DOCTYPE html>
<html>
<head>
    <title>Homepage</title>
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js"></script>
</head>
<body>
    @extends('layout.app')

    @section('title', 'Homepage')

    @section('content')
    <div id="logoContainer" class="flex justify-center mt-10">
        <img id="companyLogo" src="{{ asset('storage/jpj/gplogo (1).png') }}" alt="Gentian Padu Driving School Logo" class="h-45 w-45 opacity-0">
    </div>
    <div id="homepageContent" class="opacity-0">
        <h2>Welcome to the Homepage</h2>
        <p>This is the content of the homepage.</p>
    </div>
    @endsection

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animate the logo to fade in and move to its final position
            gsap.to('#companyLogo', { opacity: 1, duration: 2, ease: "power2.inOut" });

            // Animate the content to fade in after the logo animation
            gsap.to('#homepageContent', { opacity: 1, duration: 2, delay: 2, ease: "power2.inOut" });
        });
    </script>
</body>
</html>
