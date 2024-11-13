<?php
require 'config.php';

if($_SERVER['REQUEST_METHOD'] === "POST") {
  $json = file_get_contents("php://input");
  $data = json_decode($json, true);
  
  extract($data);

  if($name != '' && $deposit != '' && $credit_card != '') {
    if(strlen($name) >= 3 && ctype_digit($deposit)) {
      $sql = "INSERT INTO accounts (id, name, deposit, credit_card) VALUES (NULL, ?, ?, ?)";
      
      $res = $db->insertData($sql, $data);

      echo json_encode($res);
      
    } else {
      echo json_encode('Invalid data!');
    }
  } else {
    echo json_encode('Unesite sve podatke!');
  }
}