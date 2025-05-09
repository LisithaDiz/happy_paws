<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>Appointments Dashboard - Happy Paws</title>
    <style>
        /* Main Container Styles */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            color: #333;
        }

        .dashboard-container {
            padding: 2rem;
            background-color: #f8f9fa;
            min-height: calc(100vh - 120px);
        }

        .main-content {
            margin-left: 250px;
            padding: 2rem;
        }

        .main-content h1 {
            color: #2c3e50;
            font-size: 2.5rem;
            margin-bottom: 2rem;
            font-weight: 600;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        /* Appointments Grid */
        .appointments-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 2rem;
            padding: 1rem 0;
        }

        /* Appointment Card */
        .appointment-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            padding: 0;
            transition: all 0.3s ease;
            border: 1px solid rgba(0, 0, 0, 0.05);
            overflow: hidden;
            position: relative;
        }

        .appointment-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
        }

        /* Card Header */
        .appointment-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem;
            background-color: #f8f9fa;
            border-bottom: 2px solid #f0f0f0;
        }

        .appointment-header h3 {
            margin: 0;
            color: #2c3e50;
            font-size: 1.4rem;
            font-weight: 600;
        }

        /* Status Badge */
        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .status-badge.pending {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-badge.confirmed {
            background-color: #d4edda;
            color: #155724;
        }

        .status-badge.cancelled {
            background-color: #f8d7da;
            color: #721c24;
        }

        /* Appointment Details */
        .appointment-details {
            padding: 1.5rem;
            position: relative;
            transition: all 0.3s ease;
        }

        .details-panel {
            display: none;
            opacity: 0;
            transform: translateY(10px);
            transition: all 0.3s ease;
        }

        .details-panel.active {
            display: block;
            opacity: 1;
            transform: translateY(0);
        }

        .details-tabs {
            display: flex;
            border-bottom: 2px solid #f0f0f0;
            margin-bottom: 1.5rem;
        }

        .tab {
            padding: 0.8rem 1.5rem;
            cursor: pointer;
            font-weight: 500;
            color: #666;
            border-bottom: 2px solid transparent;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .tab.active {
            color: #c35b64;
            border-bottom-color: #c35b64;
        }

        .tab:hover {
            color: #c35b64;
        }

        .details-content {
            margin-bottom: 1.5rem;
        }

        .details-content p {
            margin: 0.8rem 0;
            color: #555;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
        }

        .details-content strong {
            color: #2c3e50;
            min-width: 120px;
            display: inline-block;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* Buttons */
        .appointment-actions {
            display: flex;
            justify-content: flex-end;
            padding: 1.5rem;
            background-color: #f8f9fa;
            border-top: 2px solid #f0f0f0;
            gap: 1rem;
        }

        .btn {
            padding: 0.8rem 1.5rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
        }

        .btn-primary {
            background-color: #c35b64;
            color: white;
        }

        .btn-primary:hover {
            background-color: #a84a52;
            transform: translateY(-2px);
        }

        .btn-danger {
            background-color: #dc3545;
            color: white;
        }

        .btn-danger:hover {
            background-color: #c82333;
            transform: translateY(-2px);
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
            transform: translateY(-2px);
        }

        /* No Appointments State */
        .no-appointments {
            text-align: center;
            padding: 3rem;
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            max-width: 600px;
            margin: 2rem auto;
        }

        .no-appointments p {
            color: #666;
            font-size: 1.1rem;
            margin-bottom: 1.5rem;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            backdrop-filter: blur(5px);
        }

        .modal-content {
            background-color: white;
            margin: 15% auto;
            padding: 2rem;
            border-radius: 15px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
            animation: modalFadeIn 0.3s ease;
        }

        .modal-content h3 {
            color: #2c3e50;
            margin-bottom: 1rem;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .modal-content p {
            color: #666;
            margin-bottom: 1.5rem;
        }

        .modal-actions {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            margin-top: 1.5rem;
        }

        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .main-content {
                margin-left: 0;
            }
            
            .appointments-container {
                grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            }
        }

        @media (max-width: 768px) {
            .dashboard-container {
                padding: 1rem;
            }
            
            .main-content {
                padding: 1rem;
            }
            
            .main-content h1 {
                font-size: 2rem;
            }
            
            .appointments-container {
                grid-template-columns: 1fr;
            }
            
            .modal-content {
                margin: 30% auto;
                width: 95%;
                padding: 1.5rem;
            }
            
            .details-content p {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .details-content strong {
                margin-bottom: 0.3rem;
            }
            
            .details-tabs {
                flex-wrap: wrap;
            }
            
            .tab {
                flex: 1 1 50%;
                text-align: center;
                justify-content: center;
            }

            .page-header {
                flex-direction: column;
                align-items: stretch;
                gap: 1rem;
            }

            .page-header .btn {
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation placeholder -->
    <div class="dashboard-container">
        <!-- Sidebar placeholder -->
        <div class="main-content">
            <div class="page-header">
                <h1><i class="fas fa-calendar-alt"></i> My Appointments</h1>
                <a href="<?= ROOT ?>/PetsitterSearch" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Book New Appointment
                </a>
            </div>
            
            <div class="appointments-container">
                <?php if (empty($appointments)): ?>
                    <div class="no-appointments">
                        <p><i class="fas fa-calendar-times"></i> You don't have any appointments yet.</p>
                        <a href="<?= ROOT ?>/PetsitterSearch" class="btn btn-primary">
                            <i class="fas fa-search"></i> Find a Pet Sitter
                        </a>
                    </div>
                <?php else: ?>
                    <?php foreach ($appointments as $index => $appointment): ?>
                        <div class="appointment-card">
                            <div class="appointment-header">
                                <h3><i class="fas fa-paw"></i> <?= htmlspecialchars($appointment->pet_name) ?></h3>
                                <span class="status-badge <?= strtolower($appointment->appointment_status) ?>">
                                    <i class="fas fa-circle"></i> <?= ucfirst($appointment->appointment_status) ?>
                                </span>
                            </div>
                            
                            <div class="appointment-details">
                                <div class="details-tabs">
                                    <div class="tab active" onclick="showTab(this, 'pet-details-<?= $index ?>')">
                                        <i class="fas fa-paw"></i> Pet Details
                                    </div>
                                    <div class="tab" onclick="showTab(this, 'appointment-details-<?= $index ?>')">
                                        <i class="fas fa-calendar-check"></i> Appointment
                                    </div>
                                    <div class="tab" onclick="showTab(this, 'provider-details-<?= $index ?>')">
                                        <i class="fas fa-user-md"></i> Provider
                                    </div>
                                </div>

                                <!-- Pet Details Tab -->
                                <div class="details-panel active" id="pet-details-<?= $index ?>">
                                    <div class="details-content">
                                        <p><strong><i class="fas fa-<?= $appointment->pet_type == 'Dog' ? 'dog' : 'cat' ?>"></i> Pet Type:</strong> <?= htmlspecialchars($appointment->pet_type) ?></p>
                                        <p><strong><i class="fas fa-dna"></i> Breed:</strong> <?= htmlspecialchars($appointment->breed) ?></p>
                                        <p><strong><i class="fas fa-birthday-cake"></i> Age:</strong> <?= htmlspecialchars($appointment->age) ?> years</p>
                                        <p><strong><i class="fas fa-venus-mars"></i> Gender:</strong> <?= htmlspecialchars($appointment->gender) ?></p>
                                    </div>
                                </div>

                                <!-- Appointment Details Tab -->
                                <div class="details-panel" id="appointment-details-<?= $index ?>">
                                    <div class="details-content">
                                        <p><strong><i class="far fa-calendar"></i> Date:</strong> <?= date('F j, Y', strtotime($appointment->day_of_appointment)) ?></p>
                                        <p><strong><i class="far fa-clock"></i> Time:</strong> <?= date('h:i A', strtotime($appointment->day_of_appointment)) ?></p>
                                        <p><strong><i class="fas fa-map-marker-alt"></i> Location:</strong> <?= htmlspecialchars($appointment->street . ', ' . $appointment->city . ', ' . $appointment->district) ?></p>
                                        <p><strong><i class="fas fa-tags"></i> Service:</strong> Pet Sitting</p>
                                    </div>
                                </div>

                                <!-- Provider Details Tab -->
                                <div class="details-panel" id="provider-details-<?= $index ?>">
                                    <div class="details-content">
                                        <p><strong><i class="fas fa-user-md"></i> Provider:</strong> <?= htmlspecialchars($appointment->f_name . ' ' . $appointment->l_name) ?></p>
                                        <p><strong><i class="fas fa-phone"></i> Contact:</strong> <?= htmlspecialchars($appointment->contact_no) ?></p>
                                        <p><strong><i class="fas fa-star"></i> Experience:</strong> <?= htmlspecialchars($appointment->years_exp) ?> years</p>
                                    </div>
                                </div>
                            </div>

                            <div class="appointment-actions">
                                <?php if ($appointment->appointment_status == 'pending'): ?>
                                    <button class="btn btn-secondary" onclick="rescheduleAppointment(<?= $appointment->appointment_id ?>)">
                                        <i class="fas fa-calendar-alt"></i> Reschedule
                                    </button>
                                    <button class="btn btn-danger" onclick="confirmDelete(<?= $appointment->appointment_id ?>)">
                                        <i class="fas fa-times"></i> Cancel
                                    </button>
                                <?php elseif ($appointment->appointment_status == 'cancelled'): ?>
                                    <button class="btn btn-primary" onclick="rebookAppointment(<?= $appointment->appointment_id ?>)">
                                        <i class="fas fa-sync-alt"></i> Rebook
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <h3><i class="fas fa-exclamation-triangle"></i> Cancel Appointment</h3>
            <p>Are you sure you want to cancel this appointment? This action cannot be undone.</p>
            <div class="modal-actions">
                <button class="btn btn-secondary" onclick="closeDeleteModal()">
                    <i class="fas fa-times"></i> No, Keep It
                </button>
                <button class="btn btn-danger" onclick="deleteAppointment()">
                    <i class="fas fa-check"></i> Yes, Cancel It
                </button>
            </div>
        </div>
    </div>

    <script>
        let appointmentToDelete = null;

        function showTab(element, panelId) {
            // Remove active class from all tabs and panels in the same card
            const card = element.closest('.appointment-card');
            card.querySelectorAll('.tab').forEach(tab => tab.classList.remove('active'));
            card.querySelectorAll('.details-panel').forEach(panel => panel.classList.remove('active'));
            
            // Add active class to clicked tab and corresponding panel
            element.classList.add('active');
            document.getElementById(panelId).classList.add('active');
        }

        function confirmDelete(appointmentId) {
            appointmentToDelete = appointmentId;
            document.getElementById('deleteModal').style.display = 'block';
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').style.display = 'none';
            appointmentToDelete = null;
        }

        function deleteAppointment() {
            if (!appointmentToDelete) return;
            
            // Make API call to delete appointment
            fetch('<?= ROOT ?>/PetOwnerAppointments/delete/' + appointmentToDelete, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Remove the appointment card from the UI
                    const card = document.querySelector(`[onclick*="confirmDelete(${appointmentToDelete})"]`).closest('.appointment-card');
                    card.remove();
                    
                    // Show success message
                    alert('Appointment cancelled successfully');
                } else {
                    alert(data.message || 'Failed to cancel appointment');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while cancelling the appointment');
            })
            .finally(() => {
                closeDeleteModal();
            });
        }

        function rescheduleAppointment(appointmentId) {
            // Redirect to reschedule page with appointment ID
            window.location.href = `<?= ROOT ?>/PetOwnerSitterSelection/index?sitter_id=${appointmentId}`;
        }

        function rebookAppointment(appointmentId) {
            // Redirect to booking page with appointment ID
            window.location.href = `<?= ROOT ?>/PetsitterSearch?appointment_id=${appointmentId}`;
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('deleteModal');
            if (event.target == modal) {
                closeDeleteModal();
            }
        }
    </script>
</body>
</html>