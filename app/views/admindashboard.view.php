<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="<?=ROOT?>/assets/images/happy-paws-logo.png">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/nav2.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/styles.css">
    
    <title>Admin Dashboard - Happy Paws</title>
    <style>
        /* Global Styles */
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #ffffff;
            color: #333;
        }

        /* Dashboard Container */
        .dashboard-container {
            margin-top: 100px;
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background-color: #fae3e3;
            padding: 20px;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            overflow-y: auto;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar ul li {
            margin: 10px 0;
        }

        .sidebar ul li a {
            display: block;
            width: 100%;
            padding: 12px 0;
            text-align: center;
            background-color: #f8d7da;
            color: #333;
            text-decoration: none;
            font-weight: bold;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease-in-out;
        }

        .sidebar ul li a:hover {
            background-color: #f5c6cb;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.2);
        }

        /* Main Content */
        .main-content{
            max-width: 1000px;
            width: 1000px;
            margin: 20px auto;
            padding: 20px;
            backdrop-filter: blur(20px);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            animation: fadeIn 2s ease-in-out;
            background-color: rgba(255, 255, 255, 0.3);
            max-height: 1000px; /* Set a maximum height */
            overflow-y: auto; /* Enable vertical scrolling */
            overflow-x: hidden; /* Hide horizontal scrolling */
            margin-right: 40px;
            margin-left: 150px;
        }

        .dashboard-header h1 {
            color: #d8544c;
            margin-bottom: 30px;
            border-bottom: 3px solid #f5c6cb;
            padding-bottom: 10px;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 20px;
            margin-bottom: 40px;
        }

        .stat-card {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: scale(1.05);
        }

        .stat-icon {
            font-size: 3em;
            margin-bottom: 15px;
        }

        .stat-content h3 {
            color: #d8544c;
            margin-bottom: 10px;
        }

        .stat-number {
            font-size: 2em;
            font-weight: bold;
            color: #f5c6cb;
            margin-bottom: 15px;
        }

        .stat-link {
            display: inline-block;
            background-color: #f5c6cb;
            color: white;
            padding: 8px 15px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 0.9em;
            color:black;
            
        }

        .stat-link:hover {
            background-color: #fae3e3;
            color:black;
        }

        /* Quick Actions */
        .dashboard-quick-actions {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }

        .quick-actions-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }

        .quick-action-card {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
            transition: transform 0.3s ease;
        }

        .quick-action-card:hover {
            background-color: white;
            transform: translateY(-5px);
        }

        .quick-action-icon {
            font-size: 3em;
            margin-bottom: 15px;
            color: #d8544c;
        }

        .quick-action-card h3 {
            color: #333;
            margin-bottom: 10px;
        }

        .quick-action-card p {
            color: #666;
            margin-bottom: 15px;
        }

        .quick-action-link {
            display: inline-block;
            background-color: #f5c6cb;
            color: white;
            padding: 8px 15px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 0.9em;
            color:black;
        }

        .quick-action-link:hover {
            background-color: #fae3e3;
            color:black;
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            .stats-grid,
            .quick-actions-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                position: static;
                height: auto;
            }

            .main-content {
                margin-left: 0;
            }

            .stats-grid,
            .quick-actions-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 480px) {
            .stats-grid,
            .quick-actions-grid {
                grid-template-columns: 1fr;
            }
        }

        ::-webkit-scrollbar {
    width: 10px; /* Width of the scrollbar */
}

        ::-webkit-scrollbar-track {
            background-color: #f5c6cb; /* Track color */
            border-radius: 10px; /* Rounded corners */
        }

        ::-webkit-scrollbar-thumb {
            background-color: #fae3e3; /* Thumb color */
            border-radius: 10px; /* Rounded corners */
        }

        ::-webkit-scrollbar-thumb:hover {
            background-color: #f5c6cb; /* Darker color on hover */
        }
    </style>
</head>
<body>
    <?php include ('components/nav2.php'); ?>
    <div class="dashboard-container">
        <?php include ('components/sidebar1.php'); ?>
        <div class="main-content">
            <div class="dashboard-header">
                <h1>Admin Dashboard</h1>
            </div>

            <div class="dashboard-stats">
                <div class="stats-grid">
                    <div class="stat-card pet-owners">
                        <div class="stat-icon">👥</div>
                        <div class="stat-content">
                            <h3>Pet Owners</h3>
                            <p class="stat-number">250</p>
                            <a href="#" class="stat-link">Manage Pet Owners</a>
                        </div>
                    </div>

                    <div class="stat-card vets">
                        <div class="stat-icon">👩‍⚕️</div>
                        <div class="stat-content">
                            <h3>Veterinarians</h3>
                            <p class="stat-number">45</p>
                            <a href="#" class="stat-link">Manage Vets</a>
                        </div>
                    </div>

                    <div class="stat-card pet-sitters">
                        <div class="stat-icon">🐕</div>
                        <div class="stat-content">
                            <h3>Pet Sitters</h3>
                            <p class="stat-number">75</p>
                            <a href="#" class="stat-link">Manage Pet Sitters</a>
                        </div>
                    </div>

                    <div class="stat-card pet-care-centers">
                        <div class="stat-icon">🏥</div>
                        <div class="stat-content">
                            <h3>Pet Care Centers</h3>
                            <p class="stat-number">20</p>
                            <a href="#" class="stat-link">Manage Centers</a>
                        </div>
                    </div>

                    <div class="stat-card pharmacies">
                        <div class="stat-icon">💊</div>
                        <div class="stat-content">
                            <h3>Pharmacies</h3>
                            <p class="stat-number">15</p>
                            <a href="#" class="stat-link">Manage Pharmacies</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="dashboard-quick-actions">
                <h2>Quick Actions</h2>
                <div class="quick-actions-grid">
                    <div class="quick-action-card">
                        <div class="quick-action-icon">📋</div>
                        <h3>Manage Users</h3>
                        <p>View and manage all user accounts</p>
                        <a href="#" class="quick-action-link">Go to Manage Users</a>
                    </div>

                    <div class="quick-action-card">
                        <div class="quick-action-icon">💊</div>
                        <h3>Manage Medicines</h3>
                        <p>Add, edit, or remove medicines</p>
                        <a href="#" class="quick-action-link">Go to Medicines</a>
                    </div>

                    <div class="quick-action-card">
                        <div class="quick-action-icon">📝</div>
                        <h3>User Requests</h3>
                        <p>Review and process user requests</p>
                        <a href="#" class="quick-action-link">View Requests</a>
                    </div>

                    <div class="quick-action-card">
                        <div class="quick-action-icon">📄</div>
                        <h3>Manage Certificates</h3>
                        <p>Handle professional certificates</p>
                        <a href="#" class="quick-action-link">Manage Certificates</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>