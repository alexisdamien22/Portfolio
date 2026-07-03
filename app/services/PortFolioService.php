<?php

class PortfolioService
{
    public static function sync(): void
    {
        $config = JsonService::read("data/projects.json");

        $config["github"] ??= [];
        $config["custom"] ??= [];

        $repositories = GitHubService::getRepositories();

        foreach ($repositories as $repository) {

            $name = $repository["name"];

            if (!isset($config["github"][$name])) {

                $config["github"][$name] = [
                    "visible" => false,
                    "featured" => false,
                    "image" => null
                ];

            }

        }

        JsonService::write("data/projects.json", $config);
    }

    public static function getAdminProjects(): array
    {

        $config = JsonService::read("data/projects.json");

        $repositories = GitHubService::getRepositories();

        foreach ($repositories as &$repository) {

            $name = $repository["name"];

            $settings = $config["github"][$name] ?? [
                "visible" => false,
                "featured" => false,
                "image" => null
            ];

            $repository["visible"] = $settings["visible"];
            $repository["featured"] = $settings["featured"];
            $repository["image"] = $settings["image"];

            $repository["languages"] = GitHubService::getLanguages($name);
        }

        return $repositories;
    }

    public static function getPublicProjects(): array
    {
        $projects = self::getAdminProjects();

        usort($projects, function ($a, $b) {
            return ($b["featured"] ?? false) <=> ($a["featured"] ?? false);
        });

        return array_filter(
            $projects,
            fn($project) => $project["visible"]
        );
    }
}