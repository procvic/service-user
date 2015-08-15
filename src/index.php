<?php

require 'vendor/autoload.php';
require 'Model.php';

$result = [
    'surname' => 'John',
    'lastname' => 'Doe',
    'email' => 'john@doe.com'
];

$app = new \Slim\Slim();

$app->get('/me', function () use ($app, $result) {
    $response = $app->response();
    $response['Content-Type'] = 'application/json';
    $response->status(200);
    $response->body(json_encode($result));
});


$app->get('/get-info/:id', function ($id) use ($app) {
    $response = $app->response();
    $response['Content-Type'] = 'application/json';
    $pdo = connectDB();

    if (!userExists($pdo, $id)) {
        $response->status(400);
        $response->body(json_encode(['error' => 'User does not exist.']));
    }

    $user = getUserInformation($pdo, $id);

    $response->status(200);
    $response->body(json_encode([
        'name' => $user['name'],
        'surname' => $user['surname'],
        'email' => $user['email']
    ]));
});


$app->post('/add', function () use ($app) {
    $response = $app->response();
    $response['Content-Type'] = 'application/json';
    $request = $app->request;

    $email = $request->post('email');
    $password = $request->post('password');

    if ($email == null || $password == null) {
        $response->status(400);
        $response->body(json_encode(['error' => 'Data are not complete.']));
    }

    $pdo = connectDB();

    if (existsEmailInUsers($pdo, $email)) {
        $response->status(400);
        $response->body(json_encode(['error' => 'Email is already registered.']));
    }

    registerWithPassword($pdo, $email, $password);

    $response['Content-Type'] = 'application/json';
    $response->status(201);
    $response->body(json_encode(['success' => 'User was created.']));
});

$app->run();
