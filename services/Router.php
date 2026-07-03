<?php

class Router
{
    private RouteController $rc;
    private ContactController $cc;
    public function __construct()
    {
        $this->rc = new RouteController();
        $this->cc = new ContactController();
    }

    public function handleRequest() : void
    {
        if(!empty($_GET["route"]))
        {
            if($_GET['route'] === 'projects') {
                $this->rc->projects();
            }
            else if($_GET['route'] === 'home') {
                $this->rc->home();
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
                $this->rc->notFound();
            }
        }
        else
        {
            $this->rc->home();
        }
    }
}