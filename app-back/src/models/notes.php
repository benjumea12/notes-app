<?php
  class Notes {
    private $connection;
    private $colection;

    function __construct() {
      require_once dirname(__FILE__) . '/../config/dbConnect.php';
      $db = new dbConnect();
      $this->connection = $db->connect();
      $this->colection = $this->connection->users;
    }

    // Function to create notes
    public function getNotes($idUser) {
      try{
        $query = array('_id' =>  new MongoDB\BSON\ObjectId($idUser));

        $result = $this->colection->find($query);
        return $result;

      } catch (MongoConnectionException $e) {
        die('Error connecting to MongoDB server');
      } catch (MongoException $e) {
        die('Error: ' . $e->getMessage());
      }
    }

    public function newNote($idUser, $note) {
      try{
        $newNote = array( '_id' => new MongoDB\BSON\ObjectId(),
                          'title' => $note['title'], 
                          'text' => $note['text'], 
                          'color' => $note['color'],
                          'archive' => $note['archive']);


        $query = array('_id' => new MongoDB\BSON\ObjectId($idUser));
        $queryNote = array('$addToSet' => array('notes' => $newNote));

        $result = $this->colection->updateOne($query, $queryNote);
        return $result->getModifiedCount();

      } catch (MongoConnectionException $e) {
        die('Error connecting to MongoDB server');
      } catch (MongoException $e) {
        die('Error: ' . $e->getMessage());
      }
    }

    public function deleteNote($idUser, $idNote) {
      try{
        $queryFind = array( '_id' => new MongoDB\BSON\ObjectId($idUser),
                            'notes._id' => new MongoDB\BSON\ObjectId($idNote));

        $query = array('$pull' => array('notes' => array('_id' => new MongoDB\BSON\ObjectId($idNote))));

        $result = $this->colection->updateOne($queryFind, $query);
        return $result->getModifiedCount();

      } catch (MongoConnectionException $e) {
        die('Error connecting to MongoDB server');
      } catch (MongoException $e) {
        die('Error: ' . $e->getMessage());
      }
    }

    public function updateNote($idUser,$idNote,$updateNote) {
      try{
        $queryFind = array( '_id' => new MongoDB\BSON\ObjectId($idUser),
                            'notes._id' => new MongoDB\BSON\ObjectId($idNote));

        $query = array('$set' => array('notes.$.title' => $updateNote['title'],
                                        'notes.$.text' => $updateNote['text'],
                                        'notes.$.color' => $updateNote['color'],
                                        'notes.$.archive' => $updateNote['archive']));

        $result = $this->colection->updateOne($queryFind, $query);
        return $result->getModifiedCount();

      } catch (MongoConnectionException $e) {
        die('Error connecting to MongoDB server');
      } catch (MongoException $e) {
        die('Error: ' . $e->getMessage());
      }
    }
  }
