<?php

namespace Email;

use \PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as PHPMailerException;


class Email{

    /**
     * credenciais de acesso SMTP
     * @var string
    */
    const HOST = 'smtp.gmail.com';
    const USER = '@gmail.com';
    const PASS = '123';
    const SECURE = 'TLS';
    const CHARSET = '587';

    /**
    * Dados remetente
    * @var string
    */
    const FROM_EMAIL = '@gmail.com';
    const FROM_NAME = 'Name';

    /**
    * Mensagem de erro de envio
    * @var string
    */
    private $error;

    /**
    * Metodo resp retorno do erro de envio.
    * @return string
    */
    public function getError(){
        return $this->error;
    }

    /**
     * Método responsável pelo envio do email
     * @param string/array $addresses
     * @param string $subject
     * @param string $body
     * @param string/array $attachments
     * @param string/array $ccs
     * @param string/array $bccs
     * @return boolean
     * 
     */
    public function sendEmail($addresses, $subject, $body, $attachments = [], $ccs = [], $bccs = []){
       //limpa msg de erro
       $this->error = '';

       //instancia do phpmailer
       $objMail = new PHPMailer(true);
       try {
           //credenciais de acesso smtp
           $objMail->isSMTP(true);
           $objMail->Host = self::HOST;
           $objMail->SMTPAuth = true;
           $objMail->Username = self::USER;
           $objMail->Password = self::PASS;
           $objMail->SMTPSecure = self::SECURE;
           //$objMail->Port = self::PORT;
           $objMail->Charset = self::CHARSET;

           ///rementente
           $objMail->setFrom(self::FROM_EMAIL, self::FROM_NAME);

           //destinatario
           $addresses = is_array($addresses) ? $addresses : [$addresses];
           foreach($addresses as $address){
               $objMail->addAdress($address);
           }

           //anexos
           $attachments = is_array($attachments) ? $attachments : [$attachments];
           foreach($attachments as $attachment){
               $objMail->addAttachment($attachment);
           }

           //cc
           $ccs = is_array($ccs) ? $ccs : [$ccs];
           foreach($ccs as $cc){
               $objMail->addCC($cc);
           }
           //bcc
           $bccs = is_array($bccs) ? $bccs : [$bccs];
           foreach($bccs as $bcs){
               $objMail->addBCC($bcs);
           }

           //conteudo
           $objMail->isHTML(true);
           $objMail->Subject = $subject;
           $objMail->Body = $body;

           //send
           return $objMail->send();
           
       } catch (PHPMailerException $e) {
           $this->error = $e->getMessage();
           return false;
       }
    }

}