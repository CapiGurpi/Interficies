<?php
session_start();

require_once '../Model/NextLvlBase.php';
require_once '../Model/Aficionado.php';
require_once '../Model/Promotor.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userController = new UserController();

    if (isset($_POST['register'])) { $userController->register(); }
    if (isset($_POST['registerp'])) { $userController->registerp(); }
    if (isset($_POST['login'])) { $userController->login(); }
    if (isset($_POST['loginp'])) { $userController->loginp(); }
    if (isset($_POST['update'])) { $userController->update(); }
    if (isset($_POST['delete'])) { $userController->delete(); }
    if (isset($_POST['logout'])) { $userController->logout(); }
}

class UserController
{
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function register()
    {
        if (!empty($_POST['FanName']) && !empty($_POST['FanEmail']) && !empty($_POST['FanPwd']) && !empty($_POST['FanPwdCon']) && !empty($_POST['FanSport'])) {
            $aficionado = new Aficionado($_POST['FanName'], $_POST['FanEmail'], $_POST['FanPwd'], $_POST['FanPwdCon'], $_POST['FanSport']);
            $conn = $this->db->getConnection();
           
            $aficionado->register($_POST['FanPwdCon'], $conn);
        } else {
            $_SESSION['register_error'][] = "No se han rellenado todos los datos.";
            header("Location: ../Vista/fan-registration.php");
        }
        exit();
    }

    public function registerp()
    {
        if (!empty($_POST['ProName']) && !empty($_POST['ProEmail']) && !empty($_POST['ProDirection']) && !empty($_POST['ProPwd']) && !empty($_POST['ProPwdCon']) && !empty($_POST['ProCreditCard'])) {
            $promotor = new Promotor($_POST['ProName'], $_POST['ProPwd'], $_POST['ProPwdCon'], $_POST['ProEmail'], $_POST['ProDirection'], $_POST['ProCreditCard']);
            $conn = $this->db->getConnection();
            $promotor->registerp($_POST['ProPwdCon'], $conn);
        } else {
            $_SESSION['register_error'][] = "No se han rellenado todos los datos.";
            header("Location: ../Vista/promoter-registration.php");
        }
        exit();
    }

    public function login()
    {
        if (!empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['userType'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $userType = $_POST['userType'];

            $conn = $this->db->getConnection();

            try {
                $procedure = ($userType === 'Promotor') ? 'sp_loginp' : 'sp_login';
                
                
                $stmt = $conn->prepare("CALL $procedure(:email, :pass, @result)");
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':pass', $password);
                $stmt->execute();

                $res = $conn->query("SELECT @result AS exist")->fetch();
                $exist = intval($res['exist']);

                if ($exist === 1) {
                    $_SESSION['user'] = $email;
                    $_SESSION['user_type'] = $userType;

                    if ($userType === 'Promotor') {
                        $sql = "SELECT Name AS nombre, Email AS email, Pwd AS pwd, Pwd AS pwdcon, Direction AS direccion, CreditCard AS tarjeta, 'Promotor' AS tipo FROM promotor WHERE Email = :email";
                    } else {
                        $sql = "SELECT Name AS nombre, Email AS email, Pwd AS pwd, PwdCon AS pwdcon, Sport AS deporte, 'Aficionado' AS tipo FROM aficionado WHERE Email = :email";
                    }

                    $stmtUser = $conn->prepare($sql);
                    $stmtUser->execute([':email' => $email]);
                    $userInfo = $stmtUser->fetch(PDO::FETCH_ASSOC);

                    if ($userInfo) {
                        $_SESSION['user_info'] = $userInfo;
                    }

                    header('Location: ../Vista/index.php');
                    exit(); 
                } else {
                    $_SESSION['login_error'][] = "Usuario o contraseña incorrectos";
                    header("Location: ../Vista/fan-login.php");
                    exit();
                }
            } catch (PDOException $e) {
                die("Error en login: " . $e->getMessage());
            }
        } else {
            $_SESSION['login_error'][] = "No se han rellenado todos los datos.";
            header("Location: ../Vista/fan-login.php");
            exit();
        }
    }

    public function loginp()
    {
        if (!empty($_POST['emailp']) && !empty($_POST['passwordp'])) {
            $emailp = $_POST['emailp'];
            $passwordp = $_POST['passwordp'];

            $conn = $this->db->getConnection();

            try {
                $stmt = $conn->prepare("CALL sp_loginp(:email, :pass, @result)");
                $stmt->execute([':email' => $emailp, ':pass' => $passwordp]);

                $res = $conn->query("SELECT @result AS exist")->fetch();
                $exist = intval($res['exist']);

                if ($exist === 1) {
                    $_SESSION['user'] = $emailp;
                    $_SESSION['user_type'] = 'Promotor';

                    $stmtUser = $conn->prepare("SELECT Name AS nombre, Email AS email, Pwd AS pwd, Pwd AS pwdcon, Direction AS direccion, CreditCard AS tarjeta, 'Promotor' AS tipo FROM promotor WHERE Email = :email");
                    $stmtUser->execute([':email' => $emailp]);
                    $userInfo = $stmtUser->fetch(PDO::FETCH_ASSOC);

                    if ($userInfo) {
                        $_SESSION['user_info'] = $userInfo;
                    }

                    header('Location: ../Vista/index.php');
                    exit();
                } else {
                    $_SESSION['login_error'][] = "Usuario o contraseña incorrectos";
                    header("Location: ../Vista/fan-login.php");
                    exit();
                }
            } catch (PDOException $e) {
                die("Error: " . $e->getMessage());
            }
        } else {
            $_SESSION['login_error'][] = "No se han rellenado todos los datos.";
            header("Location: ../Vista/fan-login.php");
            exit();
        }
    }

    public function logout()
    {
        
        unset($_SESSION);
        session_destroy();
        header("Location: ../Vista/index.php");
        exit();
    }

    public function update() {}
    public function delete()
    {
        if (!isset($_SESSION['user']) || !isset($_SESSION['user_type'])) {
            header("Location: ../Vista/fan-login.php");
            exit();
        }

        $email = $_SESSION['user'];
        $tipo = $_SESSION['user_type'];
        $conn = $this->db->getConnection();

        if ($tipo === 'Aficionado') {
            $stmt = $conn->prepare("SELECT Id FROM aficionado WHERE Email = :email");
            $stmt->execute([':email' => $email]);
            $id = $stmt->fetchColumn();

            if ($id) {
                $stmt = $conn->prepare("DELETE FROM entrada WHERE AficionadoId = :id");
                $stmt->execute([':id' => $id]);

                $stmt = $conn->prepare("DELETE FROM compra WHERE AficionadoId = :id");
                $stmt->execute([':id' => $id]);

                $stmt = $conn->prepare("DELETE FROM aficionado WHERE Id = :id");
                $stmt->execute([':id' => $id]);
            }
        } elseif ($tipo === 'Promotor') {
            $stmt = $conn->prepare("DELETE FROM promotor WHERE Email = :email");
            $stmt->execute([':email' => $email]);
        }

        unset($_SESSION);
        session_destroy();

        header("Location: ../Vista/index.php");
        exit();
    }
}
?>
