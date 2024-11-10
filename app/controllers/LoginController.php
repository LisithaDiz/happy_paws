<?php
require_once 'models/LoginModel.php';
require_once 'db/db_connect.php';

class LoginController {
    private $model;

    public function __construct() {
        $db = connectDatabase();
        $this->model = new LoginModel($db);
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /login');
            exit();
        }

        session_start();

        $username = $_POST['username'];
        $password = $_POST['password'];
        $role = $_POST['selection'];

        $user = $this->model->getUserByRole($username, $role);

        if ($user && $password === $user['password']) {  // Replace with password_verify if hashing is implemented
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $role;
            $_SESSION['table'] = $this->model->getTableByRole($role);

            switch ($role) {
                case 'petOwner':
                    $_SESSION['user_id'] = $user['owner_ID'];
                    header("Location: ../views/dashboards/pet_owner_dash");
                    break;
                case 'veterinary':
                    header("Location: /veterinary_dash");
                    break;
                case 'petSitter':
                    header("Location: /pet_sitter_dash");
                    break;
                case 'petCareCenter':
                    header("Location: /pet_care_center_dash");
                    break;
                case 'pharmacy':
                    header("Location: /pharmacy_dash");
                    break;
                default:
                    header("Location: /login");
                    break;
            }
            exit();
        } else {
            echo "<script>alert('Invalid username or password.');</script>";
        }
    }
}
?>
