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
$app->navbar->configure(ANAX_APP_PATH . 'config/navbar_me.php');

// Add custom stylesheets for this app

$app->theme->addStylesheet('css/me.css');

// Add routers for the pages

$app->router->add('', function() use ($app) {
    $app->theme->setTitle("Hem");
    
    $content = $app->fileContent->get('me.md');
    $content = $app->textFilter->doFilter($content, 'shortcode, markdown');
    
    $byline  = $app->fileContent->get('byline.md');
    $byline = $app->textFilter->doFilter($byline, 'shortcode, markdown');
    
    $app->views->add('me/page', [
        'content' => $content,
        'byline' => $byline,
        ]);
});

$app->router->add('redovisningar', function() use ($app) {
    $app->theme->setTitle("Redovisning");
    
    $content = $app->fileContent->get('redovisning.md');
    $content = $app->textFilter->doFilter($content, 'shortcode, markdown');
    
    $byline  = $app->fileContent->get('byline.md');
    $byline = $app->textFilter->doFilter($byline, 'shortcode, markdown');
    
    $app->views->add('me/page', [
        'content' => $content,
        'byline' => $byline,
        ]);
});

$app->router->add('kmom01', function() use ($app) {
    $app->theme->setTitle("Kmom01");
    
    $content = $app->fileContent->get('kmom01.md');
    $content = $app->textFilter->doFilter($content, 'shortcode, markdown');
    
    $byline  = $app->fileContent->get('byline.md');
    $byline = $app->textFilter->doFilter($byline, 'shortcode, markdown');
    
    $app->views->add('me/page', [
        'content' => $content,
        'byline' => $byline,
        ]);
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

$app->router->add('kurser', function() use ($app) {
    $app->theme->setTitle("Kurser");
    
    $content = $app->fileContent->get('kurser.md');
    $content = $app->textFilter->doFilter($content, 'shortcode, markdown');
    
    $byline  = $app->fileContent->get('byline.md');
    $byline = $app->textFilter->doFilter($byline, 'shortcode, markdown');
    
    $app->views->add('me/page', [
        'content' => $content,
        'byline' => $byline,
        ]);
});

$app->router->handle();

// Render the response using theme engine.

$app->theme->render();
