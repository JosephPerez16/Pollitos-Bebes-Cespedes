<?php
require __DIR__.'/bootstrap.php';
if ($_SERVER['REQUEST_METHOD']!=='POST'){http_response_code(405);exit;}
$body=bodyJson(); $user=trim((string)($body['user']??'')); $password=(string)($body['password']??'');
if($user===''||$password===''){http_response_code(400);echo json_encode(['message'=>'Completa tu usuario y contraseña.']);exit;}
$stmt=$pdo->prepare('SELECT id, display_name, username, password_hash, active FROM users WHERE username = ? LIMIT 1');$stmt->execute([$user]);$account=$stmt->fetch();
if(!$account||!(bool)$account['active']||!password_verify($password,$account['password_hash'])){usleep(350000);http_response_code(401);echo json_encode(['message'=>'Usuario o contraseña incorrectos.']);exit;}
session_regenerate_id(true);$_SESSION['owner_id']=(int)$account['id'];$_SESSION['display_name']=$account['display_name'];$pdo->prepare('UPDATE users SET last_login_at=NOW() WHERE id=?')->execute([$account['id']]);
echo json_encode(['ok'=>true,'name'=>$account['display_name']]);
