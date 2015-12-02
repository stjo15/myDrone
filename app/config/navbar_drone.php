<?php
/**
 * Config-file for navigation bar.
 *
 */
return [

    // Use for styling the menu
    'class' => 'navbar',
 
    // Here comes the menu strcture
    'items' => [

        // This is a menu item
        'hem'  => [
            'text'  => 'Terminal',
            'url'   => $this->di->get('url')->create(''),
            'title' => ''
        ],
        
        // This is a menu item
        'question'  => [
            'text'  => 'Frågeportal',
            'url'   => $this->di->get('url')->create('question'),
            'title' => '',
            
            // Add sub menu
            'submenu' => [

                'items' => [

                    // This is a menu item of the submenu
                    'programming'  => [
                        'text'  => 'Programmering',
                        'url'   => $this->di->get('url')->create('question/list/programmering'),
                        'title' => ''
                    ],
                    
                    // This is a menu item of the submenu
                    'piloting'  => [
                        'text'  => 'Flygning',
                        'url'   => $this->di->get('url')->create('question/list/flygning'),
                        'title' => ''
                    ],
                    
                    // This is a menu item of the submenu
                    'purchase'  => [
                        'text'  => 'Inköp',
                        'url'   => $this->di->get('url')->create('question/list/inkop'),
                        'title' => ''
                    ],
                    
                    // This is a menu item of the submenu
                    'design'  => [
                        'text'  => 'Design',
                        'url'   => $this->di->get('url')->create('question/list/design'),
                        'title' => ''
                    ],
                    
                    // This is a menu item of the submenu
                    'laws'  => [
                        'text'  => 'Lagar och regler',
                        'url'   => $this->di->get('url')->create('question/list/lagar'),
                        'title' => ''
                    ],
                    
                    // This is a menu item of the submenu
                    'usage'  => [
                        'text'  => 'Användning',
                        'url'   => $this->di->get('url')->create('question/list/anvandning'),
                        'title' => ''
                    ],
                    
                    // This is a menu item of the submenu
                    'general'  => [
                        'text'  => 'Allmänt',
                        'url'   => $this->di->get('url')->create('question/list/allmant'),
                        'title' => ''
                    ],
               
                 ],
             ],
         ],  
         
         // This is a menu item
        'tags'  => [
            'text'  => 'Kategorier',
            'url'   => $this->di->get('url')->create('question/list-tags'),
            'title' => ''
        ],
        
        // This is a menu item
        'users'  => [
            'text'  => 'Användare',
            'url'   => $this->di->get('url')->create('users/list-users'),
            'title' => ''
        ],
        
        // This is a menu item
        'profile'  => [
            'text'  => 'Min profil',
            'url'   => $this->di->get('url')->create('users'),
            'title' => ''
        ],
        
        'om'  => [
            'text'  => 'Om Drone Zone',
            'url'   => $this->di->get('url')->create('om'),
            'title' => ''
        ],
        
        // This is a menu item
        'källkod'  => [
            'text'  => 'Källkod',
            'url'   => $this->di->get('url')->create('source'),
            'title' => ''
        ],
 
        /*
        // This is a menu item
        'test'  => [
            'text'  => 'Submenu',
            'url'   => $this->di->get('url')->create('submenu'),
            'title' => 'Submenu with url as internal route within this frontcontroller',

            // Here we add the submenu, with some menu items, as part of a existing menu item
            'submenu' => [

                'items' => [

                    // This is a menu item of the submenu
                    'item 0'  => [
                        'text'  => 'Item 0',
                        'url'   => $this->di->get('url')->create('submenu/item-0'),
                        'title' => 'Url as internal route within this frontcontroller'
                    ],

                    // This is a menu item of the submenu
                    'item 2'  => [
                        'text'  => '/humans.txt',
                        'url'   => $this->di->get('url')->asset('/humans.txt'),
                        'title' => 'Url to sitespecific asset',
                        'class' => 'italic'
                    ],

                    // This is a menu item of the submenu
                    'item 3'  => [
                        'text'  => 'humans.txt',
                        'url'   => $this->di->get('url')->asset('humans.txt'),
                        'title' => 'Url to asset relative to frontcontroller',
                    ],
                ],
            ],
        ],
 
        // This is a menu item
        'controller' => [
            'text'  =>'Controller (marked for all descendent actions)',
            'url'   => $this->di->get('url')->create('controller'),
            'title' => 'Url to relative frontcontroller, other file',
            'mark-if-parent-of' => 'controller',
        ],

        // This is a menu item
        'about' => [
            'text'  =>'About',
            'url'   => $this->di->get('url')->create('about'),
            'title' => 'Internal route within this frontcontroller'
        ],
        */
    ],
 


    /**
     * Callback tracing the current selected menu item base on scriptname
     *
     */
    'callback' => function ($url) {
        if ($url == $this->di->get('request')->getCurrentUrl(false)) {
            return true;
        }
    },



    /**
     * Callback to check if current page is a decendant of the menuitem, this check applies for those
     * menuitems that has the setting 'mark-if-parent' set to true.
     *
     */
    'is_parent' => function ($parent) {
        $route = $this->di->get('request')->getRoute();
        return !substr_compare($parent, $route, 0, strlen($parent));
    },



   /**
     * Callback to create the url, if needed, else comment out.
     *
     */
   /*
    'create_url' => function ($url) {
        return $this->di->get('url')->create($url);
    },
    */
];
