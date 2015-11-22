<?php

namespace Anax\HTMLForm;

/**
 * Anax base class for wrapping sessions.
 *
 */
class CFormRssAdd extends \Mos\HTMLForm\CForm
{
    use \Anax\DI\TInjectionaware,
        \Anax\MVC\TRedirectHelpers;

    /**
     * Constructor
     *
     */
    public function __construct($pagekey)
    {
        parent::__construct([], [
            
            'pagekey' => [
                'type'        => 'text',
                'label'       => 'Sidans nyckel (page key)',
                'required'    => true,
                'validation'  => ['not_empty'],
            ],
            
            'title' => [
                'type'        => 'text',
                'label'       => 'Titel',
                'required'    => true,
                'validation'  => ['not_empty'],
            ],
            'description' => [
                'type'        => 'text',
                'label'       => 'Beskrivning',
                'required'    => true,
                'validation'  => ['not_empty'],
            ],
            'language' => [
                'type'        => 'text',
                'label'       => 'Språk (t.ex. sv-se)',
                'required'    => false,
                'validation'  => [],
            ],
            'image_title' => [
                'type'        => 'text',
                'label'       => 'Bildtitel',
                'required'    => false,
                'validation'  => [],
            ],
            'image_url' => [
                'type'        => 'text',
                'label'       => 'URL till bilden',
                'required'    => false,
                'validation'  => ['web_adress'],
            ],
            'image_link' => [
                'type'        => 'text',
                'label'       => 'Bildlänk',
                'required'    => false,
                'validation'  => ['web_adress'],
            ],
            'image_width' => [
                'type'        => 'text',
                'label'       => 'Bildbredd',
                'required'    => false,
                'validation'  => [],
            ],
            'image_height' => [
                'type'        => 'text',
                'label'       => 'Bildhöjd',
                'required'    => false,
                'validation'  => [],
            ],
            'submit' => [
                'type'      => 'submit',
                'callback'  => [$this, 'callbackSubmit'],
                'value'     => 'Spara',
            ],
            
        ]);
    }



    /**
     * Customise the check() method.
     *
     * @param callable $callIfSuccess handler to call if function returns true.
     * @param callable $callIfFail    handler to call if function returns true.
     */
    public function check($callIfSuccess = null, $callIfFail = null)
    {
        return parent::check([$this, 'callbackSuccess'], [$this, 'callbackFail']);
    }



    /**
     * Callback for submit-button.
     *
     */
    public function callbackSubmit()
    {
        $this->rss = new \Anax\Rss\RssFeed();
        $this->rss->setDI($this->di);
        $saved = $this->rss->save(array('pagekey' => $this->Value('pagekey'), 'title' => $this->Value('title'), 'description' => $this->Value('description'), 'language' => $this->Value('language'), 'image_title' => $this->Value('image_title'), 'image_url' => $this->Value('image_url'), 'image_link' => $this->Value('image_link'), 'image_width' => $this->Value('image_width'), 'image_height' => $this->Value('image_height')));
    
       // $this->saveInSession = true;
        
        if($saved) 
        {
        return true;
        }
        else return false;
    }



    /**
     * Callback for submit-button.
     *
     */
    public function callbackSubmitFail()
    {
        $this->AddOutput("<p><i>DoSubmitFail(): Form was submitted but I failed to process/save/validate it</i></p>");
        return false;
    }



    /**
     * Callback What to do if the form was submitted?
     *
     */
    public function callbackSuccess()
    {
        $pagekey = $this->rss->getProperties()['pagekey'];
        $xml = $this->rss->getFeed($pagekey);
 
        $xmlfile = ANAX_APP_PATH . 'rss/' . $pagekey . "_rss.xml";
        $fh = fopen($xmlfile, 'w') or die("can't open file");
        fwrite($fh, $xml);
        fclose($fh);
       
        $this->redirectTo('rss/view/' . $pagekey);
    }


    /**
     * Callback What to do when form could not be processed?
     *
     */
    public function callbackFail()
    {
        $this->AddOutput("<p><i>Form was submitted and the Check() method returned false.</i></p>");
        $this->redirectTo();
    }
}
