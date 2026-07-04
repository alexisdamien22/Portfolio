<?php

class DefaultController extends AbstractController
{
    public function home(): void
    {
        $projects = PortfolioService::getPublicProjects();

        $featured = array_filter($projects, fn($p) => $p["featured"]);

        $this->render("home/home.html.twig", [
            "featuredProjects" => $featured
        ]);
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