<?php

class ContactController extends AbstractController
{
    public function contact(): void
    {
        $loader = new \Twig\Loader\FilesystemLoader('templates');
        $twig = new \Twig\Environment($loader);

        $error = $_GET['error'] ?? null;
        $success = isset($_GET['success']);

        echo $twig->render('contact/contact.html.twig', [
            'error' => $error,
            'success' => $success
        ]);
    }

    public function contactForm(): void
    {
        $contact = [
            "name" => trim($_POST["name"]),
            "email" => trim($_POST["email"]),
            "subject" => trim($_POST["subject"]),
            "message" => trim($_POST["message"]),
            "date" => date("Y-m-d H:i:s")
        ];

        $file = "data/contacts.json";

        if (!file_exists($file)) {
            file_put_contents($file, json_encode([]));
        }

        $contacts = json_decode(file_get_contents($file), true);

        if (!is_array($contacts)) {
            $contacts = [];
        }

        foreach ($contacts as $existingContact) {

            if (
                strtolower($existingContact["email"]) === strtolower($contact["email"]) &&
                $existingContact["subject"] === $contact["subject"] &&
                $existingContact["message"] === $contact["message"]
            ) {
                header("Location: index.php?route=contact&error=duplicate");
                exit;
            }

            if (
                strtolower($existingContact["email"]) === strtolower($contact["email"]) &&
                (time() - strtotime($existingContact["date"])) < 300
            ) {
                header("Location: index.php?route=contact&error=spam");
                exit;
            }
        }

        $contacts[] = $contact;

        file_put_contents(
            $file,
            json_encode($contacts, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );

        header("Location: index.php?route=contact&success=1");
        exit;
    }
}