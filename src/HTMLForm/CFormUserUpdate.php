<?php

namespace Anax\HTMLForm;

/**
 * Anax base class for wrapping sessions.
 *
 */
class CFormUserUpdate extends \Mos\HTMLForm\CForm
{
    use \Anax\DI\TInjectionaware,
        \Anax\MVC\TRedirectHelpers;

    private $user;
    private $id;
    private $acronym; 
    private $password; 
    private $activedate;
    
    /**
     * Constructor
     *
     */
    public function __construct($id=null, $acronym='',$name='',$email='', $web='', $password='', $activedate=null)
    {
    $activecheck = ($activedate == null) ? false : true;
        
        parent::__construct([], [
            
            'name' => [
                'type'        => 'text',
                'label'       => 'Namn',
                'required'    => true,
                'validation'  => ['not_empty'],
                'value'       => $name,
            ],
            'email' => [
                'type'        => 'text',
                'label'       => 'E-post',
                'required'    => true,
                'validation'  => ['not_empty', 'email_adress'],
                'value'       => $email,
            ],
            
            'web' => [
                'type'        => 'text',
                'label'       => 'Hemsida',
                'validation'  => ['web_adress'],
            ],  
            
            'password' => [
                'type'        => 'password',
                'label'       => 'Nuvarande lösenord',
                'required'    => true,
                'validation'  => ['not_empty'],
            ],
            
            'newpassword' => [
                'type'        => 'password',
                'label'       => 'Välj ett nytt lösenord',
                'required'    => false,
            ],
            
            'newpassword2' => [
                'type'        => 'password',
                'label'       => 'Upprepa nytt lösenord',
                'required'    => false,
                'validation'  => ['match' =>
                    'newpassword'],
            ],
            
            'active' => [
                'type'        => 'checkbox',
                'label'       => 'Aktivera',
                'checked'     => $activecheck,
            ],  
            
            'submit' => [
                'type'      => 'submit',
                'callback'  => [$this, 'callbackSubmit'],
                'value'     => 'Spara',
            ],
            'submit-delete' => [
                'type'      => 'submit',
                'callback'  => [$this, 'callbackSubmitDelete'],
                'value'     => 'Ta bort',
            ],
        ]);
        
        $this->id = $id;
        $this->acronym = $acronym;
        $this->password = $password; 
        $this->activedate = $activedate;
        
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
        $valid = password_verify($this->Value('password'), $this->password);
        if($valid) {
            $password = empty($this->Value('newpassword')) ? $this->password : password_hash($this->Value('newpassword'), PASSWORD_DEFAULT);
        } else {
            return false; 
        }
        $now = gmdate('Y-m-d H:i:s');
        
        if ($this->activedate == null && !empty($_POST['active'])) {
        $this->activedate = $now;
        }
        else if ($this->activedate != null && empty($_POST['active'])) {
        $this->activedate = null;
        }
        
        $web = !empty($_POST['web']) ? $this->Value('web') : '';
        
        $this->user = new \Anax\Users\User();
        $this->user->setDI($this->di);
        
        $saved = $this->user->save(array('id' => $this->id, 'acronym' => $this->acronym, 'email' => $this->Value('email'), 'name' => $this->Value('name'), 'web' => $web, 'password' => $password, 'created' => $now, 'updated' => $now, 'deleted' => null, 'active' => $this->activedate, 'gravatar' => 'http://www.gravatar.com/avatar/' . md5(strtolower(trim($this->Value('email')))) . '.jpg'));
    
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
    
        //$this->user = new \Anax\Users\User();
        //$this->user->setDI($this->di);
        
        $this->redirectTo('users/soft-delete/' . $this->id);
        return false;
    }



    /**
     * Callback What to do if the form was submitted?
     *
     */
    public function callbackSuccess()
    {
         $this->redirectTo('users/id/' . $this->user->getProperties()['id']);
    }


    /**
     * Callback What to do when form could not be processed?
     *
     */
    public function callbackFail()
    {
        $this->AddOutput("<p><i>Formuläret har fyllts i felaktigt.</i></p>");
        $this->redirectTo();
    }
}
