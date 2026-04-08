
<?php
session_start();
// controller/UserController.php
require_once '../Model/NextLvlBase.php';
require_once '../Model/Aficionado.php';
require_once '../Model/Promotor.php';

// Scanner sc =  new Scanner();
// sc.nextLine();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $userController = new UserController();

    if (isset($_POST['register'])) {
        $userController->register();
    }

    if (isset($_POST['registerp'])) {
        $userController->registerp();
    }

    if (isset($_POST['login'])) {
        $userController->login();
    }

    if (isset($_POST['loginp'])) {
        $userController->loginp();
    }
    
    if (isset($_POST['update'])) {
        $userController->update();
    }

    if (isset($_POST['delete'])) {
        $userController->delete();
    }

    if (isset($_POST['logout'])) {
        $userController->logout();
    }
}

class UserController
{

    public function register()
    {
        require_once '../Model/NextLvlBase.php';
        if (!empty($_POST['FanName']) && !empty($_POST['FanEmail']) && !empty($_POST['FanPwd']) && !empty($_POST['FanPwdCon']) && !empty($_POST['FanSport'])) {
            $FanName = $_POST['FanName'];
            $FanEmail = $_POST['FanEmail'];
            $FanPwd = $_POST['FanPwd'];
            $FanPwdCon = $_POST['FanPwdCon'];
            $FanSport = $_POST['FanSport'];

            $aficionado = new Aficionado($FanName, $FanEmail, $FanPwd, $FanPwdCon, $FanSport);

            $db = new Database();
            $conn = $db->getConnection();

            $aficionado->register($FanPwdCon, $conn);
        } else {
        }
        exit();
    }
    public function registerp()
    {
        require_once '../Model/NextLvlBase.php';

        if (!empty($_POST['ProName']) && !empty($_POST['ProEmail']) && !empty($_POST['ProDirection']) && !empty($_POST['ProPwd']) && !empty($_POST['ProPwdCon']) && !empty($_POST['ProCreditCard'])) {
            $ProName = $_POST['ProName'];
            $ProPwd = $_POST['ProPwd'];
            $ProPwdCon = $_POST['ProPwdCon'];
            $ProEmail = $_POST['ProEmail'];
            $ProDirection = $_POST['ProDirection'];
            $ProCreditCard = $_POST['ProCreditCard'];

            $promotor = new Promotor($ProName, $ProPwd, $ProPwdCon, $ProEmail, $ProDirection, $ProCreditCard);

            $db = new Database();
            $conn = $db->getConnection();

            $promotor->registerp($ProPwdCon, $conn);
        } else {
        }
        exit();
    }

    public function login() {
        
        require_once '../Model/NextLvlBase.php';

        if (!empty($_POST['email']) && !empty($_POST['password'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $db = new Database();
            $conn = $db->getConnection();

            $conn->query("CALL sp_login('$email', '$password', @result)");
            $result = $conn->query("SELECT @result AS exist");
            $row = $result->fetch_assoc();
            $exist = intval($row["exist"]); // 1 o 0

            if ($exist === 1) {
                header('Location: ../view/index.php');
                exit();
            } else {
                // $error = "Correo electrónico o contraseña incorrectos. Inténtalo de nuevo.";
                // header("Location: index.php?error=" . urlencode($error));
                // exit();
            }
        } else {
            // $error = "Por favor, completa todos los campos.";
            // header("Location: register-lector.php?error=" . urlencode($error));
            //    exit;
        }
        exit();
    }


    public function loginp(){

    require_once '../Model/NextLvlBase.php';

        if (!empty($_POST['emailp']) && !empty($_POST['passwordp'])) {
            $emailp = $_POST['emailp'];
            $passwordp = $_POST['passwordp'];

            $db = new Database();
            $conn = $db->getConnection();

            $conn->query("CALL sp_loginp('$emailp', '$passwordp', @result)");
            $result = $conn->query("SELECT @result AS exist");
            $row = $result->fetch_assoc();
            $exist = intval($row["exist"]); // 1 o 0

            if ($exist === 1) {
                header('Location: ../view/index.php');
                exit();
            } else {
                // $error = "Correo electrónico o contraseña incorrectos. Inténtalo de nuevo.";
                // header("Location: index.php?error=" . urlencode($error));
                // exit();
            }
        } else {
            // $error = "Por favor, completa todos los campos.";
            // header("Location: register-lector.php?error=" . urlencode($error));
            //    exit;
        }
        exit();
    }
    public function logout() {}

    public function update() {}

    public function delete() {}
}
?>