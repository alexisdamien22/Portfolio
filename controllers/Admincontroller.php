<?php

class AdminController extends AbstractController
{
    public function index(): void
    {
        if (AuthService::isAdmin()) {
            $this->redirect("index.php?route=admin&action=dashboard");
        }

        $this->render("admin/login/login.html.twig", [
            "error" => $_GET["error"] ?? null
        ]);
    }

    public function login(): void
    {
        $username = trim($_POST["username"]);
        $password = $_POST["password"];

        $admins = JsonService::read("data/admin.json");

        foreach ($admins as $admin) {

            if (
                $admin["username"] === $username &&
                password_verify($password, $admin["password"])
            ) {

                AuthService::login($admin["username"]);

                $this->redirect("index.php?route=admin&action=dashboard");
            }
        }

        $this->redirect("index.php?route=admin&error=invalid");
    }

    public function dashboard(): void
    {
        AuthService::requireAdmin();

        $this->render("admin/dashboard/dashboard.html.twig", [
            "username" => AuthService::username()
        ]);
    }

    public function logout(): void
    {
        AuthService::logout();

        $this->redirect("index.php?route=home");
    }

    public function messages(): void
    {
        AuthService::requireAdmin();

        $messages = JsonService::read("data/contacts.json");

        usort($messages, function ($a, $b) {
            return strtotime($b["date"]) - strtotime($a["date"]);
        });

        $this->render("admin/messages/messages.html.twig", [
            "messages" => $messages
        ]);
    }

    public function deleteMessage(): void
    {
        AuthService::requireAdmin();

        if (!isset($_GET["id"])) {
            $this->redirect("index.php?route=admin&action=messages");
        }

        $messages = JsonService::read("data/contacts.json");

        $id = (int) $_GET["id"];

        if (isset($messages[$id])) {

            unset($messages[$id]);

            JsonService::write(
                "data/contacts.json",
                array_values($messages)
            );
        }

        $this->redirect("index.php?route=admin&action=messages");
    }

    public function projects(): void
    {
        AuthService::requireAdmin();

        $projects = PortfolioService::getAdminProjects();

        $this->render("admin/manage_projects/manage_projects.html.twig", [
                "projects" => $projects
        ]);
    }

    public function updateProjects(): void
    {
        AuthService::requireAdmin();

        $config = JsonService::read("data/projects.json");

        $visible = $_POST["visible"] ?? [];
        $featured = $_POST["featured"] ?? [];

        foreach ($config["github"] as $name => &$settings) {

            $settings["visible"] = in_array($name, $visible);
            $settings["featured"] = in_array($name, $featured);

        }

        JsonService::write("data/projects.json", $config);

        $this->redirect("index.php?route=admin&action=projects");
    }
}