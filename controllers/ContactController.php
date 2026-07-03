<?php

class ContactController extends AbstractController
{
    public function contact(): void
    {
        $this->render("contact/contact.html.twig", [
            "error" => $_GET["error"] ?? null,
            "success" => isset($_GET["success"])
        ]);
    }

    public function contactForm(): void
    {
        $contact = [
            "id" => uniqid(),
            "name" => trim($_POST["name"]),
            "email" => trim($_POST["email"]),
            "subject" => trim($_POST["subject"]),
            "message" => trim($_POST["message"]),
            "date" => date("Y-m-d H:i:s")
        ];

        $contacts = JsonService::read("data/contacts.json");

        foreach ($contacts as $existingContact) {

            if (
                strtolower($existingContact["email"]) === strtolower($contact["email"]) &&
                $existingContact["subject"] === $contact["subject"] &&
                $existingContact["message"] === $contact["message"]
            ) {
                $this->redirect("index.php?route=contact&error=duplicate");
            }

            if (
                strtolower($existingContact["email"]) === strtolower($contact["email"]) &&
                (time() - strtotime($existingContact["date"])) < 300
            ) {
                $this->redirect("index.php?route=contact&error=spam");
            }
        }

        $contacts[] = $contact;

        JsonService::write("data/contacts.json", $contacts);

        $this->redirect("index.php?route=contact&success=1");
    }
}