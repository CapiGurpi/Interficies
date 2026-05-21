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
    //Comprobar
    public function register()
    {
        if (!empty($_POST['FanName']) && !empty($_POST['FanEmail']) && !empty($_POST['FanPwd']) && !empty($_POST['FanPwdCon']) && !empty($_POST['FanSport'])) {
            $aficionado = new Aficionado($_POST['FanName'], $_POST['FanEmail'], $_POST['FanPwd'], $_POST['FanPwdCon'], $_POST['FanSport']);
            $conn = $this->db->getConnection();

            try {
                $stmt = $conn->prepare("SELECT COUNT(*) AS exist FROM aficionado WHERE Email = :email");
                $stmt->execute([':email' => $aficionado->FanEmail]);
                $res = $stmt->fetch(PDO::FETCH_ASSOC);
                $exist = intval($res['exist']);

                if ($exist === 1) {
                    $_SESSION['register_error'][] = "El correo electronico ya esta registrado.";
                    header('Location: ../Vista/fan-registration.php');
                    exit();
                }

                if ($aficionado->FanPwd !== $aficionado->FanPwdCon) {
                    $_SESSION['register_error'][] = "Las contrasenas no coinciden.";
                    header('Location: ../Vista/fan-registration.php');
                    exit();
                }

                $hashedPassword = password_hash($aficionado->FanPwd, PASSWORD_DEFAULT);
                
                $sql = "INSERT INTO aficionado (Name, Email, Pwd, PwdCon, Sport)
                        VALUES (:name, :email, :pwd, :pwdcon, :sport)";

                $stmt = $conn->prepare($sql);
                $stmt->execute([
                    ':name'   => $aficionado->FanName,
                    ':email'  => $aficionado->FanEmail,
                    ':pwd'    => $hashedPassword,
                    ':pwdcon' => $hashedPassword,
                    ':sport'  => $aficionado->FanSport
                ]);

                header('Location: ../Vista/index.php');
            } catch (PDOException $e) {
                $_SESSION['register_error'][] = "Error en el registro: " . $e->getMessage();
                header('Location: ../Vista/fan-registration.php');
            }
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

            try {
                $stmt = $conn->prepare("SELECT COUNT(*) AS exist FROM promotor WHERE Email = :email");
                $stmt->execute([':email' => $promotor->ProEmail]);
                $res = $stmt->fetch(PDO::FETCH_ASSOC);
                $exist = intval($res['exist']);

                if ($exist === 1) {
                    $_SESSION['register_error'][] = "El correo electronico ya esta registrado.";
                    header('Location: ../Vista/promoter-registration.php');
                    exit();
                }

                if ($promotor->ProPwd !== $promotor->ProPwdCon) {
                    $_SESSION['register_error'][] = "Las contrasenas no coinciden.";
                    header('Location: ../Vista/promoter-registration.php');
                    exit();
                }

                $hashedPassword = password_hash($promotor->ProPwd, PASSWORD_DEFAULT);
                
                $sql = "INSERT INTO promotor (Name, Pwd, Email, Direction, CreditCard)
                        VALUES (:name, :pwd, :email, :direction, :creditcard)";

                $stmt = $conn->prepare($sql);
                $stmt->execute([
                    ':name'       => $promotor->ProName,
                    ':pwd'        => $hashedPassword,
                    ':email'      => $promotor->ProEmail,
                    ':direction'  => $promotor->ProDirection,
                    ':creditcard' => $promotor->ProCreditCard
                ]);

                header('Location: ../Vista/index.php');
            } catch (PDOException $e) {
                $_SESSION['register_error'][] = "Error en el registro del promotor: " . $e->getMessage();
                header('Location: ../Vista/promoter-registration.php');
            }
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
                // Obtener la contraseña encriptada de la base de datos
                if ($userType === 'Promotor') {
                    $sql = "SELECT Pwd FROM promotor WHERE Email = :email";
                } else {
                    $sql = "SELECT Pwd FROM aficionado WHERE Email = :email";
                }
                
                $stmt = $conn->prepare($sql);
                $stmt->execute([':email' => $email]);
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                // Validar contraseña con password_verify
                if ($result && password_verify($password, $result['Pwd'])) {
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
                // Obtener la contraseña encriptada de la base de datos
                $stmt = $conn->prepare("SELECT Pwd FROM promotor WHERE Email = :email");
                $stmt->execute([':email' => $emailp]);
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                // Validar contraseña con password_verify
                if ($result && password_verify($passwordp, $result['Pwd'])) {
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
