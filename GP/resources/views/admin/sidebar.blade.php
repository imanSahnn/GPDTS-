<style>
    .sidebar {
        width: 250px;
        background-color: #343a40;
        padding: 15px;
        height: 100vh;
        position: fixed;
    }

    .nav-item {
        list-style: none;
        margin: 15px 0;
    }

    .nav-link {
        text-decoration: none;
        color: #fff;
        display: flex;
        align-items: center;
        padding: 10px 15px;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    .nav-link:hover, .nav-link.active {
        background-color: #495057;
    }

    .nav-link i {
        margin-right: 10px;
    }

    .nav-link span {
        font-size: 16px;
        font-weight: 500;
    }
</style>

<div class="sidebar">
    <ul>
        <li class="nav-item">
            <a href="{{ route('homepage') }}" class="nav-link {{ request()->is('homepage') ? 'active' : '' }}">
                <i class="bi bi-house-fill"></i> <span>Home</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('student') }}" class="nav-link {{ request()->is('student') ? 'active' : '' }}">
                <i class="bi bi-person-fill"></i> <span>Student</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('tutor') }}" class="nav-link {{ request()->is('tutor') ? 'active' : '' }}">
                <i class="bi bi-person-badge-fill"></i> <span>Tutor</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('course') }}" class="nav-link {{ request()->is('course') ? 'active' : '' }}">
                <i class="bi bi-book-fill"></i> <span>Course</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('show_confirm_payment') }}" class="nav-link {{ request()->is('payment') ? 'active' : '' }}">
                <i class="bi bi-cash-stack"></i> <span>Payment</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('pendingTutors') }}" class="nav-link {{ request()->is('pendingTutors') ? 'active' : '' }}">
                <i class="bi bi-hourglass-split"></i> <span>Pending</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('report.index') }}" class="nav-link {{ request()->is('admin/reports') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-text-fill"></i> <span>Report</span>
            </a>
        </li>
    </ul>
</div>
