<?php
class Aficionado {
    public $FanName;
    public $FanEmail;
    public $FanPwd;
    public $FanPwdCon;
    public $FanSport;

    public function __construct($FanName, $FanEmail, $FanPwd, $FanPwdCon, $FanSport)
    {
        $this->FanName = $FanName;
        $this->FanEmail = $FanEmail;
        $this->FanPwd = $FanPwd;
        $this->FanPwdCon = $FanPwdCon;
        $this->FanSport = $FanSport;
    }
}
?>
