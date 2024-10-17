<?php

// Definir um fuso horario padrao
date_default_timezone_set('America/Sao_Paulo');

// Credenciais do banco de dados
define('HOST', 'localhost');
define('USER', 'root');
define('PASS', '');
define('DBNAME', 'celke');
define('PORT', 3306);

// Credenciais do servidor de e-mail
define('HOSTEMAIL', 'sandbox.smtp.mailtrap.io');
define('USEREMAIL', '299d73bbb4677d');
define('PASSEMAIL', '4e296a97c6763e');
define('SMTPSECURE', 'PHPMailer::ENCRYPTION_STARTTLS');
define('PORTEMAIL', 465);
define('REMETENTE', 'atendimento@celke.com.br');
define('NOMEREMETENTE', 'Atendimento');