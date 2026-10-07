<?php
declare(strict_types=1);
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');
$secure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
session_name('pollitos_session');
session_set_cookie_params(['lifetime'=>0,'path'=>'/','secure'=>$secure,'httponly'=>true,'samesite'=>'Strict']);
session_start();
$configFile = __DIR__ . '/config.php';
if (!is_file($configFile)) { http_response_code(503); echo json_encode(['message'=>'El servidor de acceso aún no está configurado.']); exit; }
$config = require $configFile;
try { $pdo = new PDO($config['dsn'],$config['user'],$config['password'],[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,PDO::ATTR_EMULATE_PREPARES=>false]); }
catch(Throwable $e){ http_response_code(503); echo json_encode(['message'=>'No se pudo conectar con el servicio de acceso.']); exit; }
function bodyJson(): array { $v=json_decode(file_get_contents('php://input'),true); return is_array($v)?$v:[]; }
