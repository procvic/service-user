<?php

$app->get('/me', function () use ($app) {
    $result = [
        'surname' => 'John',
        'lastname' => 'Doe',
        'email' => 'john@doe.com'
    ];

    $response = $app->response();
    $response['Content-Type'] = 'application/json';
    $response->status(200);
    $response->body(json_encode($result));
});
