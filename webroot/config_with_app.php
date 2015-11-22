<?php
/**
 * Config file for pagecontrollers, creating an instance of $app.
 *
 */

// Get environment & autoloader.
require __DIR__.'/config.php'; 

// Create services and inject into the app. 
$di  = new \Anax\DI\CDIFactoryDefault();

$di->set('CommentController', function() use ($di) {
    $controller = new Phpmvc\Comment\CommentController();
    $controller->setDI($di);
    return $controller;
});

$di->set('QuestionController', function() use ($di) {
    $controller = new Anax\Question\QuestionController();
    $controller->setDI($di);
    return $controller;
});

$di->set('AnswerController', function() use ($di) {
    $controller = new Anax\Answer\AnswerController();
    $controller->setDI($di);
    return $controller;
});

$di->set('UsersController', function() use ($di) {
    $controller = new \Anax\Users\UsersController();
    $controller->setDI($di);
    return $controller;
});

$di->set('RssController', function() use ($di) {
    $controller = new \Anax\Rss\RssFeedController();
    $controller->setDI($di);
    return $controller;
});

/**
 * Start the session.
 *
 */
session_name(preg_replace('/[^a-z\d]/i', '', __DIR__));
session_start();

$app = new \Anax\Kernel\CAnax($di);
