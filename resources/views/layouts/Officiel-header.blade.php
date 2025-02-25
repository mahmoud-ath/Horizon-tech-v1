<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tech Horizons</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/accueil/header-page.css') }}">
</head>

<body>
    <!-- HEADER Section -->
    <header>
        <nav class="navbar">
            <div class="logo">
                <a href="/"><img src="{{ asset('images/whaite.png') }}" alt="Logo"></a>
                <a href="/" style="text-decoration: none;"> <h1>Tech Horizons</h1> </a>
            </div>
            <div class="search-bar">
                <input type="search" name="query" id="search-input" placeholder="Rechercher...">
                <button type="submit" id="search-button"><img src="{{ asset('images/icons8-search-24.png') }}" alt="Search"></button>
                <div class="suggestions" id="suggestions"></div>
            </div>
            <ul class="nav-links">
                <li><a href="/" class="more">Accueil</a></li>
                <li><a href="/themes" class="more">Themes</a></li>
                @auth
                <li><a href="/home" class="more"> My Dashboard</a></li>
                <li class="logout">
                    <a href="#">
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                                <button type="submit" id="logout-btn" > Logout</button> </span>
                        </form>
                    </a>
                </li>
                @else
                <li><a href="/register" class="btn">Create an account</a></li>
                <li><a href="/login" class="more">Login</a></li>
                @endauth
            </ul>
        </nav>
    </header>