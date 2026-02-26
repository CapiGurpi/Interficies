
<?php
// controller/UserController.php
require_once '../model/db.php';

class UserController {
    private $connection;

    public function __construct() {
        $db = new Database();
        $this->connection = $db->getConnection();
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Recogemos datos (N_Usuario y Correo del modelo lógico)
            $nombre = $_POST['n_usuario'];
            $email  = $_POST['correo'];
            $pass   = password_hash($_POST['password'], PASSWORD_BCRYPT); // Encriptar
            $tipo   = $_POST['user_type']; // 'admin' o 'estandar' 

            // Validar campos (Requerimiento 4.5) 
            if (empty($nombre) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                header("Location: ../views/registro.php?error=Datos incorrectos");
                exit();
            }

            // Insertar en la tabla USUARIOS 
            $sql = "INSERT INTO USUARIOS (N_Usuario, Correo, Contrasena, user_type) VALUES (?, ?, ?, ?)";
            $stmt = $this->connection->prepare($sql);
            $stmt->bind_param("ssss", $nombre, $email, $pass, $tipo);

            if ($stmt->execute()) {
                header("Location: ../index.php?success=Registrado");
            } else {
                header("Location: ../views/registro.php?error=Error al guardar");
            }
        }
    }
    
    // Aquí irían también login() y logout() 
}
?>