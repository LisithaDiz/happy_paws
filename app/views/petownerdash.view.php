<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="<?=ROOT?>/assets/images/happy-paws-logo.png">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/styles.css">
  
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/vetdash.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/nav2.css">
    <!-- <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/sidebar_.css"> -->
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/footer.css">
    <!-- Add Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>Welcome!</title>
    <style>
        /* Notification Bell Container */
        .notification-bell {
            position: relative;
            display: inline-block;
            margin-right: 20px;
            cursor: pointer;
        }

        .notification-bell .fa-bell {
            font-size: 1.5em;
            color: #d8544c;
            transition: transform 0.3s ease;
        }

        .notification-bell:hover .fa-bell {
            transform: rotate(15deg);
        }

        .notification-count {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #d8544c;
            color: white;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 0.8em;
            min-width: 15px;
            text-align: center;
        }

        /* Dropdown Panel */
        .notifications-dropdown {
            display: none;
            position: absolute;
            top: 100%;
            right: 0;
            width: 400px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.15);
            z-index: 1000;
            max-height: 500px;
            overflow-y: auto;
            animation: slideDown 0.3s ease-out;
        }

        .notifications-dropdown.show {
            display: block;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Notification Header */
        .notifications-header {
            padding: 15px 20px;
            border-bottom: 2px solid #f0f0f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            background: white;
            border-radius: 15px 15px 0 0;
            z-index: 1;
        }

        .notifications-header h3 {
            margin: 0;
            color: #333;
            font-size: 1.2em;
        }

        /* Notification Items */
        .notification-item {
            padding: 15px 20px;
            border-bottom: 1px solid #f0f0f0;
            transition: all 0.3s ease;
            cursor: default;
        }

        .notification-item:hover {
            background: #f8f9fa;
        }

        .notification-content {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .notification-message {
            flex-grow: 1;
            margin-right: 15px;
            color: #444;
            font-size: 0.95em;
            line-height: 1.4;
        }

        .notification-time {
            color: #888;
            font-size: 0.85em;
            white-space: nowrap;
        }

        .mark-read-btn {
            background-color: #d8544c;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.85em;
            transition: all 0.3s ease;
            margin-top: 8px;
        }

        .mark-read-btn:hover {
            background-color: #c14841;
        }

        .no-notifications {
            padding: 30px 20px;
            text-align: center;
            color: #888;
        }

        .no-notifications i {
            font-size: 2em;
            margin-bottom: 10px;
            color: #d8544c;
        }

        /* Scrollbar Styling */
        .notifications-dropdown::-webkit-scrollbar {
            width: 8px;
        }

        .notifications-dropdown::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .notifications-dropdown::-webkit-scrollbar-thumb {
            background: #d8544c;
            border-radius: 10px;
        }

        .notifications-dropdown::-webkit-scrollbar-thumb:hover {
            background: #c14841;
        }

        .notification-actions {
            display: flex;
            gap: 10px;
            margin-top: 8px;
        }

        .pay-now-btn {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.85em;
            transition: all 0.3s ease;
        }

        .pay-now-btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <?php include ('components/nav2.php'); ?>

    <div class="dashboard-container">
        <?php include('components/sidebar.php'); ?>
        
        <?php if(isset($_SESSION['success'])): ?>
            <div class="success-message">
                <?= htmlspecialchars($_SESSION['success']) ?>
                <?php unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <!-- Main content area -->
        <div class="main-content">
            <!-- Add notification bell in the header area -->
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h1>Welcome, <?= htmlspecialchars($user_name ?? '[Pet Owner\'s Name]') ?>!</h1>
                <div class="notification-bell" id="notificationBell">
                    <i class="fas fa-bell"></i>
                    <?php if (!empty($notifications)): ?>
                        <span class="notification-count"><?= count($notifications) ?></span>
                    <?php endif; ?>
                    
                    <!-- Notifications Dropdown -->
                    <div class="notifications-dropdown" id="notificationsDropdown">
                        <div class="notifications-header">
                            <h3>Notifications</h3>
                        </div>
                        <?php if (!empty($notifications)): ?>
                            <?php foreach ($notifications as $notification): ?>
                                <div class="notification-item" id="notification-<?= $notification->notification_id ?>">
                                    <div class="notification-content">
                                        <div class="notification-message">
                                            <?= htmlspecialchars($notification->message) ?>
                                            <div class="notification-time">
                                                <i class="far fa-clock"></i>
                                                <?= date('F j, Y, g:i a', strtotime($notification->created_at)) ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="notification-actions">
                                        <button class="mark-read-btn" onclick="markAsRead(<?= $notification->notification_id ?>)">
                                            Mark as Read
                                        </button>
                                        <?php if ($notification->type === 'order_accepted' && isset($notification->reference_id)): ?>
                                            <button class="pay-now-btn" onclick="window.location.href='<?=ROOT?>/payment/process/<?= $notification->reference_id ?>'">
                                                Pay Now
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="no-notifications">
                                <i class="far fa-bell-slash"></i>
                                <p>No new notifications</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <p>We're glad to have you back. Your dashboard provides you with all the tools you need to manage pet records, find veterinary services, and more.</p>

            <!-- Dashboard Overview Section -->
            <section class="dashboard-overview">
                <h2>Overview</h2>
                <div class="overview-cards">
                    <div class="card">
                        <h3>Find Vet</h3>
                        <p>Search for veterinary services near you.</p>
                        <a href="<?=ROOT?>/findvet" class="btn-dashboard">Find Vet</a>
                    </div>
                    <div class="card">
                        <h3>Find Pet Guardians</h3>
                        <p>Connect with pet guardians in your area.</p>
                        <a href="<?=ROOT?>/findguardians" class="btn-dashboard">Find Guardians</a>
                    </div>
                    <div class="card">
                        <h3>Pharmacies</h3>
                        <p>Locate pharmacies for pet medications.</p>
                        <a href="<?=ROOT?>/pharmacies" class="btn-dashboard">Find Pharmacies</a>
                    </div>
                </div>
            </section>

            <!-- Contact Section -->
            <section class="contact">
                <h2>Need Help?</h2>
                <p>If you have any questions or need assistance, feel free to contact our support team.</p>
                <a href="<?=ROOT?>/contact" class="btn-dashboard">Contact Support</a>
            </section>
        </div>
    </div>
    
    
    <!-- <script src="<?=ROOT?>/assets/js/script.js"></script> -->

    <script>
        // Define ROOT constant for JavaScript
        const ROOT = '<?=ROOT?>';

        // Toggle notifications dropdown
        document.getElementById('notificationBell').addEventListener('click', function(e) {
            e.stopPropagation();
            const dropdown = document.getElementById('notificationsDropdown');
            dropdown.classList.toggle('show');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            const dropdown = document.getElementById('notificationsDropdown');
            if (!e.target.closest('.notification-bell') && dropdown.classList.contains('show')) {
                dropdown.classList.remove('show');
            }
        });

        function updateNotificationCount() {
            const notificationsDropdown = document.getElementById('notificationsDropdown');
            const remainingNotifications = notificationsDropdown.querySelectorAll('.notification-item');
            const count = remainingNotifications.length;
            
            const countElement = document.querySelector('.notification-count');
            if (countElement) {
                if (count === 0) {
                    countElement.style.display = 'none';
                    // Update dropdown content to show no notifications message
                    notificationsDropdown.innerHTML = `
                        <div class="notifications-header">
                            <h3>Notifications</h3>
                        </div>
                        <div class="no-notifications">
                            <i class="far fa-bell-slash"></i>
                            <p>No new notifications</p>
                        </div>
                    `;
                } else {
                    countElement.textContent = count;
                }
            }
        }

        function markAsRead(notificationId) {
            const button = document.querySelector(`#notification-${notificationId} .mark-read-btn`);
            if (!button) return;

            const originalText = button.textContent;
            button.textContent = 'Marking...';
            button.disabled = true;

            fetch(`${ROOT}/notifications/markAsRead/${notificationId}`, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                credentials: 'same-origin'
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    const notificationElement = document.getElementById(`notification-${notificationId}`);
                    if (notificationElement) {
                        // Add fade-out animation
                        notificationElement.style.opacity = '0';
                        notificationElement.style.transform = 'translateX(20px)';
                        notificationElement.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                        
                        setTimeout(() => {
                            notificationElement.remove();
                            updateNotificationCount();
                            
                            // Check if there are no more notifications
                            const remainingNotifications = document.querySelectorAll('.notification-item');
                            if (remainingNotifications.length === 0) {
                                const dropdown = document.getElementById('notificationsDropdown');
                                dropdown.innerHTML = `
                                    <div class="notifications-header">
                                        <h3>Notifications</h3>
                                    </div>
                                    <div class="no-notifications">
                                        <i class="far fa-bell-slash"></i>
                                        <p>No new notifications</p>
                                    </div>
                                `;
                            }
                        }, 300);
                    }
                } else {
                    throw new Error(data.message || 'Failed to mark notification as read');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                button.textContent = originalText;
                button.disabled = false;
                alert('Failed to mark notification as read. Please try again.');
            });
        }
    </script>
</body>
</html>
