
<?php
session_start();
// controller/UserController.php
require_once '../Model/NextLvlBase.php';
require_once '../Model/Aficionado.php';

// Scanner sc =  new Scanner();
// sc.nextLine();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 
    $userController = new UserController();
 
    if (isset($_POST['register'])) {
        $userController->register();
    }
 
    if (isset($_POST['register-promotor'])) {
        $userController->register();
    }
 
    if (isset($_POST['login'])) {
        $userController->login();
    }
 
    if (isset($_POST['update'])) {
        $userController->update();
    }
 
    if (isset($_POST['delete'])) {
        $userController->delete();
    }

    if (isset($_POST['logout'])){
        $userController ->logout();
    }
}

class UserController
{
    private $connection;

    public function __construct() {}

    public function register() {
        require_once '../Model/NextLvlBase.php';
        if (!empty($_POST['FanName']) && !empty($_POST['FanEmail']) && !empty($_POST['FanPwd'])&& !empty($_POST['FanPwdCon']) && !empty($_POST['FanSport'])) {
            $FanName = $_POST['FanName'];
            $FanEmail = $_POST['FanEmail'];
            $FanPwd = $_POST['FanPwd'];
            $FanPwdCon = $_POST['FanPwdCon'];
            $FanSport = $_POST['FanSport'];

            $aficionado = new Aficionado ($FanName,$FanEmail,$FanPwd,$FanPwdCon,$FanSport);

            $db = new Database();
            $conn = $db->getConnection();

            $aficionado->register($FanPwdCon, $conn);
        }else {

        }
        exit();

    }

    public function login() {
    
    }

    public function logout() {

    }
    
    public function update(){

    }

    public function delete(){

    }
}
?>