<?php
/**
 * Created by PhpStorm.
 * User: 95
 * Date: 2017/11/26
 * Time: 22:02
 */

namespace Model;


class Mail
{
    private $head = '';
    private $from = 'root@anlike.cc';
    private $from_name = 'AnLike';
    private $to = '';
    private $encoding = 'utf-8';
    private $subject_preferences = [];
    private $mail_formate = 'txt';

    public function __construct($mail_formate)
    {
        $this->Gethead($mail_formate);
    }

    public function SendMail($to, $subject, $message)
    {
        $this->to = $to;
        $this->head .= iconv_mine_encode("Subject", $subject, $this->subject_preferences);
        mail($this->to,$subject,$message,$this->head);
    }

    private function Gethead($mail_formate)
    {
        if ($mail_formate == 'txt') return;

        $this->subject_preferences = array(
            'input-charset' =>  $this->encoding,
            'output-charset'=>  $this->encoding,
            'line-length'   => 76,
            'line-break-chars'  =>  '\r\n',
        );
        $this->head = "Content-type: text/html; charset=".$this->encoding.' \r\n';
        $this->head .= "From: ".$this->from_name.' <'.$this->from.'> \r\n';
        $this->head .= 'MIME-Version: 1.0 \r\n';
        $this->head .= 'Content-Transfer-Encoding: 8bit \r\n';
        $this->head .= 'Date: '.date("r (T)").' \r\n';
    }
}