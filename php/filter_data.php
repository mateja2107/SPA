<?php
require 'config.php';

if($_SERVER['REQUEST_METHOD'] === "POST") {
  $cards = json_decode(file_get_contents("php://input"), true);
  
  if(count($cards) > 0) {
    $res = $db->getFilteredData($cards);

    echo json_encode($res);
  }
}