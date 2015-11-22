<?php

namespace Anax\HTMLForm;

/**
 * Form to add comment
 *
 */
class CFormCommentAdd extends \Mos\HTMLForm\CForm
{
    use \Anax\DI\TInjectionaware,
        \Anax\MVC\TRedirectHelpers;

    private $pagekey;
    private $redirect;
    private $id;
    private $acronym;

    /**
     * Constructor
     *
     */
    public function __construct($pagekey, $redirect)
    {
        parent::__construct([], [
            
            'content' => [
                'type'        => 'textarea',
                'label'       => 'Kommentar',
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
            
        ]);
        
        $this->pagekey = $pagekey;
        $this->redirect = $redirect;
        $this->id = $_SESSION['user']->id;
        $this->acronym = $_SESSION['user']->acronym;
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
        
        $now = date('Y-m-d H:i:s');
        
        $this->user = new \Anax\Users\User();
        $this->user->setDI($this->di);
        $user = $this->user->find($this->id);
        
        $name = $user->getProperties()['name'];
        $email = $user->getProperties()['email'];
        $web = $user->getProperties()['web'];
        $userid = $user->getProperties()['id'];
        $xp = $user->getProperties()['xp'];
        
        $this->question = new \Anax\Question\Question();
        $this->question->setDI($this->di);
        $question = $this->question->findQuestion(null,$this->pagekey);
        $comments = $question[0]->getProperties()['comments'];
        $this->question->customUpdate('question', array('comments' => ($comments + 1)), 'id = '.$this->pagekey);
        
        $this->newcomment = new \Phpmvc\Comment\Comment();
        $this->newcomment->setDI($this->di);
        $saved = $this->newcomment->save(array('content' => $this->Value('content'), 'mail' => $email, 'name' => $name, 'userid' => $userid, 'web' => $web, 'pagekey' => $this->pagekey, 'timestamp' => $now, 'ip' => $this->di->request->getServer('REMOTE_ADDR'), 'gravatar' => 'http://www.gravatar.com/avatar/' . md5(strtolower(trim($email))) . '.jpg'));
        
       // $this->saveInSession = true;
        
        if($saved) 
        {
            $user->update(array('xp' => ($xp + 1)));
            return true;
        }
            else return false;
    }

     /**
     * Callback reset
     *
     */
    public function callbackReset()
    {
         $this->redirectTo($this->redirect);
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
         $xmlfile = ANAX_APP_PATH . 'rss/' . $this->pagekey . "_rss.xml";
         if(file_exists($xmlfile)) {
             $rss = new \Anax\Rss\RssFeed();
             $rss->setDI($this->di);
             $xml = $rss->getFeed($this->pagekey);
             $fh = fopen($xmlfile, 'w') or die("can't open file");
             fwrite($fh, $xml);
             fclose($fh);
         }
        
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