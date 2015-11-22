<?php

namespace Anax\HTMLForm;

/**
 * Anax base class for wrapping sessions.
 *
 */
class CFormRssUpdate extends \Mos\HTMLForm\CForm
{
    use \Anax\DI\TInjectionaware,
        \Anax\MVC\TRedirectHelpers;

    private $pagekey;
    private $id;
    private $title; 
    private $description;
    
    /**
     * Constructor
     *
     */
    public function __construct($id=null, $pagekey=null, $title=null, $description=null, $language='', $image_title='', $image_url='', $image_link='', $image_width='', $image_height='')
    {
        
        parent::__construct([], [
            
            'pagekey' => [
                'type'        => 'text',
                'label'       => 'Sidans nyckel (page key)',
                'required'    => true,
                'validation'  => ['not_empty'],
                'value'       => $pagekey,
            ],
            
            'title' => [
                'type'        => 'text',
                'label'       => 'Titel',
                'required'    => true,
                'validation'  => ['not_empty'],
                'value'       => $title,
            ],
            'description' => [
                'type'        => 'text',
                'label'       => 'Beskrivning',
                'required'    => true,
                'validation'  => ['not_empty'],
                'value'       => $description,
            ],
            'language' => [
                'type'        => 'text',
                'label'       => 'Språk (t.ex. sv-se)',
                'required'    => false,
                'validation'  => [],
                'value'       => $language,
            ],
            'image_title' => [
                'type'        => 'text',
                'label'       => 'Bildtitel',
                'required'    => false,
                'validation'  => [],
                'value'       => $image_title,
            ],
            'image_url' => [
                'type'        => 'text',
                'label'       => 'URL till bilden',
                'required'    => false,
                'validation'  => ['web_adress'],
                'value'       => $image_url,
            ],
            'image_link' => [
                'type'        => 'text',
                'label'       => 'Bildlänk',
                'required'    => false,
                'validation'  => ['web_adress'],
                'value'       => $image_link,
            ],
            'image_width' => [
                'type'        => 'text',
                'label'       => 'Bildbredd',
                'required'    => false,
                'validation'  => [],
                'value'       => $image_width,
            ],
            'image_height' => [
                'type'        => 'text',
                'label'       => 'Bildhöjd',
                'required'    => false,
                'validation'  => [],
                'value'       => $image_height,
            ],
            'submit' => [
                'type'      => 'submit',
                'callback'  => [$this, 'callbackSubmit'],
                'value'     => 'Spara',
            ],
        ]);
        
        $this->id = $id;
        $this->pagekey = $pagekey;
        $this->title = $title; 
        $this->description =$description;
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
        $saved = $this->rss->save(array('id' => $this->id, 'pagekey' => $this->Value('pagekey'), 'title' => $this->Value('title'), 'description' => $this->Value('description'), 'language' => $this->Value('language'), 'image_title' => $this->Value('image_title'), 'image_url' => $this->Value('image_url'), 'image_link' => $this->Value('image_link'), 'image_width' => $this->Value('image_width'), 'image_height' => $this->Value('image_height')));
       
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
    public function callbackSubmitDelete()
    {
        $this->redirectTo('rss');
        return false;
    }



    /**
     * Callback What to do if the form was submitted?
     *
     */
    public function callbackSuccess()
    {
         $this->redirectTo('rss');
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
