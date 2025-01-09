<?php
// Model - Koneksi database
class dbConnection
{
  private $host = "localhost";
  private $dbName = "uas_web";
  private $username = "root";
  private $password = "";

  // Koneksi ke database
  public function connect()
  {
    try {
      $conn = new PDO("mysql:host=$this->host;dbname=$this->dbName", $this->username, $this->password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      return $conn;
    } catch (PDOException $e) {
      echo "Koneksi gagal: " . $e->getMessage();
      return null;
    }
  }
}
?>