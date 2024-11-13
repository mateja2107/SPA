<?php
require 'config.php';

if($_SERVER['REQUEST_METHOD'] === "GET" && isset($_GET['id'])) {
  $id = $_GET['id'];

  $user = $db->getUser($id);
  
  echo json_encode($user);
} 