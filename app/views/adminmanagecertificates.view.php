<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="<?=ROOT?>/assets/images/happy-paws-logo.png">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/managecertificates.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/styles.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/nav2.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/footer_mini.css">
    <title>Happy Paws - Manage Certificates</title>
</head>
<body>
    <?php include ('components/nav2.php'); ?>
    <div class="dashboard-container">
        <!-- Sidebar for vet functionalities -->
        <?php include ('components/sidebar_admin.php'); ?>
        <!-- Main content area -->
        <div class="main-content">
            <h2>Manage Certificates</h2>
            
            <div class="certificate-types">
                <div class="certificate-section">
                    <h3>Veterinarian Certificates</h3>
                    <table class="certificates-table">
                        <thead>
                            <tr>
                                <th>Certificate ID</th>
                                <th>Vet Name</th>
                                <th>Institution</th>
                                <th>Issue Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            // Placeholder vet certificates
                            $vetCertificates = [
                                ['id' => 'VC001', 'name' => 'Dr. Emily Chen', 'institution' => 'Veterinary College of America', 'date' => '2022-05-15', 'status' => 'Verified'],
                                ['id' => 'VC002', 'name' => 'Dr. Michael Rodriguez', 'institution' => 'National Veterinary Institute', 'date' => '2021-11-20', 'status' => 'Pending'],
                            ];

                            foreach ($vetCertificates as $cert): ?>
                            <tr>
                                <td><?= $cert['id'] ?></td>
                                <td><?= $cert['name'] ?></td>
                                <td><?= $cert['institution'] ?></td>
                                <td><?= $cert['date'] ?></td>
                                <td><?= $cert['status'] ?></td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="#" class="btn-view">View</a>
                                        <a href="#" class="btn-verify">Verify</a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="certificate-section">
                    <h3>Pharmacy Certificates</h3>
                    <table class="certificates-table">
                        <thead>
                            <tr>
                                <th>Certificate ID</th>
                                <th>Pharmacy Name</th>
                                <th>License Number</th>
                                <th>Issue Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            // Placeholder pharmacy certificates
                            $pharmacyCertificates = [
                                ['id' => 'PC001', 'name' => 'Happy Paws Pharmacy', 'license' => 'PH-2022-001', 'date' => '2022-01-10', 'status' => 'Verified'],
                                ['id' => 'PC002', 'name' => 'City Pet Pharmacy', 'license' => 'PH-2022-002', 'date' => '2022-03-15', 'status' => 'Pending'],
                            ];

                            foreach ($pharmacyCertificates as $cert): ?>
                            <tr>
                                <td><?= $cert['id'] ?></td>
                                <td><?= $cert['name'] ?></td>
                                <td><?= $cert['license'] ?></td>
                                <td><?= $cert['date'] ?></td>
                                <td><?= $cert['status'] ?></td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="#" class="btn-view">View</a>
                                        <a href="#" class="btn-verify">Verify</a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="certificate-section">
                    <h3>Pet Care Center Certificates</h3>
                    <table class="certificates-table">
                        <thead>
                            <tr>
                                <th>Certificate ID</th>
                                <th>Center Name</th>
                                <th>Location</th>
                                <th>Issue Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            // Placeholder pet care center certificates
                            $petCareCertificates = [
                                ['id' => 'PCC001', 'name' => 'Paws & Claws Care Center', 'location' => 'New York', 'date' => '2022-06-20', 'status' => 'Verified'],
                                ['id' => 'PCC002', 'name' => 'Happy Tails Pet Resort', 'location' => 'Los Angeles', 'date' => '2022-04-05', 'status' => 'Pending'],
                            ];

                            foreach ($petCareCertificates as $cert): ?>
                            <tr>
                                <td><?= $cert['id'] ?></td>
                                <td><?= $cert['name'] ?></td>
                                <td><?= $cert['location'] ?></td>
                                <td><?= $cert['date'] ?></td>
                                <td><?= $cert['status'] ?></td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="#" class="btn-view">View</a>
                                        <a href="#" class="btn-verify">Verify</a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php include ('components/footer_mini.php'); ?>
</body>
</html>