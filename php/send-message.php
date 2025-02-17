<?php

// Define a zona de tempo padrão
date_default_timezone_set('America/Sao_Paulo');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once 'vendor/autoload.php';

// Verifica se o formulário foi enviado
if (isset($_POST['send-message'])) {
  // Cria uma nova instância do objeto PHPMailer
  $mail = new PHPMailer(true);

  // Variáveis (dados fictícios)
  $smtpServer = 'mail.exemplo.com';
  $userName   = 'contato@exemplo.com';
  $password   = 'exemplopass123';
  $port       = '587';
  $smtpSecure = 'tls';
  $subject    = 'Nova Mensagem de Contato';

  // Corpo do e-mail
  $field = "<strong>Nome:</strong> {$_POST['name']}<br>";
  $field .= "<strong>E-mail:</strong> {$_POST['email']}<br>";
  $field .= "<strong>Mensagem:</strong><br>{$_POST['message']}<br>";

  // Configurações do servidor de e-mail
  $mail->SMTPDebug = 0; // Habilitar saída de depuração SMTP (0 para desativar)
  $mail->setLanguage('pt');
  $mail->isSMTP(); // Utiliza SMTP
  $mail->Host       = $smtpServer; // Servidor SMTP
  $mail->SMTPAuth   = true; // Autenticação SMTP ativada
  $mail->Username   = $userName; // E-mail de envio
  $mail->Password   = $password; // Senha do e-mail de envio
  $mail->SMTPSecure = $smtpSecure; // Protocolo de segurança
  $mail->Port       = $port; // Porta do servidor SMTP

  // Configurações do e-mail
  $mail->CharSet  = 'UTF-8'; // Configurações de charset
  $mail->setFrom($_POST['email'], $_POST['name']); // E-mail e nome do remetente
  $mail->addAddress('contato@exemplo.com'); // E-mail do destinatário
  $mail->isHTML(true);
  $mail->Subject = $subject;  // Assunto do e-mail
  $mail->Body    = $field;    // Corpo do e-mail

  // Tenta enviar o e-mail
  try {
    $mail->send();
    // Caso o email seja enviado, armazena a mensagem em uma variável de sessão
    session_start();
    $_SESSION['message-sent'] = '<span id="message-sent" style="display: block; width: 100%; height: auto; background-color: #1D3E53; text-align: center; padding: 7.5px 0; color: #fafafa">Mensagem enviada!</span>';
  } catch (Exception $e) {
    // Caso o email não seja enviado, armazena a mensagem em uma variável de sessão
    session_start();
    $_SESSION['message-sent'] = '<span id="message-sent" style="display: block; width: 100%; height: auto; background-color: #aa2c2c; text-align: center; padding: 7.5px 0; color: #fafafa">Não foi possível enviar sua mensagem!</span>';
  }
  // Redireciona de volta para a página do formulário
  header('Location: /');
  exit();
}
