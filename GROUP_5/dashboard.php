<?php
// Start session and check authentication
session_start();

// Redirect to login if not authenticated
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2>MyApp</h2>
            </div>
            <nav class="sidebar-nav">
                <a href="#" class="nav-link active">
                    <span class="nav-icon">📊</span>
                    Dashboard
                </a>
                <a href="#" class="nav-link">
                    <span class="nav-icon">👥</span>
                    Users
                </a>
                <a href="#" class="nav-link">
                    <span class="nav-icon">⚙️</span>
                    Settings
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            <header class="dashboard-header">
                <h1>Dashboard</h1>
                <div class="user-info">
                    <span class="user-name">Welcome, <strong><?php echo htmlspecialchars($username); ?></strong></span>
                    <button class="logout-btn" id="logoutBtn">Logout</button>
                </div>
            </header>

            <!-- Dashboard Content -->
            <div class="dashboard-content">
                <!-- Stats Cards -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon">👥</div>
                        <div class="stat-info">
                            <h3>Total Users</h3>
                            <p class="stat-number">1,234</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">📈</div>
                        <div class="stat-info">
                            <h3>Revenue</h3>
                            <p class="stat-number">$12,345</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">📝</div>
                        <div class="stat-info">
                            <h3>Orders</h3>
                            <p class="stat-number">567</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">⭐</div>
                        <div class="stat-info">
                            <h3>Rating</h3>
                            <p class="stat-number">4.8</p>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity Section -->
                <div class="content-grid">
                    <div class="content-card">
                        <h3>Recent Activity</h3>
                        <ul class="activity-list">
                            <li>
                                <span class="activity-dot"></span>
                                <div class="activity-content">
                                    <p>New user registered</p>
                                    <span class="activity-time">2 minutes ago</span>
                                </div>
                            </li>
                            <li>
                                <span class="activity-dot"></span>
                                <div class="activity-content">
                                    <p>Order #1234 completed</p>
                                    <span class="activity-time">15 minutes ago</span>
                                </div>
                            </li>
                            <li>
                                <span class="activity-dot"></span>
                                <div class="activity-content">
                                    <p>Payment received</p>
                                    <span class="activity-time">1 hour ago</span>
                                </div>
                            </li>
                            <li>
                                <span class="activity-dot"></span>
                                <div class="activity-content">
                                    <p>New comment on post</p>
                                    <span class="activity-time">3 hours ago</span>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <div class="content-card">
                        <h3>Quick Actions</h3>
                        <div class="quick-actions">
                            <button class="action-btn">Add User</button>
                            <button class="action-btn">Create Order</button>
                            <button class="action-btn">Send Message</button>
                            <button class="action-btn">Generate Report</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="message" class="message"></div>

    <script src="JS/script.js"></script>
</body>
</html>

