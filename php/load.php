<?php
require 'config.php';

if($_SERVER['REQUEST_METHOD'] === "GET") {
  $sql = "SELECT * FROM accounts ORDER BY id DESC";
  $res = $db->getData($sql);
  
  // convert to json
  echo json_encode($res);
  
} else {
  header("Location: ../index.html");
}