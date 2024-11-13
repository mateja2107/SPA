<?php
require 'config.php';

if($_SERVER['REQUEST_METHOD'] === "PUT") {
  $json = file_get_contents("php://input");

  $data = json_decode($json, true);
  
  extract($data);

  if($name != '' && $deposit != '' && $credit_card != '') {
    if(strlen($name) >= 3 && ctype_digit($deposit)) {
      $sql = "UPDATE accounts SET name = ?, deposit = ?, credit_card = ? WHERE id = ?";
      
      $res = $db->updateData($sql, $data);

      echo json_encode($res);

      // prevent Form Resubmission On Page Refresh
      $json = '';
      $data = '';
      
    } else {
      echo json_encode('Invalid data!');
    }
  } else {
    echo json_encode('Unesite sve podatke!');
  }
}