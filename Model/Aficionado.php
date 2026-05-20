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
public function getFanName()
    {
        return $this->FanName;
    }
 
    public function getFanEmail()
    {
        return $this->FanEmail;
    }
 
    public function getFanPwd()
    {
        return $this->FanPwd;
    }
 
    public function getFanPwdCon()
    {
        return $this->FanPwdCon;
    }
 
    public function getFanSport()
    {
        return $this->FanSport;
    }
}
?>