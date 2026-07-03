<?php

class DefaultController extends AbstractController
{
    public function home() : void
    {
        $this->render('home/home.html.twig', []);
    }

    public function projects() : void
    {
        $projects = PortfolioService::getPublicProjects();

        $this->render(
            "projects/projects.html.twig",
            [
                "projects" => $projects
            ]
        );
    }

    public function contact() : void
    {
        $this->render('contact/contact.html.twig', []);
    }

    public function notFound() : void
    {
        $this->render('error/notFound.html.twig', []);
    }
}