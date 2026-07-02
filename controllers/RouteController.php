<?php

class RouteController extends AbstractController
{
    public function home() : void
    {
        $this->render('home/home.html.twig', []);
    }

    public function projects() : void
    {
        $this->render('projects/projects.html.twig', []);
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