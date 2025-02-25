@include('layouts.moderatorheader')
<link rel="stylesheet" href="{{ asset('css/moderator/dashboard.css') }}">
<!-- Sections -->
<section id="dashboard" class="active">
    <h1>Dashboard Overview</h1>
    <div class="dashboard-summary">
        <div class="stat-box">
            <h3>Articles</h3>
            <p id="articles-count">{{ $articlesCount }}</p>
        </div>
        <div class="stat-box">
            <h3>Subscribers</h3>
            <p id="subscribers-count">{{ $subscriberCount }}</p>
        </div>
        <div class="stat-box">
            <h3>Conversations</h3>
            <p id="conversations-count">{{ $conversationsCount }}</p>
        </div>
    </div>
</section>


</body>
</html>


<!-- Include the JavaScript for updating dashboard -->
<script src="{{ asset('js/moderator/dashboard.js') }}"></script>

