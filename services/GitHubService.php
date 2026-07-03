<?php

class GitHubService
{
    private const API_URL = "https://api.github.com";

    private static function request(string $endpoint): array
    {
        $token = $_ENV["GITHUB_TOKEN"] ?? "";

        $ch = curl_init(self::API_URL . $endpoint);

        $headers = [
            "User-Agent: Portfolio",
            "Accept: application/vnd.github+json"
        ];

        if (!empty($token)) {
            $headers[] = "Authorization: Bearer " . $token;
        }

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_TIMEOUT => 10
        ]);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            curl_close($ch);
            return [];
        }

        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        if ($statusCode !== 200) {
            return [];
        }

        $data = json_decode($response, true);

        return is_array($data) ? $data : [];
    }

    public static function getRepositories(): array
    {
        $username = $_ENV["GITHUB_USERNAME"] ?? "";

        if (empty($username)) {
            return [];
        }

        $repositories = self::request(
            "/users/{$username}/repos?sort=updated&per_page=100"
        );

        $projects = [];

        foreach ($repositories as $repository) {

            if ($repository["fork"]) {
                continue;
            }

            $projects[] = [
                "id" => $repository["id"],
                "type" => "github",
                "name" => $repository["name"],
                "description" => $repository["description"] ?? "",
                "url" => $repository["html_url"],
                "homepage" => $repository["homepage"] ?: null,
                "language" => $repository["language"],
                "stars" => $repository["stargazers_count"],
                "updated_at" => $repository["updated_at"],
                "image" => null
            ];
        }

        return $projects;
    }

    public static function getRepository(string $repository): array
    {
        $username = $_ENV["GITHUB_USERNAME"] ?? "";

        return self::request("/repos/{$username}/{$repository}");
    }

    public static function getLanguages(string $repo): array
    {
        $username = $_ENV["GITHUB_USERNAME"] ?? "";

        if (!$username) {
            return [];
        }

        $data = self::request("/repos/{$username}/{$repo}/languages");

        return array_keys($data);
    }
}