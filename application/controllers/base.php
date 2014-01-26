<?php

class Base_Controller extends Controller 
{
    
    public $layout = 'layouts.common';

    public function __construct()
    {
        // POST and PUT methods should always have CSRF tokens
        $this->filter('before', 'csrf')->on(array('post', 'put'));

        // assets
        Asset::container('footer')->add('dojo', 'https://ajax.googleapis.com/ajax/libs/dojo/1.8.1/dojo/dojo.js', array(), array('data-dojo-config' => 'async: true'));
        Asset::container('footer')->add('application-js', 'js/application.js');
        Asset::add('style', 'css/style.css');
        parent::__construct();
    }

    protected function switch_layout($layout)
    {
        $this->layout = $layout;
        $this->layout = $this->layout();
    }

    /**
     * Catch-all method for requests that can't be matched.
     *
     * @param  string    $method
     * @param  array     $parameters
     * @return Response
     */
    public function __call($method, $parameters)
    {
        return Response::error('404');
    }

}