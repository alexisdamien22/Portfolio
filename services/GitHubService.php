<?php

class GitHubService
{
    private const API_URL = "https://api.github.com";
    private const CACHE_FILE = "data/github_cache.json";
    private const LANG_CACHE_DIR = "data/lang_cache/";
    private const CACHE_TTL = 86400;

    private static function request(string $endpoint): array
    {
        $token = $_ENV["GITHUB_TOKEN"] ?? "";

        $ch = curl_init(self::API_URL . $endpoint);

        $headers = [
            "User-Agent: Portfolio",
            "Accept: application/vnd.github+json"
        ];

        if (!empty($token)) {
            $headers[] = "Authorization: Bearer $token";
        }

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_TIMEOUT => 10
        ]);

        $response = curl_exec($ch);

        curl_close($ch);

        $data = json_decode($response, true);

        return is_array($data) ? $data : [];
    }

    public static function getRepositories(): array
    {
        if (self::isCacheValid()) {
            return JsonService::read(self::CACHE_FILE);
        }

        $username = $_ENV["GITHUB_USERNAME"] ?? "";

        if (!$username) return [];

        $repos = self::request("/users/$username/repos?per_page=100");

        $projects = [];

        foreach ($repos as $repo) {

            if (!empty($repo["fork"])) {
                continue;
            }

            $projects[] = [
                "id" => $repo["id"],
                "name" => $repo["name"],
                "description" => $repo["description"] ?? "",
                "url" => $repo["html_url"],
                "language" => $repo["language"],
                "updated_at" => $repo["updated_at"]
            ];
        }

        JsonService::write(self::CACHE_FILE, $projects);

        return $projects;
    }

    public static function getLanguages(string $repo): array
    {
        $file = self::LANG_CACHE_DIR . $repo . ".json";

        if (file_exists($file)) {
            return JsonService::read($file);
        }

        $username = $_ENV["GITHUB_USERNAME"] ?? "";

        $data = self::request("/repos/$username/$repo/languages");

        $langs = array_keys($data);

        JsonService::write($file, $langs);

        return $langs;
    }
    
    private static function isCacheValid(): bool
    {
        if (!file_exists(self::CACHE_FILE)) {
            return false;
        }

        return (time() - filemtime(self::CACHE_FILE)) < self::CACHE_TTL;
    }

    public static function clearCache(): void
    {
        if (file_exists(self::CACHE_FILE)) {
            unlink(self::CACHE_FILE);
        }

        if (is_dir(self::LANG_CACHE_DIR)) {
            foreach (glob(self::LANG_CACHE_DIR . "*.json") as $file) {
                unlink($file);
            }
        }
    }
}