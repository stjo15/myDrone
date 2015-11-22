<?php

$form = new \Mos\HTMLForm\CForm();

$form = $form->create([], [
        'name' => [
            'type'        => 'text',
            'label'       => 'Name of contact person:',
            'required'    => true,
            'validation'  => ['not_empty'],
        ],
        'email' => [
            'type'        => 'text',
            'required'    => true,
            'validation'  => ['not_empty', 'email_adress'],
        ],
        'phone' => [
            'type'        => 'text',
            'required'    => true,
            'validation'  => ['not_empty', 'numeric'],
        ],
        'submit' => [
            'type'      => 'submit',
            'callback'  => function ($form) {
                $form->AddOutput("<p><i>DoSubmit(): Form was submitted. Do stuff (save to database) and return true (success) or false (failed processing form)</i></p>");
                $form->AddOutput("<p><b>Name: " . $form->Value('name') . "</b></p>");
                $form->AddOutput("<p><b>Email: " . $form->Value('email') . "</b></p>");
                $form->AddOutput("<p><b>Phone: " . $form->Value('phone') . "</b></p>");
                $form->saveInSession = true;
                return true;
            }
        ],
        'submit-fail' => [
            'type'      => 'submit',
            'callback'  => function ($form) {
                $form->AddOutput("<p><i>DoSubmitFail(): Form was submitted but I failed to process/save/validate it</i></p>");
                return false;
            }
        ],
        
    ]);

 // Check the status of the form
    $status = $form->check();
 
    if ($status === true) {
 
        // What to do if the form was submitted?
        $form->AddOUtput("<p><i>Form was submitted and the callback method returned true.</i></p>");
        header("Location: " . $_SERVER['PHP_SELF']);
 
    } else if ($status === false) {
 
        // What to do when form could not be processed?
        $form->AddOutput("<p><i>Form was submitted and the Check() method returned false.</i></p>");
        header("Location: " . $_SERVER['PHP_SELF']);
    }
    
    echo $form->getHTML();