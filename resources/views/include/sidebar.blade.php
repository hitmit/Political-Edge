<!-- partial: -->
<nav class="sidebar">
    <div class="sidebar-header">
        <a href="index.php" class="sidebar-brand">
            <img src="{{ asset('assets/images/pe-logo.png') }}"></span>
        </a>
        <div class="sidebar-toggler not-active">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    <div class="sidebar-body">
        <ul class="nav">
            <li class="nav-item nav-category">Main</li>
            <li class="nav-item">
                <a href="{{ route('home') }}" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Dashboard</span>
                </a>
            </li>
            <li class="nav-item nav-category">Manage Income</li>
            <li class="nav-item">
                <a href="{{ route('income.index') }}" class="nav-link">
                    <i class="link-icon" data-feather="calendar"></i>
                    <span class="link-title">Manage Income</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('income.create') }}" class="nav-link">
                    <i class="link-icon" data-feather="credit-card"></i>
                    <span class="link-title">Add Income</span>
                </a>
            </li>



            <li class="nav-item nav-category">Manage Project</li>
            <li class="nav-item">
                <a href="{{ route('project.index') }}" class="nav-link">
                    <i class="link-icon" data-feather="calendar"></i>
                    <span class="link-title">Manage Project</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('project.create') }}" class="nav-link">
                    <i class="link-icon" data-feather="credit-card"></i>
                    <span class="link-title">Add Project</span>
                </a>
            </li>
            </li>

            <li class="nav-item nav-category">Manage Expenses</li>
            <li class="nav-item">
                <a href="{{ route('expenses.index') }}" class="nav-link">
                    <i class="link-icon" data-feather="calendar"></i>
                    <span class="link-title">Manage Expenses</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('expenses.create') }}" class="nav-link">
                    <i class="link-icon" data-feather="credit-card"></i>
                    <span class="link-title">Add Expenses</span>
                </a>
            </li>
            </li>


            <li class="nav-item nav-category">Manage Users</li>
            <li class="nav-item">
                <a href="{{ route('users.index') }}" class="nav-link">
                    <i class="link-icon" data-feather="users"></i>
                    <span class="link-title">Manage Users</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('users.create') }}" class="nav-link">
                    <i class="link-icon" data-feather="user"></i>
                    <span class="link-title">Add User</span>
                </a>
            </li>
        </ul>
    </div>
</nav>
