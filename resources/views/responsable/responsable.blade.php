<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsable Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/respo.css') }}">
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <img src="{{ asset('images/user.png') }}" alt="Profile" class="admin-img" id="admin-img" />
        </div>
        <ul class="sidebar-menu">
            <li><a href="#dashboard" data-section="dashboard" class="menu-link active">Dashboard</a></li>
            <li><a href="#articles" data-section="articles" class="menu-link">Articles</a></li>
            <li><a href="#subscribers" data-section="subscribers" class="menu-link">Subscribers</a></li>
            <li><a href="#subscriber-proposals" data-section="subscriber-proposals" class="menu-link">Subscriber Proposals</a></li>
            <li><a href="#conversations" data-section="conversations" class="menu-link">Conversations</a></li>
            <li><a href="#profile-settings" data-section="profile-settings" class="menu-link">Profile Settings</a></li>
        </ul>
    </div>

    <!-- Main Content Area -->
    <div class="main-content">
        <div class="header-info">
            <span>Welcome back, <span id="admin-username" style="font-weight: 900;">Responsable {{ Auth::user()->name }}</span></span>
            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                @csrf
                <button type="submit" id="logout-btn">Logout</button>
            </form>
        </div>

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

        <!-- Manage Articles Section -->
        <section id="articles">
            <h1>Manage Articles</h1>
            <div class="articles-table">
                <h2>All Articles</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Theme</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="articles-list">
                        <!-- Example row -->
                        <tr>
                            <td>How to Improve Your Focus</td>
                            <td>Motivation</td>
                            <td>En Cours</td>
                            <td>
                                <button class="view-btn" data-id="1">View</button>
                                <button class="delete-btn" data-id="1">Delete</button>
                                <button class="publish-btn" data-id="1">Publish</button>
                            </td>
                        </tr>
                        <tr>
                            <td>Mastering Time Management</td>
                            <td>Productivity</td>
                            <td>En Cours</td>
                            <td>
                                <button class="view-btn" data-id="2">View</button>
                                <button class="delete-btn" data-id="2">Delete</button>
                                <button class="publish-btn" data-id="2">Publish</button>
                            </td>
                        </tr>
                        <!-- More rows will be generated dynamically -->
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Manage Subscriber Proposals Section -->
        <section id="subscriber-proposals">
            <h1>Manage Subscriber Proposals</h1>
            <div class="proposals-table">
                <h2>Subscriber Article Proposals</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Theme</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="proposals-list">
                        <!-- Example row -->
                        <tr>
                            <td>Building a Positive Mindset</td>
                            <td>Motivation</td>
                            <td>Proposed</td>
                            <td>
                                <button class="delete-proposal-btn" data-id="1">Delete</button>
                                <button class="propose-edit-btn" data-id="1">Propose for Editing</button>
                            </td>
                        </tr>
                        <tr>
                            <td>Time Management Tips</td>
                            <td>Productivity</td>
                            <td>Proposed</td>
                            <td>
                                <button class="delete-proposal-btn" data-id="2">Delete</button>
                                <button class="propose-edit-btn" data-id="2">Propose for Editing</button>
                            </td>
                        </tr>
                        <!-- More rows will be generated dynamically -->
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Manage Subscribers Section -->
        <section id="subscribers">
            <h1>Manage Subscribers</h1>
            <div class="subscribers-table">
                <table>
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="subscribers-list">
                        <!-- Example row -->
                        <tr>
                            <td>JohnDoe</td>
                            <td>johndoe@example.com</td>
                            <td>Subscribed</td>
                            <td>
                                <button class="unsubscribe-btn" data-id="1">Unsubscribe</button>
                            </td>
                        </tr>
                        <tr>
                            <td>JaneSmith</td>
                            <td>janesmith@example.com</td>
                            <td>Not Subscribed</td>
                            <td>
                                <button class="subscribe-btn" data-id="2">Subscribe</button>
                            </td>
                        </tr>
                        <!-- More rows will be generated dynamically -->
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Conversations Section -->
        <section id="conversations">
            <h1>Manage Conversations</h1>
            <div class="conversations-table">
                <h2>All Conversations</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Message</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="conversations-list">
                        <!-- Example row -->
                        <tr>
                            <td>Great article! I loved it.</td>
                            <td>Approved</td>
                            <td>
                                <button class="delete-conversation-btn" data-id="1">Delete</button>
                            </td>
                        </tr>
                        <tr>
                            <td>Very informative, looking forward to the next post!</td>
                            <td>Approved</td>
                            <td>
                                <button class="delete-conversation-btn" data-id="2">Delete</button>
                            </td>
                        </tr>
                        <!-- More rows will be generated dynamically -->
                    </tbody>
                </table>
            </div>
        </section>


        <section id="profile-settings">
    <h1>Profile Settings</h1>
    <form id="update-profile-form" method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf
        <!-- Username input -->
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" placeholder="Your username" required />
        </div>
        <div class="form-group">
            <label for="password">New Password:</label>
            <input type="password" id="password" name="password" placeholder="Your password" required />
        </div>

        <!-- Profile image input -->
        <div class="form-group">
            <label for="profile-img">Profile Image:</label>
            <input type="file" id="profile-img" name="profile_img" accept="image/*" />
        </div>

        <!-- Submit button -->
        <button type="submit" class="submit-btn">Update Profile</button>
    </form>
</section>
<script src="{{ asset('js/respo.js') }}"></script>
</body>
</html>
