<?php

class Router
{
    private DefaultController $dc;
    private ContactController $cc;
    private AdminController $ac;
    public function __construct()
    {
        $this->dc = new DefaultController();
        $this->cc = new ContactController();
        $this->ac = new AdminController();
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
            else if ($_GET["route"] === "admin")
            {
                $action = $_GET["action"] ?? "";

                if ($_SERVER["REQUEST_METHOD"] === "POST" && $action === "updateProjects") {
                    $this->ac->updateProjects();
                    return;
                }

                if ($_SERVER["REQUEST_METHOD"] === "POST" && empty($action)) {
                    $this->ac->login();
                    return;
                }

                switch ($action)
                {
                    case "dashboard":
                        $this->ac->dashboard();
                        break;

                    case "messages":
                        $this->ac->messages();
                        break;

                    case "deleteMessage":
                        $this->ac->deleteMessage();
                        break;

                    case "projects":
                        $this->ac->projects();
                        break;

                    case "updateProjects":
                        $this->ac->updateProjects();
                        break;

                    case "syncGitHub":
                        $this->ac->syncGitHub();
                        break;

                    case "logout":
                        $this->ac->logout();
                        break;

                    default:
                        $this->ac->index();
                        break;
                }
            }
        }
        else
        {
            $this->dc->home();
        }
    }
}