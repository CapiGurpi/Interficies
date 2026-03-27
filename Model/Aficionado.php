<?php
class Aficionado {
    private $FanName;
    private $FanEmail;
    private $FanPwd;
    private $FanPwdCon;
    private $FanSport;


public function __construct($FanName, $FanEmail, $FanPwd, $FanPwdCon, $FanSport)
    {
        $this->FanName = $FanName;
        $this->FanEmail = $FanEmail;
        $this->FanPwd = $FanPwd;
        $this->FanPwdCon = $FanPwdCon;
        $this->FanSport = $FanSport;
    }

    public function register($FanPwdCon, $conn)
    {
        
        $conn->query("CALL sp_comprovar_email('$this->FanEmail', @result)");
        $result = $conn->query("SELECT @result AS exist");
        $row = $result->fetch_assoc();
        $exist = intval($row["exist"]);
 
        if ($exist === 1) {
            echo "<span>El correo electrónico ya está registrado. Inténtelo con otro.</span>";
            return;
        }
 
        if ($this->FanPwd !== $FanPwdCon) {
            echo "<span>Las contraseñas no coinciden. Inténtelo de nuevo.</span>";
            return;
        }
 
        if ($this->FanPwd === $FanPwdCon && $exist === 0) {
             echo "<span>hola.</span>";
            $insert = $conn->query("INSERT INTO aficionado (Name, Email, Pwd, PwdCon, Sport )
                VALUES ('$this->FanName', '$this->FanEmail', '$this->FanPwd','$this->FanPwdCon', '$this->FanSport')");
            header('Location: ../Vista/index.html');
            exit();
        }
 
        $result->close();
        $conn->close();
    }
}
?>