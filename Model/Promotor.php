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

    public function getProName()
    {
        return $this->ProName;
    }
 
    public function getProPwd()
    {
        return $this->ProPwd;
    }
 
    public function getProPwdCon()
    {
        return $this->ProPwdCon;
    }
 
    public function getProEmail()
    {
        return $this->ProEmail;
    }
 
    public function getProDirection()
    {
        return $this->ProDirection;
    }
 
    public function getProCreditCard()
    {
        return $this->ProCreditCard;
    }
 
}
?>
