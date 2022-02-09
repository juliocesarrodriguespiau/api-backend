<?php

require __DIR__.'/vendor/autoload.php';

use App\Communication\Email\;

$address = 'juliocrpiau80@gmail.com';

$subject = 'Teste';

$body = '<b>Teste</b><br><br><i>Teste</i>';

$objEmial = new Email;

$sucesso = $objEmial->sendEmail($address, $subject, $body);

echo $sucesso ? "Enviado com sucesso" : $objEmial->getError();