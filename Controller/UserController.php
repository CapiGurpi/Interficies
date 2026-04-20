
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

    public function login()
    {
        require_once '../Model/NextLvlBase.php';

        if (!empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['userType'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $userType = $_POST['userType'];

            $db = new Database();
            $conn = $db->getConnection();


            $procedure = ($userType === 'Promotor') ? 'sp_loginp' : 'sp_login';

            $conn->query("CALL $procedure('$email', '$password', @result)");
            while ($conn->more_results() && $conn->next_result()) {
                $conn->store_result();
            }

            $res = $conn->query("SELECT @result AS exist");
            $row = $res->fetch_assoc();
            $exist = intval($row['exist']);

            if ($exist === 1) {

                $_SESSION['user'] = $email;
                $_SESSION['user_type'] = $userType;

                if ($userType === 'Promotor') {
                    $userResult = $conn->query("SELECT Name AS nombre, Email AS email, Pwd AS pwd, Pwd AS pwdcon, Direction AS direccion, CreditCard AS tarjeta, 'Promotor' AS tipo FROM promotor WHERE Email = '$email'");
                } else {
                    $userResult = $conn->query("SELECT Name AS nombre, Email AS email, Pwd AS pwd, PwdCon AS pwdcon, Sport AS deporte, 'Aficionado' AS tipo FROM aficionado WHERE Email = '$email'");
                }

                if ($userResult && $userResult->num_rows === 1) {
                    $_SESSION['user_info'] = $userResult->fetch_assoc();
                }

                header('Location: ../Vista/index.php');
                exit(); 
            } else {
                $_SESSION['login_error'][] = "Usuario o contraseña incorrectos";
                header("Location: ../Vista/fan-login.php");
                exit();
            }
        } else {
            $_SESSION['login_error'][] = "No se han rellenado todos los datos.";
            header("Location: ../Vista/fan-login.php");
            exit();
        }
    }

    public function loginp()
    {

        require_once '../Model/NextLvlBase.php';

        if (!empty($_POST['emailp']) && !empty($_POST['passwordp'])) {
            $emailp = $_POST['emailp'];
            $passwordp = $_POST['passwordp'];

            $db = new Database();
            $conn = $db->getConnection();

            $conn->query("CALL sp_loginp('$emailp', '$passwordp', @result)");
            while ($conn->more_results() && $conn->next_result()) {
                $conn->store_result();
            }
            $result = $conn->query("SELECT @result AS exist");
            $row = $result->fetch_assoc();
            $exist = intval($row["exist"]); // 1 o 0

            if ($exist === 1) {
                $_SESSION['user'] = $emailp;
                $_SESSION['user_type'] = 'Promotor';

                $userResult = $conn->query("SELECT Name AS nombre, Email AS email, Pwd AS pwd, Pwd AS pwdcon, Direction AS direccion, CreditCard AS tarjeta, 'Promotor' AS tipo FROM promotor WHERE Email = '$emailp'");
                if ($userResult && $userResult->num_rows === 1) {
                    $_SESSION['user_info'] = $userResult->fetch_assoc();
                }

                header('Location: ../Vista/index.php');
                exit();
            } else {
                $_SESSION['login_error'][] = "Usuario o contraseña incorrectos";
                header("Location: ../Vista/fan-login.php");
                exit();
            }
        } else {
            $_SESSION['login_error'][] = "No se han rellenado todos los datos.";
            header("Location: ../Vista/fan-login.php");
            exit();
        }
        exit();
    }
    public function logout()
    {
        session_start();
        unset($_SESSION['user'], $_SESSION['user_type'], $_SESSION['user_info']);
        session_destroy();
        header("Location: ../Vista/index.php");
        exit();
    }

    public function update() {}

    public function delete() {}
}
?>