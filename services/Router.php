<?php

class Router
{
    private DefaultController $dc;
    private ContactController $cc;
    public function __construct()
    {
        $this->dc = new DefaultController();
        $this->cc = new ContactController();
    }

    public function handleRequest() : void
    {
        if(!empty($_GET["route"]))
        {
            if($_GET['route'] === 'projects') {
                $this->dc->projects();
            }
            else if($_GET['route'] === 'home') {
                $this->dc->home();
            }
            else if($_GET['route'] === 'contact') {
                if($_SERVER['REQUEST_METHOD'] === 'POST')
                {
                    $this->cc->contactForm();
                }
                else
                {
                    $this->cc->contact();
                }
            }
            else
            {
                $this->dc->notFound();
            }
        }
        else
        {
            $this->dc->home();
        }
    }
}