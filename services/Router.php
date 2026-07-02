<?php

class Router
{
    private RouteController $rc;
    public function __construct()
    {
        $this->rc = new RouteController();
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
                $this->rc->contact();
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