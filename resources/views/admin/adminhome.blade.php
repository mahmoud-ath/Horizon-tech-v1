@include('layouts.adminheader')
<link rel="stylesheet" href="{{ asset('css/admin/dashbord.css') }}">
 <!-- Dashboard Section -->
<section id="dashboard">
            <h2>Latest Statistics</h2>
            <div class="stats-grid">
                <div class="stat-card">
                    <h3>Subscribers</h3>
                    <div class="stat-content">
                        <div class="stat-item">
                            <span>Total Subscribers</span>
                            <span id="total-subscribers">{{ $totalSubscribers }}</span>
                        </div>
                    </div>
                </div>

                <div class="stat-card">
                    <h3>Themes</h3>
                    <div class="stat-content">
                        <div class="stat-item">
                            <span>Total Themes</span>
                            <span id="total-themes">{{ $totalThemes }}</span>
                        </div>
                        <div class="stat-item">
                            <span>Public Themes</span>
                            <span id="active-responsible-themes">{{ $publicThemes }}</span>
                        </div>
                        <div class="stat-item">
                            <span>Private Themes</span>
                            <span id="active-responsible-themes">{{ $privatethemes }}</span>
                        </div>
                    </div>
                </div>

                <div class="stat-card">
                    <h3>Numbers</h3>
                    <div class="stat-content">
                        <div class="stat-item">
                            <span>Total Numbers</span>
                            <span id="total-numbers">{{ $totalNumbers }}</span>
                        </div>
                        <div class="stat-item">
                            <span>Published Numbers</span>
                            <span id="published-numbers">{{ $publishedNumbers }}</span>
                        </div>
                        <div class="stat-item">
                            <span>Private Numbers</span>
                            <span id="published-numbers">{{ $privateNumbers }}</span>
                        </div>
                    </div>
                </div>

                <div class="stat-card">
                    <h3>Articles</h3>
                    <div class="stat-content">
                        <div class="stat-item">
                            <span>Total Articles</span>
                            <span id="total-articles">{{ $totalArticles }}</span>
                        </div>
                        <div class="stat-item">
                            <span>Published Articles</span>
                            <span id="published-articles">{{ $publishedArticles }}</span>
                        </div>
                        <div class="stat-item">
                            <span>Pending Articles</span>
                            <span id="pending-articles">{{ $pendingArticles }}</span>
                        </div>
                    </div>
                </div>
            </div>
</section>


      
    <script src="{{ asset('js/admin/dashboard.js') }}"></script>

</body>
</html>
