<?php

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
