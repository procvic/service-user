<?php

$result = [
    'surname' => 'John',
    'lastname' => 'Doe',
    'email' => 'john@doe.com'
];

$app->get('/me', function () use ($app, $result) {
    $response = $app->response();
    $response['Content-Type'] = 'application/json';
    $response->status(200);
    $response->body(json_encode($result));
});
