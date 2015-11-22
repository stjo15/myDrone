<?php 
/**
 * This is a Anax pagecontroller.
 *
 */

// Get environment & autoloader and the $app-object.
require __DIR__.'/config_with_app.php'; 

// Read the config files for this theme
$app->url->setUrlType(\Anax\Url\CUrl::URL_CLEAN);
$app->theme->configure(ANAX_APP_PATH . 'config/theme_me.php');
$app->navbar->configure(ANAX_APP_PATH . 'config/navbar_drone.php');

// Add custom stylesheets for this app

$app->theme->addStylesheet('css/stalle-grid/theme_drone.css');

// Add routers for the pages

$app->router->add('', function() use ($app) {
    
    $content = $app->fileContent->get('me.md');
    $content = $app->textFilter->doFilter($content, 'shortcode, markdown');
    
    $byline  = $app->fileContent->get('byline.md');
    $byline = $app->textFilter->doFilter($byline, 'shortcode, markdown');
    
    $app->views->add('me/page', [
        'content' => $content,
        'byline' => null,
        ], 'flash');
    
    $app->dispatcher->forward([
        'controller' => 'question',
        'action'     => 'list',
        'params'     => [null, 'timestamp DESC', 'question', 'De senaste frågorna', 10],
    ], 'main');
    
    $app->dispatcher->forward([
        'controller' => 'question',
        'action'     => 'taglist',
        'params'     => ['questions DESC', 'De hetaste kategorierna', 5],
    ], 'rsidebar');
    
    $app->dispatcher->forward([
        'controller' => 'users',
        'action'     => 'userlist',
        'params'     => ['xp DESC', 'Mest aktiva användare', 10],
    ], 'rsidebar');
    
    $app->theme->setTitle("Terminal");
});

$app->router->add('question', function() use ($app) {
    $app->theme->setTitle("Frågeportal");
    
    $app->dispatcher->forward([
        'controller' => 'question',
        'action'     => 'list',
        'params'     => [null, 'timestamp DESC', 'question', 'Alla frågor'],
    ]);
    
});

$app->router->add('answer', function() use ($app) {
    $app->theme->setTitle("Svar");
    
    $app->dispatcher->forward([
        'controller' => 'answer',
        'action'     => 'view',
        'params'     => [null, 'timestamp DESC', 'answer'],
    ]);
    
});

$app->router->add('om', function() use ($app) {
    $app->theme->setTitle("Om Drone Zone");
    
    $content = $app->fileContent->get('om.md');
    $content = $app->textFilter->doFilter($content, 'shortcode, markdown');
    
    $byline  = $app->fileContent->get('byline.md');
    $byline = $app->textFilter->doFilter($byline, 'shortcode, markdown');
    
    $app->views->add('me/page', [
        'content' => $content,
        'byline' => null,
        ], 'main');
});


$app->router->add('source', function() use ($app) {
    $app->theme->addStylesheet('css/source.css');
    $app->theme->setTitle("Källkod");
    
    $source = new \Me\Source\CSource([
        'secure_dir' => '..', 
        'base_dir' => '..', 
        'add_ignore' => ['.htaccess'],
    ]);
    
    $app->views->add('me/source', [
        'content' => $source->View(),
    ]);
    
});

$app->router->add('comment', function() use ($app) {
    
    $app->theme->setTitle("Kommentarer");

    $app->dispatcher->forward([
        'controller' => 'comment',
        'action'     => 'view',
        'params'     => [],
    ]);

});

$app->router->add('users', function() use ($app) {
    
    $app->dispatcher->forward([
        'controller' => 'users',
        'action'     => 'check',
    ]);
     
});

$app->router->add('rss', function() use ($app) {
        
    $app->theme->setTitle("RSS-flöde");
    
    $app->dispatcher->forward([
        'controller' => 'rss',
        'action'     => 'list',
    ]);
     
});



// Handle all routes.

$app->router->handle();

// Render the response using theme engine.

$app->theme->render();
