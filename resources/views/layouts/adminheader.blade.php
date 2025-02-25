

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/admin/adminSidebar.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

</head>

<body>

    <body>
        <div class="sidebar">
            <nav class="sidebar close">
                <header>
                    <div class="image-text">
                        <a href="/"> <span class="image">
                            <img src="{{ asset('images/whaite.png') }}" alt="">
                        </span> </a>

                        <div class="text logo-text">
                            <a href="/" style="text-decoration: none; color:var(--primary-color)"> <span class="name">Tech Horizon</span> 
                            <span class="profession">Your Future 2.0</span>
                        </a>
                        </div>
                    </div>

                </header>

                <div class="menu-bar">
                    <div class="menu">
                        <ul class="menu-links">
                            <li class="nav-link">
                                <a href="{{ route('admin.adminhome') }}" class="active">
                                    <i class='bx bxs-dashboard icon'></i>
                                    <span class="text nav-text">Dashboard</span>
                                </a>
                            </li>

                            <li class="nav-link">
                                <a href="{{ route('admin.articles.index') }}">
                                    <i class='bx bxs-book-content icon'></i>
                                    <span class="text nav-text">Manage Articles</span>
                                </a>
                            </li>

                            <li class="nav-link">
                                <a href="{{ route('admin.articles.create') }}">
                                    <i class='bx bxs-edit icon'></i>
                                    <span class="text nav-text">Create Article</span>
                                </a>
                            </li>

                            <li class="nav-link">
                                <a href="{{ route('admin.users.index') }}">
                                    <i class='bx bxs-user-detail icon'></i>
                                    <span class="text nav-text">Manage Users</span>
                                </a>
                            </li>

                            <li class="nav-link">
                                <a href="{{ route('admin.themes.index') }}">
                                    <i class='bx bxs-category icon'></i>
                                    <span class="text nav-text">Manage Themes</span>
                                </a>
                            </li>
                            <li class="nav-link">
                                <a href="{{ route('admin.issues.index') }}">
                                    <i class='bx bxs-server icon'></i>
                                    <span class="text nav-text">Manage Numbers</span>
                                </a>
                            </li>
                            <li class="nav-link">
                                <a href="{{ route('admin.messages') }}">
                                    <i class='bx bx-conversation icon'></i>
                                    <span class="text nav-text">Messages</span>
                                </a>
                            </li>
                            <li class="nav-link">
                                <a href="{{ route('admin.settings') }}">
                                    <i class='bx bxs-cog icon'></i>
                                    <span class="text nav-text">Settings</span>
                                </a>
                            </li>

                        </ul>
                    </div>

                    <div class="bottom-content">
                        <li class="logout">
                            <a href="#">
                                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                    @csrf

                                    <span class="d-flex align-items-center"> <i class='bx bx-log-out icon' id="log"></i>
                                        <button type="submit" id="logout-btn"> Logout</button> </span>
                                </form>
                            </a>
                        </li>

                        <li class="mode">
                            <div class="sun-moon">
                                <i class='bx bx-moon icon moon'></i>
                                <i class='bx bx-sun icon sun'></i>
                            </div>
                            <span class="mode-text text">Dark mode</span>

                            <div class="toggle-switch">
                                <span class="switch"></span>
                            </div>
                        </li>

                    </div>
                </div>

            </nav>
        </div>
        <section class="home">
            <div class="text"><span>Welcome Boss,
                    <span id="admin-username" style="font-weight: 900;">{{ auth()->user()->name }}</span>
                </span></div>
            </div>
            <div class="main-content">
                <div class="header-info">

                    <div class="search-bar">
                        <input type="text" id="search-input" placeholder="Search...">
                        <button type="submit" id="search-button"><img src="{{ asset('images/icons8-search-24.png') }}" alt="Search"></button>
                        <div class="suggestions" id="suggestions"></div>
                    </div>
                    <script src="{{ asset('js/search.js') }}"></script>
                    <link rel="stylesheet" href="{{ asset('css/search.css') }}">
                    <a href="/themes">
                        <button id="theme-btn-header" action="{{ route('themes.index') }}">All Themes</button>
                    </a>
                    <a href="/">
                        <button id="theme-btn-header" action="{{ route('/.index') }}">Home </button>
                    </a>
                    <div class="user-info">
                        <img src="{{ asset('admin-image/' . ($user->user_image ?? 'admin-pro.png')) }}" alt="User Image">
                        >
                        <div>
                            <p><strong>{{ Auth::user()->name ?? 'Utilisateur' }}</strong></p>
                            <p>{{ Auth::user()->email ?? 'email@example.com' }}</p>
                        </div>
                    </div>
                </div>
            </div>

        </section>

        <script src="{{ asset('js/user/user.js') }}"></script>