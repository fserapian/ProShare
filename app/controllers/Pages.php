<?php

class Pages extends Controller
{
    public function __construct()
    { }

    // default method
    public function index()
    {
        if (isLoggedIn()) {
            redirect('posts');
        }
        
        $data = [
            'title' => 'ProShare',
            'description' => 'App to share project ideas easily and efficiently
                              using fsn-mvc php framework'
        ];

        $this->view('pages/index', $data);
    }

    public function about()
    {

        $data = [
            'title' => 'About Us',
            'description' => 'App to share posts with community members'
        ];

        $this->view('pages/about', $data);
    }
}
