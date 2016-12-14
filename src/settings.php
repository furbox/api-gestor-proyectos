<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],
        //Configuracion DB
        'app_token_name' => 'APP_TOKEN',
        'connectionString' => [
            'dns' => 'mysql:host=localhost;dbname=gestion_proyectos;charset=utf8',
            'user' => 'root',
            'pass' => 'root'
        ],
    ],
];
