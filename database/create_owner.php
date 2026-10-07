<?php
// Ejecutar una sola vez desde consola: php create_owner.php usuario "Contraseña segura"
if(PHP_SAPI!=='cli'){exit("Solo consola.\n");}
if($argc<3){exit("Uso: php create_owner.php <usuario> <contraseña>\n");}
$configFile=__DIR__.'/../api/config.php';if(!is_file($configFile))exit("Falta api/config.php\n");$c=require $configFile;
$pdo=new PDO($c['dsn'],$c['user'],$c['password'],[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);
$hash=password_hash($argv[2],PASSWORD_DEFAULT);
$stmt=$pdo->prepare('INSERT INTO users(display_name,username,password_hash) VALUES(?,?,?) ON DUPLICATE KEY UPDATE display_name=VALUES(display_name),password_hash=VALUES(password_hash),active=1');
$stmt->execute(['César',$argv[1],$hash]);echo "Cuenta de César creada/actualizada correctamente.\n";
