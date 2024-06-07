<header>
    <div class="top-bar">
        <div class="logo">
            <img src="{{ asset('images/logo.png') }}" alt="Logo">
        </div>
        <nav class="menu">
            <ul>
                <li><a href="{{ route('shomepage') }}">Home</a></li>
                <li><a href="{{ route('bookings') }}">Booking</a></li>
                <li><a href="#">Profile</a></li>
                <li><a href="{{ route('learning_progress') }}">Learning Progress</a></li>
                <li><a href="{{ route('course_list') }}">Course</a></li>
                <li><a href="{{ route('tutor_list') }}">Tutor List</a></li>
                <li><a href="{{ route('show_payment_form') }}">Payment</a></li>
            </ul>
        </nav>
        <div class="profile-picture">
            @if(isset($profilePicture) && $profilePicture)
                <img src="{{ asset('storage/' . $profilePicture) }}" alt="Profile Picture" class="profile-picture">
            @else
                Your Logo
            @endif
        </div>
    </div>
</header>
