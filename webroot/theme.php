<?php 
/**
 * This is a Anax pagecontroller.
 *
 */

// Get environment & autoloader and the $app-object.
require __DIR__.'/config_with_app.php'; 

// Read the config files for this theme
$app->url->setUrlType(\Anax\Url\CUrl::URL_CLEAN);
$app->theme->configure(ANAX_APP_PATH . 'config/theme-grid.php');
$app->navbar->configure(ANAX_APP_PATH . 'config/navbar_me.php');

// Add custom stylesheets for this app

$app->theme->addStylesheet('css/stalle-grid/theme_forest.css');

// Add routers for the pages

$app->router->add('', function() use ($app) {
 
    $app->theme->setTitle("Regioner");
    
    $app->theme->addStylesheet('css/stalle-grid/regions_demo.css');
 
    $app->views->addString('Flash', 'flash')
               ->addString('Featured 1', 'featured-1')
               ->addString('Featured 2', 'featured-2')
               ->addString('Featured 3', 'featured-3')
               ->addString('Main content', 'main')
               ->addString('Left sidebar', 'lsidebar')
               ->addString('Right sidebar', 'rsidebar')
               ->addString('Triptych 1', 'triptych-1')
               ->addString('Triptych 2', 'triptych-2')
               ->addString('Triptych 3', 'triptych-3')
               ->addString('Footer column 1', 'footer-column-1')
               ->addString('Footer column 2', 'footer-column-2')
               ->addString('Footer column 3', 'footer-column-3')
               ->addString('Footer column 4', 'footer-column-4');
 
});


$app->router->add('typography', function() use ($app) {
        
    $app->theme->setTitle("Typografi");
    
    $app->theme->addStylesheet('css/stalle-grid/grid_demo.css');
    
    $app->views->add('test/typography', [], 'main');
    $app->views->add('test/typography', [], 'lsidebar');
    $app->views->add('test/typography', [], 'rsidebar');
});

$app->router->add('font-awesome', function() use ($app) {
        
    $app->theme->setTitle("Font Awesome");
    
    $app->theme->addStylesheet('css/stalle-grid/regions_demo.css');
    
    $app->views->add('test/font-awesome-main', [], 'main');
    $app->views->add('test/font-awesome-sidebar', [], 'lsidebar');
    $app->views->add('test/font-awesome-sidebar', [], 'rsidebar');
    $app->views->add('test/font-awesome-featured-1', [], 'featured-1');
    $app->views->add('test/font-awesome-featured-2', [], 'featured-2');
    $app->views->add('test/font-awesome-featured-3', [], 'featured-3');
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
    ], 'main');
    
});


$app->router->handle();

// Render the response using theme engine.

$app->theme->render();
