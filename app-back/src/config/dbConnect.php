<?php
class dbConnect {
  private $client;
  private $database;
  private $dbName = 'notesApp'; 
  private $mongoConnection = 'URL_DB_CONFIG';

  function __construct() {}

  function connect() {

    try {
      $this->client =  new MongoDB\Client($this->mongoConnection);
      $this->database = $this->client->selectDatabase($this->dbName);

      return $this->database;
    }
    catch (MongoConnectionException $e) {
      die('Error connecting to MongoDB server');
    }
  }
}
