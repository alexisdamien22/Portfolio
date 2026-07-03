<?php

class JsonService
{
    public static function write(string $path, array $data): void
    {
        file_put_contents(
            ROOT_PATH . "/" . ltrim($path, "/"),
            json_encode($data, JSON_PRETTY_PRINT)
        );
    }

    public static function read(string $path): array
    {
        $fullPath = ROOT_PATH . "/" . ltrim($path, "/");

        if (!file_exists($fullPath)) {
            return [];
        }

        $content = file_get_contents($fullPath);

        return json_decode($content, true) ?? [];
    }
}