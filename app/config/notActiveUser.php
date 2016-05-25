<?php
return [

    // Use for styling the menu
    'class' => 'navbar',

    //TODO: Create a class(or something) with different items depending on if the user is active or not
    // Here comes the menu strcture
    'items' => [

        // This is a menu item
        'home'  => [
            'text'  => 'Home',
            'url'   => $this->di->get('url')->create(''),
            'title' => 'Home route of current frontcontroller'
        ],

        // This is a menu item
        'presentation' => [
            'text'  =>'Questions',
            'url'   => $this->di->get('url')->create('questions'),
            'title' => 'Redovisning'
        ],

        // This is a menu item
        'sourcecode' => [
            'text'  =>'Källkod',
            'url'   => $this->di->get('url')->create('sourcecode'),
            'title' => 'Källkod'
        ],

        'users' => [
            'text'  => "Tags",
            'url'   => $this->di->get('url')->create('comments'),
            'title' => "Alla användare",
        ],

        'comments' => [
            'text'  => "Users",
            'url'   => $this->di->get('url')->create('users'),
            'title' => "See comments",
        ],
        'escape' => [
            'text'  => "About111",
            'url'   => $this->di->get('url')->create('about'),
            'title' => "About this webpage",

        ],


        'login' => [
            'text'  => $this->di->usersTest11->getCorrectUrl()['text'],
            'url' => $this->di->get('url')->create($this->di->usersTest11->getCorrectUrl()['url']),
            'title' => $this->di->usersTest11->getCorrectUrl()['title'],

        ],




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