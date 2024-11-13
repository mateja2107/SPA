<?php
require 'config.php';

if($_SERVER['REQUEST_METHOD'] === "DELETE" && isset($_GET['id'])) {
  $id = $_GET['id'];

  $res = $db->delete($id);

  echo json_encode($res);
}