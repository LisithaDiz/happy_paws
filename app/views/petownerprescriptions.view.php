<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="<?=ROOT?>/assets/images/happy-paws-logo.png">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/styles.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/petownerprofile.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/nav.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/footer.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components/sidebar.css">
    <style>
        .prescription-container {
            margin: 20px 0;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #f9f9f9;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .prescription-title {
            font-size: 1.5rem;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .prescription-table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }

        .prescription-table th,
        .prescription-table td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }

        .prescription-table th {
            background-color: #fae3e3;
            color: #721c24;
        }

        .prescription-table td {
            background-color: #fff;
            color: #333;
        }

        .profile-details .detail-line {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            font-size: 1rem;
        }

        .detail-label {
            font-weight: bold;
            color: #333;
        }

        .colon {
            margin: 0 5px;
        }
    </style>
</head>
<body>
    <?php include('components/nav.php'); ?>
    <div class="dashboard-container">
        <?php
        include 'components/renderSidebar.php';
        echo renderSidebar(ROOT, $petowner);
        ?>

        <div class="main-content">
            <div class="profile-picture">
                <img src="<?=ROOT?>/assets/images/default-profile-picture.webp" alt="Profile Picture">
            </div>

            <div class="profile-details">
                <h1>Pet's Prescription</h1>
                <br/>

                <div class="detail-line">
                    <div class="detail-label">Username</div>
                    <div class="colon">:</div>
                    <div class="detail-value">johndoe</div> 
                </div>

                <!-- Prescription Section -->
                <div class="prescription-container">
                    <div class="prescription-title">Prescription Details</div>
                    <table class="prescription-table">
                        <thead>
                            <tr>
                                <th>Medicine</th>
                                <th>Dosage</th>
                                <th>Frequency</th>
                                <th>Duration</th>
                                <th>Instructions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Amoxicillin</td>
                                <td>250 mg</td>
                                <td>Twice a day</td>
                                <td>7 days</td>
                                <td>Give with food</td>
                            </tr>
                            <tr>
                                <td>Carprofen</td>
                                <td>50 mg</td>
                                <td>Once a day</td>
                                <td>5 days</td>
                                <td>Give in the morning</td>
                            </tr>
                            <!-- Add more prescription rows as needed -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <?php include('components/footer.php'); ?>

    <script src="<?=ROOT?>/assets/js/script.js"></script>
</body>
</html>
