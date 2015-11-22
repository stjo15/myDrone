<?php

namespace Anax\HTMLForm;

/**
 * Form to add comment
 *
 */
class CFormCommentButton extends \Mos\HTMLForm\CForm
{
    use \Anax\DI\TInjectionaware,
        \Anax\MVC\TRedirectHelpers;

    private $redirect;
    private $comment = true;

    /**
     * Constructor
     *
     */
    public function __construct($redirect)
    {
        parent::__construct([], [
            
            'submitted' => [
                'type'  => 'hidden',
                'value' => 'submitted',
            ],
            
            'comment' => [
                'type'      => 'submit',
                'callback'  => [$this, 'callbackComment'],
                'value'     => 'Kommentera',
            ],

            
        ]);
        
        $this->redirect = $redirect;
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
    public function callbackComment()
    {
        if ($this->Value('submitted')=='submitted') {
         
        $this->comment = true;
        
        return true;
        }
    }


    /**
     * Callback What to do if the form was submitted?
     *
     */
    public function callbackSuccess()
    {   
        $this->redirectTo($this->redirect);
    }


    /**
     * Callback What to do when form could not be processed?
     *
     */
    public function callbackFail()
    {   
        return false;
        $this->AddOutput("<p><i>Form was submitted and the Check() method returned false.</i></p>");
        //$this->redirectTo('comments/edit');
    }
    
    /**
     * Get comment property.
     *
     */
    public function getComment()
    {   
        return $this->comment;
    }
    
}