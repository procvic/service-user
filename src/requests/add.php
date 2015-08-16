<?php

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
        return;
    }

    registerWithPassword($pdo, $email, $password);

    $response['Content-Type'] = 'application/json';
    $response->status(201);
    $response->body(json_encode(['success' => 'User was created.']));
});
