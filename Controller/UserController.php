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
    if (isset($_POST['change_password'])) { $userController->changePassword(); }
    if (isset($_POST['delete'])) { $userController->delete(); }
    if (isset($_POST['logout'])) { $userController->logout(); }
}

class UserController
{
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    private function isPasswordValid(string $password, string $storedPassword): bool
    {
        if (password_get_info($storedPassword)['algo'] !== 0) {
            return password_verify($password, $storedPassword);
        }

        return hash_equals($storedPassword, $password);
    }

    private function needsPasswordMigration(string $storedPassword): bool
    {
        return password_get_info($storedPassword)['algo'] === 0;
    }

    private function updatePasswordHash(PDO $conn, string $table, string $email, string $password): void
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        if ($table === 'aficionado') {
            $stmt = $conn->prepare("UPDATE aficionado SET Pwd = :pwd, PwdCon = :pwdcon WHERE Email = :email");
            $stmt->execute([
                ':pwd' => $hashedPassword,
                ':pwdcon' => $hashedPassword,
                ':email' => $email
            ]);
            return;
        }

        $stmt = $conn->prepare("UPDATE promotor SET Pwd = :pwd WHERE Email = :email");
        $stmt->execute([
            ':pwd' => $hashedPassword,
            ':email' => $email
        ]);
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
                    $table = 'promotor';
                } else {
                    $sql = "SELECT Pwd FROM aficionado WHERE Email = :email";
                    $table = 'aficionado';
                }
                
                $stmt = $conn->prepare($sql);
                $stmt->execute([':email' => $email]);
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                // Validar hashes actuales y permitir la primera entrada de cuentas antiguas.
                if ($result && $this->isPasswordValid($password, $result['Pwd'])) {
                    if ($this->needsPasswordMigration($result['Pwd'])) {
                        $this->updatePasswordHash($conn, $table, $email, $password);
                    }

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

                // Validar hashes actuales y permitir la primera entrada de cuentas antiguas.
                if ($result && $this->isPasswordValid($passwordp, $result['Pwd'])) {
                    if ($this->needsPasswordMigration($result['Pwd'])) {
                        $this->updatePasswordHash($conn, 'promotor', $emailp, $passwordp);
                    }

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

    public function update()
    {
        if (!isset($_SESSION['user']) || !isset($_SESSION['user_type'])) {
            header("Location: ../Vista/fan-login.php");
            exit();
        }

        $email = $_SESSION['user'];
        $tipo = $_SESSION['user_type'];
        $conn = $this->db->getConnection();

        try {
            if ($tipo === 'Aficionado') {
                $name = trim($_POST['FanName'] ?? '');
                $newEmail = trim($_POST['FanEmail'] ?? '');
                $sport = trim($_POST['FanSport'] ?? '');

                if ($name === '' || $newEmail === '' || $sport === '') {
                    $_SESSION['update_error'] = 'Debes completar todos los campos para actualizar tu perfil.';
                    header('Location: ../Vista/profile.php');
                    exit();
                }

                if ($newEmail !== $email) {
                    $stmt = $conn->prepare("SELECT COUNT(*) AS exist FROM aficionado WHERE Email = :email AND Email <> :current");
                    $stmt->execute([':email' => $newEmail, ':current' => $email]);
                    $res = $stmt->fetch(PDO::FETCH_ASSOC);

                    if (intval($res['exist']) > 0) {
                        $_SESSION['update_error'] = 'El correo ya está en uso por otro aficionado.';
                        header('Location: ../Vista/profile.php');
                        exit();
                    }
                }

                $stmt = $conn->prepare("UPDATE aficionado SET Name = :name, Email = :newEmail, Sport = :sport WHERE Email = :email");
                $stmt->execute([
                    ':name' => $name,
                    ':newEmail' => $newEmail,
                    ':sport' => $sport,
                    ':email' => $email
                ]);

                $stmt = $conn->prepare("SELECT Name AS nombre, Email AS email, Sport AS deporte, 'Aficionado' AS tipo FROM aficionado WHERE Email = :email");
                $stmt->execute([':email' => $newEmail]);
                $userInfo = $stmt->fetch(PDO::FETCH_ASSOC);

                $_SESSION['user'] = $newEmail;
                $_SESSION['user_info'] = $userInfo;
                $_SESSION['update_success'] = 'Perfil actualizado correctamente.';
                header('Location: ../Vista/profile.php');
                exit();
            }

            if ($tipo === 'Promotor') {
                $name = trim($_POST['ProName'] ?? '');
                $newEmail = trim($_POST['ProEmail'] ?? '');
                $direction = trim($_POST['ProDirection'] ?? '');
                $creditCard = trim($_POST['ProCreditCard'] ?? '');

                if ($name === '' || $newEmail === '' || $direction === '' || $creditCard === '') {
                    $_SESSION['update_error'] = 'Debes completar todos los campos para actualizar tu perfil.';
                    header('Location: ../Vista/profile_promotor.php');
                    exit();
                }

                if ($newEmail !== $email) {
                    $stmt = $conn->prepare("SELECT COUNT(*) AS exist FROM promotor WHERE Email = :email AND Email <> :current");
                    $stmt->execute([':email' => $newEmail, ':current' => $email]);
                    $res = $stmt->fetch(PDO::FETCH_ASSOC);

                    if (intval($res['exist']) > 0) {
                        $_SESSION['update_error'] = 'El correo ya está en uso por otro promotor.';
                        header('Location: ../Vista/profile_promotor.php');
                        exit();
                    }
                }

                $stmt = $conn->prepare("UPDATE promotor SET Name = :name, Email = :newEmail, Direction = :direction, CreditCard = :creditCard WHERE Email = :email");
                $stmt->execute([
                    ':name' => $name,
                    ':newEmail' => $newEmail,
                    ':direction' => $direction,
                    ':creditCard' => $creditCard,
                    ':email' => $email
                ]);

                $stmt = $conn->prepare("SELECT Name AS nombre, Email AS email, Direction AS direccion, CreditCard AS tarjeta, 'Promotor' AS tipo FROM promotor WHERE Email = :email");
                $stmt->execute([':email' => $newEmail]);
                $userInfo = $stmt->fetch(PDO::FETCH_ASSOC);

                $_SESSION['user'] = $newEmail;
                $_SESSION['user_info'] = $userInfo;
                $_SESSION['update_success'] = 'Perfil actualizado correctamente.';
                header('Location: ../Vista/profile_promotor.php');
                exit();
            }

            $_SESSION['update_error'] = 'Tipo de usuario no válido para actualizar el perfil.';
            header('Location: ../Vista/fan-login.php');
            exit();
        } catch (PDOException $e) {
            $_SESSION['update_error'] = 'Error al actualizar el perfil: ' . $e->getMessage();
            header('Location: ' . ($tipo === 'Promotor' ? '../Vista/profile_promotor.php' : '../Vista/profile.php'));
            exit();
        }
    }

    public function changePassword()
    {
        if (!isset($_SESSION['user']) || !isset($_SESSION['user_type'])) {
            header("Location: ../Vista/fan-login.php");
            exit();
        }

        $email = $_SESSION['user'];
        $tipo = $_SESSION['user_type'];
        $newPassword = trim($_POST['new_password'] ?? '');
        $confirmPassword = trim($_POST['confirm_password'] ?? '');

        if ($newPassword === '' || $confirmPassword === '') {
            $_SESSION['password_error'] = 'Debes completar ambos campos de contraseña.';
            header('Location: ../Vista/change-password.php');
            exit();
        }

        if (strlen($newPassword) < 6) {
            $_SESSION['password_error'] = 'La contraseña debe tener al menos 6 caracteres.';
            header('Location: ../Vista/change-password.php');
            exit();
        }

        if ($newPassword !== $confirmPassword) {
            $_SESSION['password_error'] = 'Las contraseñas no coinciden.';
            header('Location: ../Vista/change-password.php');
            exit();
        }

        $conn = $this->db->getConnection();
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        try {
            if ($tipo === 'Aficionado') {
                $stmt = $conn->prepare("UPDATE aficionado SET Pwd = :pwd, PwdCon = :pwdcon WHERE Email = :email");
                $stmt->execute([
                    ':pwd' => $hashedPassword,
                    ':pwdcon' => $hashedPassword,
                    ':email' => $email
                ]);
            } elseif ($tipo === 'Promotor') {
                $stmt = $conn->prepare("UPDATE promotor SET Pwd = :pwd WHERE Email = :email");
                $stmt->execute([
                    ':pwd' => $hashedPassword,
                    ':email' => $email
                ]);
            } else {
                $_SESSION['password_error'] = 'Tipo de usuario no válido.';
                header('Location: ../Vista/change-password.php');
                exit();
            }

            if ($stmt->rowCount() === 0) {
                $_SESSION['password_error'] = 'No se pudo actualizar la contraseña. Verifica tu sesión.';
                header('Location: ../Vista/change-password.php');
                exit();
            }

            if (!empty($_SESSION['user_info'])) {
                $_SESSION['user_info']['pwd'] = $hashedPassword;
                if ($tipo === 'Aficionado') {
                    $_SESSION['user_info']['pwdcon'] = $hashedPassword;
                }
            }

            $_SESSION['password_success'] = 'Contraseña actualizada correctamente.';
            header('Location: ../Vista/change-password.php');
            exit();
        } catch (PDOException $e) {
            $_SESSION['password_error'] = 'Error al actualizar la contraseña: ' . $e->getMessage();
            header('Location: ../Vista/change-password.php');
            exit();
        }
    }

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
