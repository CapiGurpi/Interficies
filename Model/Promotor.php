<?php
class Promotor {
    private $ProName;
    private $ProPwd;
    private $ProPwdCon;
    private $ProEmail;
    private $ProDirection;
    private $ProCreditCard;


public function __construct($ProName, $ProPwd, $ProPwdCon, $ProEmail, $ProDirection, $ProCreditCard)
    {
        $this->ProName = $ProName;
        $this->ProPwd = $ProPwd;
        $this->ProPwdCon = $ProPwdCon;
        $this->ProEmail = $ProEmail;
        $this->ProDirection = $ProDirection;
        $this->ProCreditCard = $ProCreditCard;
    }

    public function registerp($ProPwdCon, $conn)
    {
        
        $conn->query("CALL sp_comprovar_email('$this->ProEmail', @result)");
        $result = $conn->query("SELECT @result AS exist");
        $row = $result->fetch_assoc();
        $exist = intval($row["exist"]);
 
        if ($exist === 1) {
            echo "<span>El correo electrónico ya está registrado. Inténtelo con otro.</span>";
            return;
        }
 
        if ($this->ProPwd !== $ProPwdCon) {
            echo "<span>Las contraseñas no coinciden. Inténtelo de nuevo.</span>";
            return;
        }
 
        if ($this->ProPwd === $ProPwdCon && $exist === 0) {
            $insert = $conn->query("INSERT INTO promotor (Name, Email, Pwd, PwdCon, Direction, CreditCard)
                VALUES ('$this->ProName', '$this->ProPwd', '$this->ProPwdCon','$this->ProEmail', '$this->ProDirection', '$this->ProCreditCard')");
            header('Location: ../Vista/index.html');
            exit();
        }
 
        $result->close();
        $conn->close();
    }
}
?>