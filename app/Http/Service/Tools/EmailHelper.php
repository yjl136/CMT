<?php
namespace App\Http\Service\Tools;
include_once 'PHPMailerAutoload.php';

define("DEFAULT_SMTP_HOST", "smtp.qiye.163.com");
define("DEFAULT_SMTP_PORT", 25);
define("DEFAULT_SMTP_USER", "techsupports@donica.cn");
define("DEFAULT_SMTP_PSWD", "donica123");

define ("SENDER_ALIAS", "深圳市多尼卡电子技术有限公司");
define ("RECVER_ALIAS", "航空公司用户");

/**
 * 为了避免不同的邮箱造成差异，统一不使用TLS或者SSL方式加密发送邮件。
 * 历史案例：
 * 1. techsupports@donica.cn 使用SMTPSecure = 'tls'能通过验证，不使用也能通过。
 * 2. e-air@airchina.com必须不使用SMTPSecure才能通过验证
 *
 * @author Luke Huang  2015-2-10
 *
 */
class EmailHelper{
    private $mailer;

    public function __construct($smtp_user = DEFAULT_SMTP_USER, $smtp_pswd = DEFAULT_SMTP_PSWD, $smtp_host = DEFAULT_SMTP_HOST, $smtp_port = DEFAULT_SMTP_PORT){
        $this->mailer = new PHPMailer();

        // Set mailer to use SMTP
        $this->mailer->isSMTP();
        // Enable SMTP authentication
        $this->mailer->SMTPAuth = true;
        // Set SMTP parameters
        $this->mailer->Host = $smtp_host;
        $this->mailer->Port = $smtp_port;
        $this->mailer->Username = $smtp_user;
        $this->mailer->Password = $smtp_pswd;

        $this->mailer->From = $smtp_user;
        $this->mailer->FromName = substr($smtp_user, 0, strpos($smtp_user, '@'));
        $this->mailer->WordWrap = 80;

        $this->mailer->isHTML(true);
        $this->mailer->CharSet = "utf-8";

        //Debug SMTP information
        //$this->mailer->SMTPDebug = 1;

        //$this->mailer->MessageDate = date("Y-m-d H:i:s", time());
    }

    public function validateSMTP(){
        return $this->mailer->smtpConnect();
    }

    public function sendEmail($recver, $subject, $body, $attachment_path = ''){
        //Add receiver
        $this->mailer->addAddress($recver, RECVER_ALIAS);
        //Set mail subject
        $this->mailer->Subject = $subject;
        //Set mail body
        $this->mailer->Body = $body;
        //Set mail alt body when the body is invisible
        $this->mailer->AltBody = "请使用HTML方式查看邮件";

        //$this->mailer->AddEmbeddedImage("./include/email/images/email_logo.png", "company-logo", "logo.png");

        // Add attachment
        if(!empty($attachment_path) && file_exists($attachment_path)){
            $this->mailer->addAttachment($attachment_path);
        }

        $flag = $this->mailer->send();

        if ($this->mailer->getSMTPInstance() !== null and $this->mailer->getSMTPInstance()->connected()) {
            $this->mailer->getSMTPInstance()->reset();
        }
        return $flag;
    }

    public function getErrorMsg(){
        return $this->mailer->ErrorInfo;
    }
}