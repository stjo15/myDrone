<?php

namespace Anax\Users;
 
/**
 * Model for Users.
 *
 */
class User extends \Anax\MVC\CDatabaseModel
{
    
    // Check if user is authenticated.
    public function IsAuthenticated() {

        $acronym = isset($_SESSION['user']) ? $_SESSION['user']->acronym : null;
 
        if($acronym) {
            $output = "Du är inloggad som: $acronym ({$_SESSION['user']->name})";
        }
        else {
            $output = "Du är INTE inloggad.";
        }
        return $output;
    }
    
    
    /**
  Function to verify user and password.
  */
  
    public function login() {

      // Check if user and password is okey
      if(isset($_POST['login'])) {
          $sql = "SELECT acronym, name, id FROM kmom10_users WHERE acronym = ? AND password = ?";
          $sth = $this->db->prepare($sql);
          $sth->execute(array($_POST['acronym'], $_POST['password']));
          $res = $sth->fetchAll();
          if(isset($res[0])) {
              $_SESSION['user'] = $res[0];
          }
      }
    }
    
    /**
    Function to logut the user.
    */
  
    public function logout() {
        // Logout the user
            unset($_SESSION['user']);
            header('Location: ' . $this->url->create('users/login'));
    }
    
    /**
    * Function to create a login link.
    */
   
    public function getLoginLink() {
        
        $acronym = isset($_SESSION['user']) ? $_SESSION['user']->acronym : null;
       
        if($acronym) {
           
            $loginLink = "<span class='loginacronym'>" . $acronym . "</span><a href='". $this->url->create('users/logout')."' title='Logga ut'><i class='fa fa-sign-out fa-2x'></i></a>";
        }
        else {
            $loginLink = "<a href='". $this->url->create('users/login')."' title='Logga in'><i class='fa fa-sign-in fa-2x'></i>
</a>";
        }
       
        return $loginLink;
       
    }
    
    /**
    * Function to block access to page with die and redirect to login page if the user is not authenticated.
    */
   
    public function denyAccessToPage($usertype = null, $id = null) {
        
        if($usertype == 'admin' && isset($_SESSION['user'])) {
            $isadmin = $_SESSION['user']->acronym == 'admin' ? true : null;
            if(!isset($isadmin)) {
                header('Location: ' . $this->url->create('users/message/admin'));
                die("Du måste vara administratör för att komma in på den här sidan!");
            }
        }
        
        if($usertype == 'user' && isset($_SESSION['user'])) {
            $id = $_SESSION['user']->id == $id ? $_SESSION['user']->id : null;
            if(!isset($id)) {
                header('Location: ' . $this->url->create('users/message/wronguser'));
                die("Du har inte tillstånd att gå in på den här sidan!");
            }
        } else {
        
            $acronym = isset($_SESSION['user']) ? $_SESSION['user']->acronym : null;
            if(!isset($acronym)) {
                header('Location: ' . $this->url->create('users/message/user'));
                die("Du måste <a href='login'>logga in</a> för att gå in på den här sidan!");
            }
        }
    }
    
    public function findByColumn($orderby='questions DESC', $limit=null)
    {
        if(isset($limit)) {
            $all = $this->query()
                ->orderBy($orderby)
                ->limit($limit)
                
                ->execute();
        
            return $all;
        } else {
            $all = $this->query()
                ->orderBy($orderby)
                
                ->execute();
        
            return $all;
        }
            
    }
    
    public function findByAcronym($acronym)
    {
        $user = $this->query()
                ->where('acronym = ?')
                ->execute([$acronym]);
                
            return $user;
    }
  
}