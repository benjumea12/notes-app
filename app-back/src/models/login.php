<?php
  class Login {
    private $connection;
    private $colection;

    function __construct() {
      require_once dirname(__FILE__) . '/../config/dbConnect.php';
      $db = new dbConnect();
      $this->connection = $db->connect();
      $this->colection = $this->connection->users;
    }

    // FUnction to search user
    public function getUser($username, $password) {
      $query = array('$and' => [
        array('username' => $username),
        array('password' => $password)
      ]);

      $result = $this->colection->find($query);
      return $result;
    }
  }
