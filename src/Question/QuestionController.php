<?php

namespace Anax\Question;

/**
 * To attach comments-flow to a page or some content.
 *
 */
class QuestionController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;

    private $errormessage;
    
    /**
    * Initialize the controller.
    *
    * @return void
    */
    public function initialize()
    {
        $this->question = new \Anax\Question\Question();
        $this->question->setDI($this->di);
        
        $this->users = new \Anax\Users\User();
        $this->users->setDI($this->di);
    }
    
    /**
     * Add a question with CForm.
     *
     * @return void
     */
    public function addAction($redirect='question')
    {
        $undourl = '<p><a href="'.$this->di->get('url')->create($redirect).'">Ångra</p>';
        
        $formundo = new \Anax\HTMLForm\CFormCommentUndo($redirect);
        $formundo->setDI($this->di);
        $formundo->check();
        $undourl = $formundo->getHTML();
        
        
        $url = $this->url->create('users/login');
        
        if(isset($_SESSION['user'])) {
            
            $form = new \Anax\HTMLForm\CFormQuestionAdd($redirect);
            $form->setDI($this->di);
            $form->check();
            
            $this->theme->setTitle('Skriv en fråga');
            $this->di->views->add('question/addform', [
                'title' => "Skriv en fråga",
                'content' => $form->getHTML().$undourl,
            ]);
        } else {
            $this->di->views->add('default/link', [
                'anchor' => "Logga in för att ställa en fråga",
                'url' => $url, 
            ]);
        }
    }
    
    
    /**
     * View all questions.
     *
     * @return void
     */
    public function listAction($tagslug=null, $orderby='timestamp DESC', $redirect=null, $header='Frågor enligt kategori', $limit=null)
    {
        $redirect = $this->url->create('question/list');
        
        $controller = 'question';
        
        if(isset($limit)) {
            $all = $this->question->findAllLimit($tagslug, $orderby, $limit);
        } else {
            $all = $this->question->findAll($tagslug, $orderby);
        }
        
        $title = isset($tagslug) ? ucfirst($tagslug) : 'Frågor';
        $this->theme->setTitle($title);
        
        $this->views->add('question/questions', [
            'questions' => $all,
            'redirect'  => $redirect,
            'controller' => $controller,
            'tagslug' => $tagslug,
            'title' => $header,
        ]);
        
        $this->views->add('question/sidebar', [], 'rsidebar');
        
    }
    
    /**
     * View a question with id.
     *
     * @return void
     */
    public function viewAction($id, $redirect=null)
    {
        $redirect = $this->url->create('question/view/' . $id);
        $controller = 'question';
        
        $question = $this->question->findQuestion(null,$id);
        
        $this->theme->setTitle('Fråga ' . $id);
        
        $this->views->add('question/question', [
            'questions' => $question,
            'redirect'  => $redirect,
            'controller' => $controller,
        ]);
        
        $this->dispatcher->forward([
             'controller' => 'answer',
             'action'     => 'view',
             'params'     => [$id, 'question/view/'.$id],
        ]);
        
        $answerurl = $this->url->create('answer/add/'.$id.'/question/view/'.$id);
        $this->di->views->add('default/link', [
                'anchor' => "Svara på frågan",
                'url' => $answerurl, 
            ]);
        
        $this->dispatcher->forward([
             'controller' => 'comment',
             'action'     => 'view',
             'params'     => [$id, 'question/view/'.$id, 'triptych-2'],
        ]);
        
        $commenturl = $this->url->create('comment/add/'.$id.'/question/view/'.$id);
        $this->di->views->add('default/link', [
                'anchor' => "Kommentera frågan",
                'url' => $commenturl, 
            ]);
       
    }
    
    /**
    *
    * Edit a question
    *
    * @param $id selects the question to edit.
    *
    */      
    public function editAction($id, $redirect='')
    {
        $redirect = $this->url->create('question/view/' . $id);
        
        $formundo = new \Anax\HTMLForm\CFormCommentUndo($redirect);
        $formundo->setDI($this->di);
        $formundo->check();
        $undourl = $formundo->getHTML();
        
        $controller = 'question';
        
        $question = $this->question->findQuestion(null, $id);
        $question = (is_object($question[0])) ? get_object_vars($question[0]) : $question;
        
        if($_SESSION['user']->name != $question['name']) {
                header('Location: ' . $this->url->create('users/message/wronguser'));
                die("Du har inte tillstånd att gå in på den här sidan!");
            }
        
        $form = new \Anax\HTMLForm\CFormQuestionEdit($id, $question['tag'], $question['tagslug'], $question['title'], $question['userid'], $question['content'], $redirect);
        $form->setDI($this->di);
        $form->check();
        
        $this->theme->setTitle("Redigera fråga");
        
        $this->di->views->add('default/page', [
        'title' => "Redigera fråga",
        'content' => '<h4>Fråga #'.$id.'</h4>'.$form->getHTML().$undourl, 
        ], 'main');
        
    }
    
    /**
     * View all tags in ordered list.
     *
     * @return void
     */
    public function taglistAction($orderby=null, $title=null, $limit=null)
    {
        $this->tag = new \Anax\Question\Tag();
        $this->tag->setDI($this->di);
        
        $tags = $this->tag->findAll($orderby, $limit);
        
        $this->views->add('question/taglist', [
            'tags' => $tags,
            'title' => $title,
        ], 'rsidebar');
        
    }
    
    /**
     * View all tags in page.
     *
     * @return void
     */
    public function listTagsAction($orderby='questions DESC', $limit=100)
    {
        $this->tag = new \Anax\Question\Tag();
        $this->tag->setDI($this->di);
        
        $tags = $this->tag->findAll($orderby, $limit);
        $title = 'Alla kategorier';
        
        $this->theme->setTitle("Alla kategorier");
        
        $this->views->add('question/list-all-tags', [
            'tags' => $tags,
            'title' => $title,
        ], 'main');
        
    }
    
    
}