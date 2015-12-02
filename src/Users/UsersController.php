<?php

namespace Anax\Users;
 
/**
 * A controller for users and admin related events.
 *
 */
class UsersController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;
    
    /**
    * Initialize the controller.
    *
    * @return void
    */
    public function initialize()
    {
        $this->users = new \Anax\Users\User();
        $this->users->setDI($this->di);
    }
    
    
    /**
    * List all users in admin page.
    *
    * @return void
    */
    public function listAction()
    {
        $this->users->denyAccessToPage('admin');
        
        $all = $this->users->findAll();
        $status = $this->users->IsAuthenticated();
 
        $this->theme->setTitle("Visa alla användare");
        $this->views->add('users/list-all', [
            'users' => $all,
            'title' => "Visa alla användare",
            'status' => $status,
        ], 'main');
        
        $this->views->add('users/users-sidebar', [], 'rsidebar');
     }
     
     /**
    * List all users on public page.
    *
    * @return void
    */
    public function listUsersAction()
    {
        $all = $this->users->findAll();
 
        $this->theme->setTitle("Alla användare");
        $this->views->add('users/list-users', [
            'users' => $all,
            'title' => "Alla användare",
        ], 'main');
     }
     
     /**
    * List user with id.
    *
    * @param int $id of user to display
    *
    * @return void
    */
    public function idAction($id = null)
    {
        $user = $this->users->find($id);
        $acronym = $user->acronym;
        
        $id = isset($id) ? $id : $_SESSION['user']->id;
        
        // Get questions asked
        $this->questions = new \Anax\Question\Question();
        $this->questions->setDI($this->di);
        $questions = $this->questions->findUserIdFromTable('question', $id);
        
        // Get answers given
        $this->answers = new \Anax\Answer\Answer();
        $this->answers->setDI($this->di);
        $answers = $this->answers->findUserIdFromTable('answer', $id);
        
        $redirect = $this->url->create('user/id/' . $id);
        
        $this->theme->setTitle($acronym);
        $this->views->add('users/view', [
            'user' => $user,
            'title' => $acronym,
        ]);
        
        $this->views->add('users/comments', [
            'user' => $user,
            'controller' => 'question',
            'title' => 'Ställda frågor',
            'comments' => $questions,
            'redirect' => $redirect,
        ], 'triptych-1');
        
        $this->views->add('users/comments', [
            'user' => $user,
            'controller' => 'answer',
            'title' => 'Besvarade frågor',
            'comments' => $answers,
            'redirect' => $redirect,
        ], 'triptych-2');
    }
    
    /**
     * list users sorted by column.
     *
     * @return void
     */
    public function userlistAction($orderby=null, $title=null, $limit=null)
    {
        $users = $this->users->findByColumn($orderby, $limit);
        
        $this->views->add('users/userlist', [
            'users' => $users,
            'title' => $title,
        ], 'rsidebar');
        
    }
    
    
    /**
    * Add new user.
    *
    *
    * @return void
    */
    public function addAction()
    {
        $form = new \Anax\HTMLForm\CFormUserAdd();
        $form->setDI($this->di);
        $status = $form->check();
        
        $this->theme->setTitle("Registrera ny användare");
        $this->views->add('users/add', [
            'title' => "Registrera ny användare",
            'form' => $form->GetHTML(),
            ]);   
    }
    
    /**
    * Delete user.
    *
    * @param integer $id of user to delete.
    *
    * @return void
    */
    public function deleteAction($id = null)
    {
        $this->users->denyAccessToPage('user', $id);
        
        if (!isset($id)) {
            die("Missing id");
        }
 
        $res = $this->users->delete($id);
        
        $this->users->logout();
        
        $url = $this->url->create('');
        $this->response->redirect($url);
    }
    
    
    /**
    * Delete (soft) user.
    *
    * @param integer $id of user to delete.
    *
    * @return void
    */
    public function softDeleteAction($id = null)
    {
        $this->users->denyAccessToPage('user', $id);
        
        if (!isset($id)) {
            die("Missing id");
        }
 
        $now = gmdate('Y-m-d H:i:s');
 
        $user = $this->users->find($id);
 
        $user->deleted = $now;
        $user->save();
 
        $url = $this->url->create('users');
        $this->response->redirect($url);
    }
    
    /**
    * Activate user.
    *
    * @param integer $id of user to activate.
    *
    * @return void
    */
    public function activateAction($id = null)
    {
        $this->users->denyAccessToPage('user', $id);
        
        if (!isset($id)) {
            die("Missing id");
        }
 
        $now = gmdate('Y-m-d H:i:s');
 
        $user = $this->users->find($id);
 
        $user->active = $now;
        $user->save();
 
        $url = $this->url->create('users/id/' . $id);
        $this->response->redirect($url);
    }
    
    /**
    * Inactivate user.
    *
    * @param integer $id of user to inactivate.
    *
    * @return void
    */
    public function inActivateAction($id = null)
    {
        $this->users->denyAccessToPage('user', $id);
        
        if (!isset($id)) {
            die("Missing id");
        }
 
        $user = $this->users->find($id);
 
        $user->active = null;
        $user->save();
 
        $url = $this->url->create('users/id/' . $id);
        $this->response->redirect($url);
    }
    
    /**
    * Restore (soft) deleted user.
    *
    * @param integer $id of user to restore.
    *
    * @return void
    */
    public function restoreAction($id = null)
    {
        $this->users->denyAccessToPage('user', $id);
        
        if (!isset($id)) {
            die("Missing id");
        }
        
        $now = gmdate('Y-m-d H:i:s');
        
        $user = $this->users->find($id);
 
        $user->deleted = null;
        $user->save();
 
        $url = $this->url->create('users/id/' . $id);
        $this->response->redirect($url);
    }
    
    /**
    * List all active and not deleted users.
    *
    * @return void
    */
    public function activeAction()
    {
        $this->users->denyAccessToPage('admin');
        
        $all = $this->users->query()
            ->where('active IS NOT NULL')
            ->andWhere('deleted is NULL')
            ->execute();
 
        $this->theme->setTitle("Aktiva användare");
        $this->views->add('users/list-all', [
            'users' => $all,
            'title' => "Aktiva användare",
            ]);
    }
    
    /**
    * List all inactive users.
    *
    * @return void
    */
    public function inActiveAction()
    {
        $this->users->denyAccessToPage('admin');
        
        $all = $this->users->query()
            ->where('active is NULL')
            ->execute();
 
        $this->theme->setTitle("Inaktiva användare");
        $this->views->add('users/list-all', [
            'users' => $all,
            'title' => "Inaktiva användare",
            ]);
    }
    
    /**
    * List all active and not deleted users.
    *
    * @return void
    */
    public function softDeletedAction()
    {
        $this->users->denyAccessToPage('admin');
        
        $all = $this->users->query()
            ->where('deleted IS NOT NULL')
            ->execute();
 
        $this->theme->setTitle("Användare i papperskorgen");
        $this->views->add('users/deleted', [
            'users' => $all,
            'title' => "Användare i papperskorgen",
            ]);
    }
    
    /**
    * Update user.
    *
    * @param $id of user to update.
    *
    * @return void
    */
    public function updateAction($id = null)
    {
        $this->users->denyAccessToPage('user', $id);
        
        $user = $this->users->find($id);
    
        $name = $user->getProperties()['name'];
        $acronym = $user->getProperties()['acronym'];
        $email = $user->getProperties()['email'];
        $web = $user->getProperties()['web'];
        $password = $user->getProperties()['password'];
        $active = $user->getProperties()['active'];
        $deleted = $user->getProperties()['deleted'];
        $created = $user->getProperties()['created'];
    
        $form = new \Anax\HTMLForm\CFormUserUpdate($id, $acronym, $name, $email, $web, $password, $active, $created);
        $form->setDI($this->di);
        $status = $form->check();
    
        $this->di->theme->setTitle("Redigera användare");
        $this->di->views->add('users/update', [
                'title' => "Redigera användare",
                'form' => "<h4>".$user->getProperties()['acronym']." 
            (id ".$user->getProperties()['id'].")</h4>".$form->getHTML()
            ]);
    }
    
    /**
    * Setup user table.
    *
    * @return void
    */
    public function setupAction()
    {
        
    $this->users->denyAccessToPage('admin');
    
    $this->db->setVerbose(false);
 
    $this->db->dropTableIfExists('user')->execute();
 
    $this->db->createTable(
        'user',
        [
            'id' => ['integer', 'primary key', 'not null', 'auto_increment'],
            'acronym' => ['varchar(20)', 'unique', 'not null'],
            'email' => ['varchar(80)'],
            'name' => ['varchar(80)'],
            'password' => ['varchar(255)'],
            'created' => ['datetime'],
            'updated' => ['datetime'],
            'deleted' => ['datetime'],
            'active' => ['datetime'],
        ]
    )->execute();
    
    $this->db->insert(
        'user',
        ['acronym', 'email', 'name', 'password', 'created', 'active']
    );
 
    $now = gmdate('Y-m-d H:i:s');
 
    $this->db->execute([
        'admin',
        'admin@dbwebb.se',
        'Administrator',
        password_hash('admin', PASSWORD_DEFAULT),
        $now,
        $now
    ]);
 
    $this->db->execute([
        'doe',
        'doe@dbwebb.se',
        'John/Jane Doe',
        password_hash('doe', PASSWORD_DEFAULT),
        $now,
        $now
    ]);
    
    $all = $this->users->findAll();
 
        $this->views->add('users/list-all', [
            'users' => $all,
            'title' => "Visa alla användare",
        ]);
    }
    
    
    /**
    * Check if user is logged in or not.
    *
    * @param int $id of user to display
    *
    * @return void
    */
    public function checkAction()
    {
        $id = isset($_SESSION['user']) ? $_SESSION['user']->id : null;
        $status = $this->users->IsAuthenticated();
        
        if($id) {
            
           $url = $this->url->create('users/id/'.$id);
           $this->response->redirect($url);
        }
        else {
           $url = $this->url->create('users/login');
           $this->response->redirect($url);
        }
        
    }
    
    /**
    * View a login form
    *
    *
    * @return void
    */
    public function loginAction()
    {
        $form = new \Anax\HTMLForm\CFormUserLogin();
        $form->setDI($this->di);
        $status = $form->check();
        
        $this->theme->setTitle("Logga in");
        $this->views->add('users/login', [
            'title' => "Logga in",
            'form' => $form->GetHTML(),
            ]);   
    }
    
    /**
    * Logout user and unset session
    *
    *
    * @return void
    */
    public function logoutAction()
    {
        $this->users->logout();
    }
    
    /**
    * Go to a message page and display the message
    *
    *
    * @return void
    */
    public function messageAction($message=null)
    {   
        $adminmessage = 'Du måste vara administratör för att komma in på den här sidan!';
        $wrongusermessage = 'Du har inte tillstånd att gå in på den här sidan!';
        $usermessage = "Du måste <a href='../login'>logga in</a> för att gå in på den här sidan!";
        $content = '';
        if($message == 'admin') {
            $content = $adminmessage;
        }
        else if($message == 'wronguser') {
            $content = $wrongusermessage;
        } else {
            $content = $usermessage;
        }
        
        $this->theme->setTitle("Meddelande");
        $this->views->add('default/error', [
            'title' => "Meddelande",
            'content' => $content,
            ]);   
    }
    

}