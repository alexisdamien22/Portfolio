<?php

abstract class AbstractController
{
    protected \Twig\Environment $twig;

    public function __construct()
    {
        $loader = new \Twig\Loader\FilesystemLoader(
            ROOT_PATH . "/app/templates"
        );

        $this->twig = new \Twig\Environment($loader, [
            "debug" => true
        ]);

        $this->twig->addExtension(new \Twig\Extension\DebugExtension());
    }

    protected function render(string $template, array $data = []): void
    {
        echo $this->twig->render($template, $data);
    }

    protected function redirect(string $url): void
    {
        header("Location: " . $url);
        exit;
    }
}