 
 <!DOCTYPE html>
 <html lang="fr">

 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Dashboard</title>
     <meta name="csrf-token" content="{{ csrf_token() }}">
     <link rel="stylesheet" href="{{ asset('css/moderator/RespoSidebar.css') }}">
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
                                 <a href="{{ route('moderatorhome') }}" data-section="dashboard" class="menu-link active">
                                     <i class='bx bxs-dashboard icon'></i>
                                     <span class="text nav-text">Dashboard</span>
                                 </a>
                             </li>


                             <li class="nav-link">
                                 <a href="{{ route('moderator.articles.index') }}" data-section="articles" class="menu-link">
                                     <i class='bx bxs-book-content icon'></i>
                                     <span class="text nav-text">Articles</span>
                                 </a>
                             </li>

                             <li class="nav-link">
                                 <a href="{{ route('moderator.subscribers.index') }}" data-section="subscribers" class="menu-link">
                                     <i class='bx bx-subdirectory-right icon'></i>
                                     <span class="text nav-text">Subscribers</span>
                                 </a>
                             </li>

                             <li class="nav-link">
                                 <a href="{{ route('moderator.proposals.index') }}" data-section="subscriber-proposals" class="menu-link">
                                     <i class='bx bxs-spreadsheet icon'></i>
                                     <span class="text nav-text">Subscriber Proposals</span>
                                 </a>
                             </li>

                             <li class="nav-link">
                                 <a href="{{ route('moderator.conversations.index') }}" data-section="conversations" class="menu-link">
                                     <i class='bx bx-conversation icon'></i>
                                     <span class="text nav-text">Conversations</span>
                                 </a>
                             </li>

                             <li class="nav-link">
                                 <a href="{{ route('moderator.settings') }}" data-section="profile-settings" class="menu-link">
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
            <div class="text">
                <span>Welcome back Responsable of themes:</span>
                <div class="theme-names">
                    @foreach(auth()->user()->themes as $theme)
                        <span class="theme-badge">{{ $theme->name }}.</span>
                    @endforeach
                </div>
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
                     <div class="user-info">
                        <img src="{{ asset('admin-image/' . ($user->user_image ?? 'moderatoravatar .jpg')) }}" alt="User Image">

                        <div>
                            <p><strong>{{ Auth::user()->name ?? 'Utilisateur' }}</strong></p>
                            <p>{{ Auth::user()->email ?? 'email@example.com' }}</p>
                        </div>
                    </div>
                 </div>
             </div>

         </section>

         <script src="{{ asset('js/user/user.js') }}"></script>