<?php
class Connection {
  public $conn;

  public function __construct($db) {
    $this->connect($db);
  }

  private function connect($db) {
    $db_name = $db['db_name'];
    $host = $db['host'];
    $username = $db['username'];
    $password = $db['password'];

    try {
      $this->conn = new PDO("mysql:host={$host};dbname={$db_name}", $username, $password);
      $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    } catch(PDOException $e) {
      echo "Connection failed." . $e->getMessage();
    }
  }

  public function getData($sql) {
    try {
      $query = $this->conn->query($sql);

      $res = $query->fetchAll(PDO::FETCH_ASSOC);

      return $res;

    } catch(PDOException $e) {
      return 'Error: ' . $e->getMessage();
    }
  }

  public function insertData($sql, $data) {
    $name = $data['name'];
    $deposit = $data['deposit'];
    $credit_card = $data['credit_card'];

    try {
      $query = $this->conn->prepare($sql);

      //* "INSERT INTO accounts (id, name, deposit, credit_card) VALUE(NULL, :name, :deposit, :credit_card)";
      // $query->bindParam(':name', $name);
      // $query->bindParam(':deposit', $deposit);
      // $query->bindParam(':credit_card', $credit_card);

      // $res = $query->execute();

      //* "INSERT INTO accounts (id, name, deposit, credit_card) VALUE(NULL, ?, ?, ?)";
      $res = $query->execute([$name, $deposit, $credit_card]);

      return $res;

    } catch(PDOException $e) {
      return 'Error: ' . $e->getMessage();
    }
  }

  public function updateData($sql, $data) {
    extract($data);

    try {
      $query = $this->conn->prepare($sql);

      $query->execute([$name, $deposit, $credit_card, $id]);

      $res = $query->rowCount();

      return $res;

    } catch(PDOException $e) {
      return 'Error: ' . $e->getMessage();
    }
  }

  public function getUser($id) {
    try {
      $sql = "SELECT * FROM accounts WHERE id = :id";

      $query = $this->conn->prepare($sql);
      $query->bindParam(':id', $id);

      $res = $query->execute();
      $res = $query->fetch(PDO::FETCH_ASSOC);

      return $res;

    } catch(PDOException $e) {
      return "Error " . $e->getMessage();
    } 
  }

  public function delete($id) {
    try {
      $sql = "DELETE FROM accounts WHERE id = ?";

      $query = $this->conn->prepare($sql);
  
      $res = $query->execute([$id]);
      
      return $res;

    } catch(PDOException $e) {
      return "Error: " . $e->getMessage();
    }
  }

  public function getFilteredData($cards) {
    $sql = "SELECT * FROM accounts WHERE credit_card = ?";

    if(count($cards) > 1) {
      for ($i = 1; $i < count($cards); $i++) { 
        $sql .= " OR credit_card = ?";
      }
    }

    try {
      $query = $this->conn->prepare($sql);
      $query->execute($cards);

      $res = $query->fetchAll(PDO::FETCH_ASSOC);

      return $res;

    } catch(PDOException $e) {
      return "Error: " . $e->getMessage();
    }
  }
}