<?php
require __DIR__.'/bootstrap.php';
if(empty($_SESSION['owner_id'])){http_response_code(401);echo json_encode(['message'=>'Unauthorized']);exit;}
echo json_encode(['ok'=>true,'name'=>$_SESSION['display_name']??'César']);
