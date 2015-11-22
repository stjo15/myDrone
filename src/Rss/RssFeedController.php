<?php

namespace Anax\Rss;
 
/**
 * A controller for RSS events.
 *
 */
class RssFeedController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;
    
    /**
    * Initialize the controller.
    *
    * @return void
    */
    public function initialize()
    {
        $this->rss = new \Anax\Rss\RssFeed();
        $this->rss->setDI($this->di);
        
        $this->users = new \Anax\Users\User();
        $this->users->setDI($this->di);
    }
    
    
    /**
    * Create a new RSS feeder using an HTML Form.
    *
    * @param str $pagekey The key for the page of the feed (the last part of the page url) 
    *
    * @return void
    */
    public function setupAction($pagekey=null) {
        
        $this->users->denyAccessToPage('admin');

        $form = new \Anax\HTMLForm\CFormRssAdd($pagekey);
        $form->setDI($this->di);
        $status = $form->check();
        
        $this->theme->setTitle("Skapa ett RSS-flöde");
        $this->views->add('rss/add', [
            'title' => "Skapa ett RSS-flöde",
            'form' => $form->GetHTML(),
            ]);   
    }
    
    /**
    * List all RSS feeds.
    *
    * @return void
    */
    public function listAction()
    {
        $all = $this->rss->findAll();
 
        $this->theme->setTitle("Visa alla RSS-flöden");
        $this->views->add('rss/list-all', [
            'feeds' => $all,
            'title' => "Visa alla RSS-flöden",
        ], 'main');
        
        $this->views->add('rss/rss-sidebar', [], 'rsidebar');
     }
     
    /**
    * Read the created RSS xml form. This should be the action available for the application user.
    *
    * @param str $pagekey The key for the page of the feed (the last part of the page url) 
    *
    * @return void
    */
     public function viewAction($pagekey = null) {
        $xmlfile = ANAX_APP_PATH . 'rss/' . $pagekey . "_rss.xml";
        
        header("Content-Type: application/xml; charset=utf-8"); 
        readfile($xmlfile);
       
    }
    
    
    /**
    * Delete an RSS feed with.
    *
    * @param integer $id of RSS feed to delete.
    * @param str $pagekey The key for the page of the feed (the last part of the page url) 
    *
    * @return void
    */
    public function deleteAction($id = null, $pagekey = null)
    {
        $this->users->denyAccessToPage('admin');
        
        if (!isset($id)) {
            die("Missing id");
        }
 
        $res = $this->rss->delete($id);
        
        $xmlfile = ANAX_APP_PATH . 'rss/' . $pagekey . "_rss.xml";
         if(file_exists($xmlfile)) {
             unlink($xmlfile);
         }
 
        $url = $this->url->create('rss');
        $this->response->redirect($url);
    }
    
    /**
    * Update RSS feed.
    *
    * @param $id of RSS feed to update.
    *
    * @return void
    */
    public function updateAction($id = null)
    {
        
        $this->users->denyAccessToPage('admin');
    
        $rss = $this->rss->find($id);
    
        $pagekey = $rss->getProperties()['pagekey'];
        $title = $rss->getProperties()['title'];
        $description = $rss->getProperties()['description'];
        $language = $rss->getProperties()['language'];
        $image_title = $rss->getProperties()['image_title'];
        $image_url = $rss->getProperties()['image_url'];
        $image_link = $rss->getProperties()['image_link'];
        $image_width = $rss->getProperties()['image_width'];
        $image_height = $rss->getProperties()['image_height'];
    
        $form = new \Anax\HTMLForm\CFormRssUpdate($id, $pagekey, $title, $description, $language, $image_title, $image_url, $image_link, $image_width, $image_height);
        $form->setDI($this->di);
        $status = $form->check();
    
        $this->di->theme->setTitle("Redigera RSS-flöde");
        $this->di->views->add('rss/update', [
                'title' => "Redigera RSS-flöde",
                'form' => "<h4>".$rss->getProperties()['title']." 
            (id ".$rss->getProperties()['id'].")</h4>".$form->getHTML()
            ]);
    }
    
    
    /* Add this code to the code when new content is added to update the xml file.
       Change file paths according to your application.
    
    $xmlfile = ANAX_APP_PATH . 'rss/' . $this->pagekey . "_rss.xml";
         if(file_exists($xmlfile)) {
             $rss = new \Anax\Rss\RssFeed();
             $rss->setDI($this->di);
             $xml = $rss->getFeed($this->pagekey);
             $fh = fopen($xmlfile, 'w') or die("can't open file");
             fwrite($fh, $xml);
             fclose($fh);
         }
    */
    
}