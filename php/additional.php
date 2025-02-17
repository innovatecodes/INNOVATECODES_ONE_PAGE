<?php

$mail->SMTPOptions = [
  'ssl' => [
    'verify_peer' => false,
    'verify_peer_name' => false,
    'allow_self_signed' => true,
    'peer_name' => $smtpServer,
  ],
];
