<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

require __DIR__ . '/../vendor/autoload.php';
require_once dirname(__FILE__) . '/../src/models/login.php';
require_once dirname(__FILE__) . '/../src/models/notes.php';

$app = AppFactory::create();

// TEST
$app->get('/test', function (Request $request, Response $response, array $args) {
    $response->getBody()->write('Test complete');

    return $response;
});

// LOGIN
$app->get('/login/{username}/{password}', function (Request $request, Response $response, array $args) {
    $db = new Login();

    $username = $args['username'];
    $password = $args['password'];

    $result = $db->getUser($username, $password);

    $response->getBody()->write(json_encode($result->toArray()));

    return $response;
});


// NOTES
$app->get('/notes/{idUser}', function (Request $request, Response $response, array $args) {
    $idUser = $args['idUser'];

    $db = new Notes();
    $result = $db->getNotes($idUser);
    
    $response->getBody()->write(json_encode($result->toArray()));

    return ($response);
});

$app->post('/notes/new/{idUser}', function (Request $request, Response $response, array $args) {
    $idUser = $args['idUser'];
    $note = $request->getParsedBody();

    $db = new Notes();
    $result = $db->newNote($idUser, $note);
    $response->getBody()->write(json_encode($result));

    return $response;
});

$app->delete('/notes/delete/{idUser}/{idNote}', function (Request $request, Response $response, array $args) {
    $idUser = $args['idUser'];
    $idNote = $args['idNote'];
    //$response->getBody()->write(json_encode($request->getParsedBody()));

    $db = new Notes();
    $result = $db->deleteNote($idUser, $idNote);
    $response->getBody()->write(json_encode($result));

    return $response;
});

$app->post('/notes/update/{idUser}/{idNote}', function (Request $request, Response $response, array $args) {
    $idUser = $args['idUser'];
    $idNote = $args['idNote'];

    $updateNote = $request->getParsedBody();

    $db = new Notes();
    $result = $db->updateNote($idUser,$idNote,$updateNote);
    $response->getBody()->write(json_encode($request->getParsedBody()));

    return $response;
});

$app->run();
