<?php

namespace Anax\HTMLForm;

/**
 * Form to edit question
 *
 */
class CFormQuestionEdit extends \Mos\HTMLForm\CForm
{
    use \Anax\DI\TInjectionaware,
        \Anax\MVC\TRedirectHelpers;

    private $id; 
    private $userid;
    private $acronym;
    private $redirect;
    private $tag;
    private $tagslug;
    private $user;

    /**
     * Constructor
     *
     */
    public function __construct($id, $tag, $tagslug, $title, $userid, $content, $redirect)
    {
        parent::__construct([], [
            
            'tag' => array(
                'type'        => 'checkbox-multiple',
                'label'       => 'Kategori',
                'required'    => true,
                'values'     => array(
                        'Programmering',
                        'Flygning',
                        'Inköp',
                        'Design',
                        'Lagar och regler',
                        'Användning',
                        'Allmänt'
                        ),
            ),
            'title' => [
                'type'        => 'text',
                'label'       => 'Frågans titel',
                'value'       => $title,
                'required'    => true,
                'validation'  => ['not_empty'],
            ],
            'content' => [
                'type'        => 'textarea',
                'label'       => 'Beskrivning',
                'value'       => $content,
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
        
        $this->redirect = $redirect;
        $this->id = $id;
        $this->userid = $userid;
        $this->acronym = $_SESSION['user']->acronym;
        $this->tag = $tag;
        $this->tagslug = $tagslug;
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
        $this->user = $this->user->find($this->userid);
        
        $name = $this->user->getProperties()['name'];
        $email = $this->user->getProperties()['email'];
        $web = $this->user->getProperties()['web'];
        
        $tags = '';
        $tagslugs = '';
        if(isset($_POST['tag'])) {
                foreach($_POST['tag'] as $key => $val) {
                    $slug = slugify($val);
                    $tagslugs .= $slug . ',';
                    $tags .= $val . ',';
                    // Update total number of tags
                    $this->tag = new \Anax\Question\Tag();
                    $this->tag->setDI($this->di);
                    $tag = $this->tag->findTag($slug);
                    $questions = $tag[0]->getProperties()['questions'];
                    $tagid = $tag[0]->getProperties()['id'];
                    $this->tag->customUpdate('tag', array('questions' => ($questions + 1)), 'id = '. $tagid);
                    // Remove 1 from old data
                    $oldtags = explode(',', $this->tagslug);
                    foreach($oldtags as $key => $val) { 
                        $tag = $this->tag->findTag($val);
                        $questions = $tag[0]->getProperties()['questions'];
                        $tagid = $tag[0]->getProperties()['id'];
                        $this->tag->customUpdate('tag', array('questions' => ($questions - 1)), 'id = '. $tagid);
                    }
                }
                $tags = rtrim($tags, ',');
                $tagslugs = rtrim($tagslugs, ',');
        }
        $tags = empty($tags) ? $this->tag : $tags;
        $tagslugs = empty($tagslugs) ? $this->tagslug : $tagslugs;
        
        $this->question = new \Anax\Question\Question();
        $this->question->setDI($this->di);
        $saved = $this->question->save(array('id' => $this->id, 'tag' => $tags, 'tagslug' => $tagslugs, 'title' => $this->Value('title'), 'content' => $this->Value('content'), 'mail' => $email, 'name' => $name, 'web' => $web, 'timestamp' => $now, 'ip' => $this->di->request->getServer('REMOTE_ADDR'), 'gravatar' => 'http://www.gravatar.com/avatar/' . md5(strtolower(trim($email))) . '.jpg'));
        
    //$this->saveInSession = true;
        
        if($saved) 
        {
        return true;
        }
        else return false;
    }
    
    public function callbackDelete()
    {
        $this->question = new \Anax\Question\Question();
        $this->question->setDI($this->di);
        
        $deleted = $this->question->delete($this->id);
        
        if($deleted) 
        {
            $this->redirect = 'question';
            // Also delete all comments and answers related to this question
            $this->answer = new \Anax\Answer\Answer();
            $this->answer->setDI($this->di);
            $answers = $this->answer->findAll($this->id);
            var_dump($answers);
            foreach($answers as $id => $answer) {
                $this->answer->delete($answer->id);
            }
            
            $this->comment = new \Phpmvc\Comment\Comment();
            $this->comment->setDI($this->di);
            $comments = $this->comment->findAll($this->id);
            foreach($comments as $id => $comment) {
                $this->comment->delete($comment->id);
            }
            
            // Update User reputation
            $user = new \Anax\Users\User();
            $user->setDI($this->di);
            $user = $user->find($_SESSION['user']->id);
            $xp = $user->getProperties()['xp'];
            $user->update(array('xp' => ($xp - 5)));
            
            // Update number of tags
            $oldtags = explode(',', $this->tagslug);
            $this->tag = new \Anax\Question\Tag();
            $this->tag->setDI($this->di);
            foreach($oldtags as $key => $val) { 
                $tag = $this->tag->findTag($val);
                $questions = $tag[0]->getProperties()['questions'];
                $tagid = $tag[0]->getProperties()['id'];
                $this->tag->customUpdate('tag', array('questions' => ($questions - 1)), 'id = '. $tagid);
            }
                    
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