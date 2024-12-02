<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="<?=ROOT?>/assets/images/happy-paws-logo.png">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/userrequests.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/nav2.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/footer.css">
    <title>User Requests - Admin Dashboard</title>
</head>
<body>
    <?php include ('components/nav2.php'); ?>
    <div class="dashboard-container">
        <!-- Sidebar for vet functionalities -->
        <?php include ('components/sidebar1.php'); ?>
        <!-- Main content area -->
        <div class="main-content">
            <div class="user-requests-management">
                <h2>User Requests Management</h2>

                <!-- Medicine Addition Requests -->
                <div class="request-section">
                    <h3>Medicine Addition Requests</h3>
                    <table class="requests-table">
                        <thead>
                            <tr>
                                <th>Request ID</th>
                                <th>Submitted By</th>
                                <th>Medicine Name</th>
                                <th>Description</th>
                                <th>Date Submitted</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>MAR001</td>
                                <td>Dr. Sathya Rodrigue</td>
                                <td>Feline Allergy Relief</td>
                                <td>New medicine for cat allergies</td>
                                <td>2024-02-15</td>
                                <td>Pending</td>
                                <td class="action-buttons">
                                    <a href="<?=ROOT?>/ReviewMedicineRequest/MAR001" class="btn-view">Review</a><br/><br/>
                                    <a href="<?=ROOT?>/ApproveMedicineRequest/MAR001" class="btn-approve">Approve</a><br/><br/>
                                    <a href="<?=ROOT?>/RejectMedicineRequest/MAR001" class="btn-reject">Reject</a>
                                </td>
                            </tr>
                            <tr>
                                <td>MAR002</td>
                                <td>Happy Paws Pharmacy</td>
                                <td>Canine Joint Support Supplement</td>
                                <td>New joint health supplement</td>
                                <td>2024-02-20</td>
                                <td>Pending</td>
                                <td class="action-buttons">
                                    <a href="<?=ROOT?>/ReviewMedicineRequest/MAR002" class="btn-view">Review</a><br/><br/>
                                    <a href="<?=ROOT?>/ApproveMedicineRequest/MAR002" class="btn-approve">Approve</a><br/><br/>
                                    <a href="<?=ROOT?>/RejectMedicineRequest/MAR002" class="btn-reject">Reject</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Contact Us Submissions -->
                <div class="request-section">
                    <h3>Contact Us Submissions</h3>
                    <table class="requests-table">
                        <thead>
                            <tr>
                                <th>Request ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Subject</th>
                                <th>Date Submitted</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>CU001</td>
                                <td>Saman Perera</td>
                                <td>saman.perera@example.com</td>
                                <td>Veterinary Service Inquiry</td>
                                <td>2024-02-17</td>
                                <td>New</td>
                                <td class="action-buttons">
                                    <a href="<?=ROOT?>/ViewContactRequest/CU001" class="btn-view">View</a><br/><br/>
                                    <a href="<?=ROOT?>/RespondContactRequest/CU001" class="btn-respond">Respond</a><br/><br/>
                                    <a href="<?=ROOT?>/MarkContactRequestResolved/CU001" class="btn-resolve">Mark Resolved</a>
                                </td>
                            </tr>
                            <tr>
                                <td>CU002</td>
                                <td>Mahinda Kumara</td>
                                <td>Mahinda.Kumara@example.com</td>
                                <td>Feedback on Pet Sitting Service</td>
                                <td>2024-02-22</td>
                                <td>In Progress</td>
                                <td class="action-buttons">
                                    <a href="<?=ROOT?>/ViewContactRequest/CU002" class="btn-view">View</a><br/><br/>
                                    <a href="<?=ROOT?>/RespondContactRequest/CU002" class="btn-respond">Respond</a><br/><br/>
                                    <a href="<?=ROOT?>/MarkContactRequestResolved/CU002" class="btn-resolve">Mark Resolved</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Pet Service Registration Requests -->
                <!-- <div class="request-section">
                    <h3>Pet Service Registration Requests</h3>
                    <table class="requests-table">
                        <thead>
                            <tr>
                                <th>Request ID</th>
                                <th>Business Name</th>
                                <th>Service Type</th>
                                <th>Contact Email</th>
                                <th>Date Submitted</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>PSR001</td>
                                <td>Pawsome Pet Care</td>
                                <td>Pet Sitting</td>
                                <td>info@pawsomepetcare.com</td>
                                <td>2024-02-18</td>
                                <td>Pending</td>
                                <td class="action-buttons">
                                    <a href="<?=ROOT?>/ReviewServiceRequest/PSR001" class="btn-view">Review</a>
                                    <a href="<?=ROOT?>/ApproveServiceRequest/PSR001" class="btn-approve">Approve</a>
                                    <a href="<?=ROOT?>/RejectServiceRequest/PSR001" class="btn-reject">Reject</a>
                                </td>
                            </tr>
                            <tr>
                                <td>PSR002</td>
                                <td>Whiskers & Walks</td>
                                <td>Pet Grooming</td>
                                <td>contact@whiskersandwalks.com</td>
                                <td>2024-02-23</td>
                                <td>Pending</td>
                                <td class="action-buttons">
                                    <a href="<?=ROOT?>/ReviewServiceRequest/PSR002" class="btn-view">Review</a>
                                    <a href="<?=ROOT?>/ApproveServiceRequest/PSR002" class="btn-approve">Approve</a>
                                    <a href="<?=ROOT?>/RejectServiceRequest/PSR002" class="btn-reject">Reject</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div> -->
            </div>
        </div>
    </div>

   
</body>
</html>