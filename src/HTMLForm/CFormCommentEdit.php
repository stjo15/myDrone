<?php

namespace Anax\HTMLForm;

/**
 * Form to edit comment
 *
 */
class CFormCommentEdit extends \Mos\HTMLForm\CForm
{
    use \Anax\DI\TInjectionaware,
        \Anax\MVC\TRedirectHelpers;

    private $id;
    private $redirect;
    private $pagekey;
    private $user;

    /**
     * Constructor
     *
     */
    public function __construct($id, $content, $name, $web, $mail, $pagekey, $redirect)
    {
        parent::__construct([], [
            
            'content' => [
                'type'        => 'textarea',
                'label'       => 'Kommentar',
                'value'       =>  $content,
                'required'    => true,
                'validation'  => ['not_empty'],
            ],
            'submit' => [
                'type'      => 'submit',
                'callback'  => [$this, 'callbackSubmit'],
                'value'     => 'Spara',
            ],
            'reset' => [
                'type'      => 'reset',
                'value'     => 'Återställ',
            ],
            
            'delete' => [
                'type'      => 'submit',
                'callback'  => [$this, 'callbackDelete'],
                'value'     => 'Radera',
            ],
            
        ]);
        
        $this->id = $id;
        $this->redirect = $redirect;
        $this->pagekey = $pagekey;
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
     * Callback for submit button.
     *
     */
    public function callbackSubmit()
    {

        $now = date('Y-m-d H:i:s');
        
        $this->user = new \Anax\Users\User();
        $this->user->setDI($this->di);
        $user = $this->user->find($_SESSION['user']->id);
        
        $name = $user->getProperties()['name'];
        $email = $user->getProperties()['email'];
        $web = $user->getProperties()['web'];
        
        $this->comment = new \Phpmvc\Comment\Comment();
        $this->comment->setDI($this->di);
        $saved = $this->comment->save(array('id' => $this->id, 'content' => $this->Value('content'), 'mail' => $email, 'name' => $name, 'web' => $web, 'updated' => $now, 'ip' => $this->di->request->getServer('REMOTE_ADDR'), 'gravatar' => 'http://www.gravatar.com/avatar/' . md5(strtolower(trim($email))) . '.jpg'));
        
        
        
    //$this->saveInSession = true;
        
        if($saved) 
        {
        return true;
        }
        else return false;
    }
    
    public function callbackDelete()
    {
        $this->comment = new \Phpmvc\Comment\Comment();
        $this->comment->setDI($this->di);
        
        $deleted = $this->comment->delete($this->id);
        
        $this->question = new \Anax\Question\Question();
        $this->question->setDI($this->di);
        $question = $this->question->findQuestion(null,$this->pagekey);
        $comments = $question[0]->getProperties()['comments'];
        $this->question->customUpdate('question', array('comments' => ($comments - 1)), 'id = '.$this->pagekey);
        
        if($deleted) 
        {
            $user = new \Anax\Users\User();
            $user->setDI($this->di);
            $user = $user->find($_SESSION['user']->id);
            $xp = $user->getProperties()['xp'];
            $user->update(array('xp' => ($xp - 2)));
            return true;
        }
            else return false;
        
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
        $this->AddOutput("<p><i>Form was submitted and the Check() method returned false.</i></p>");
        
    }
}