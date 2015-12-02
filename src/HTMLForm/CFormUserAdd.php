<?php

namespace Anax\HTMLForm;

/**
 * Anax base class for wrapping sessions.
 *
 */
class CFormUserAdd extends \Mos\HTMLForm\CForm
{
    use \Anax\DI\TInjectionaware,
        \Anax\MVC\TRedirectHelpers;



    /**
     * Constructor
     *
     */
    public function __construct()
    {
        parent::__construct([], [
            'acronym' => [
                'type'        => 'text',
                'label'       => 'Användarnamn',
                'required'    => true,
                'validation'  => array('not_empty', 'custom_test' => array(
                    'message' => 'Användarnamnet är redan taget.', 
                    'test' => function ($value) {
                        $this->user = new \Anax\Users\User();
                        $this->user->setDI($this->di);
                        $users = $this->user->findAll();
                        foreach ($users as $user) {
                            $acronym = $user->acronym;
                            if($acronym == $value) {
                                return false;
                            }
                        }
                    }),
                ),
            ],
            'name' => [
                'type'        => 'text',
                'label'       => 'Namn',
                'required'    => true,
                'validation'  => ['not_empty'],
            ],
            'email' => [
                'type'        => 'text',
                'label'       => 'E-post',
                'required'    => true,
                'validation'  => ['not_empty', 'email_adress'],
            ],
            
            'web' => [
                'type'        => 'text',
                'label'       => 'Hemsida',
                'validation'  => ['web_adress'],
            ],  
            
            'password' => [
                'type'        => 'password',
                'label'       => 'Välj lösenord',
                'required'    => true,
                'validation'  => ['not_empty'],
            ],
            
            'password2' => [
                'type'        => 'password',
                'label'       => 'Upprepa lösenord',
                'required'    => true,
                'validation'  => ['not_empty', 'match' =>
                    'password'],
            ],
            
            'active' => [
                'type'        => 'checkbox',
                'label'       => 'Aktivera',
                'checked'     => false,
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
        
        $now = gmdate('Y-m-d H:i:s');
        $active = !empty($_POST['active'])?$now:null;
        $web = !empty($_POST['web']) ? $this->Value('web') : '';

        $this->newuser = new \Anax\Users\User();
        $this->newuser->setDI($this->di);
        $saved = $this->newuser->save(array('acronym' => $this->Value('acronym'), 'email' => $this->Value('email'), 'name' => $this->Value('name'), 'web' => $this->Value('web'), 'password' => password_hash($this->Value('password'),PASSWORD_DEFAULT), 'created' => $now, 'updated' => $now, 'deleted' => null, 'active' => $active, 'gravatar' => 'http://www.gravatar.com/avatar/' . md5(strtolower(trim($this->Value('email')))) . '.jpg'));
    
       // $this->saveInSession = true;
        
        if($saved) 
        {
        return true;
        }
        else {
            return false;
        }
    }



    /**
     * Callback for submit-button.
     *
     */
    public function callbackSubmitFail()
    {
        $this->AddOutput("<p><i>Formuläret fylldes inte i korrekt.</i></p>");
        return false;
    }



    /**
     * Callback What to do if the form was submitted?
     *
     */
    public function callbackSuccess()
    {   
         //login the created user and redirect to profile page
         $this->redirectTo('users/login');
    }


    /**
     * Callback What to do when form could not be processed?
     *
     */
    public function callbackFail()
    {
        $this->AddOutput("<p><i>Formuläret fylldes inte i korrekt.</i></p>");
        $this->redirectTo();
    }
}
