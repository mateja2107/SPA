<?php
require 'functions.php';
require 'classes/Connection.php';

$conn = [
  "db_name" => "spa",
  "host" => "localhost",
  "username" => "root",
  "password" => ""
];

$db = new Connection($conn);