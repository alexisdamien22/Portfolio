<?php

class JsonService
{
    public static function read(string $file): array
    {
        if (!file_exists($file)) {
            file_put_contents($file, json_encode([], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        }

        $data = json_decode(file_get_contents($file), true);

        return is_array($data) ? $data : [];
    }

    public static function write(string $file, array $data): void
    {
        file_put_contents(
            $file,
            json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );
    }
}