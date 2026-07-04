# Portfolio

Portfolio personnel développé en **PHP 8**, suivant une architecture **MVC**, utilisant **Twig** pour le rendu des vues, une **API GitHub** pour récupérer automatiquement les projets publics, ainsi qu'un espace d'administration permettant de gérer leur affichage.

## Fonctionnalités

### Partie publique

- Page d'accueil
- Liste des projets
- Recherche de projets
- Mise en avant des projets "Featured"
- Formulaire de contact

### Partie administration

- Authentification administrateur
- Tableau de bord
- Gestion des messages
- Gestion des projets
- Synchronisation des dépôts GitHub
- Cache GitHub pour limiter les appels API

---

# Technologies utilisées

- PHP 8+
- Twig
- Composer
- GitHub REST API
- HTML5
- CSS3
- JavaScript
- Font Awesome

---

# Installation

## 1. Cloner le projet

```bash
git clone https://github.com/votre-utilisateur/portfolio.git
```

ou télécharger le projet.

---

## 2. Installer les dépendances

Depuis la racine du projet :

```bash
composer install
```

---

## 3. Créer le fichier `.env`

Créer un fichier `.env` à la racine du projet :

```env
GITHUB_USERNAME=votre_username
GITHUB_TOKEN=votre_token
```

### Obtenir un token GitHub

Créer un Personal Access Token :

https://github.com/settings/tokens

Le token doit avoir au minimum les droits :

- public_repo

---

## 4. Vérifier l'arborescence

```
Portfolio/
│
├── app/
├── data/
├── public/
├── vendor/
├── composer.json
├── composer.lock
└── .env
```

Le dossier **public** est le point d'entrée du site.

---

## 5. Permissions

Le serveur web doit pouvoir écrire dans :

```
data/
```

Notamment :

```
data/
├── admin.json
├── contacts.json
├── github_cache.json
├── projects.json
└── lang_cache/
```

---

## 6. Lancer le projet

Avec Laragon :

```
http://portfolio.test
```

ou avec le serveur PHP :

```bash
php -S localhost:8000 -t public
```

Puis ouvrir :

```
http://localhost:8000
```

---

# Premier lancement

Au premier accès :

- les dépôts GitHub sont récupérés
- un cache est généré
- le fichier `projects.json` est synchronisé

Les projets sont invisibles par défaut.

Ils doivent être activés depuis l'administration.

---

# Synchronisation GitHub

Depuis l'administration :

```
Project Manager
```

Cliquer sur :

```
Synchroniser avec GitHub
```

Cela :

- vide le cache GitHub
- recharge les dépôts
- ajoute automatiquement les nouveaux projets

---

# Configuration des projets

Chaque projet possède :

- Visible
- Featured

Visible :

- affiché sur le site

Featured :

- affiché dans la section "Mis en avant"

---

# Cache

Le projet utilise deux caches :

## Cache des repositories

```
data/github_cache.json
```

## Cache des langages

```
data/lang_cache/
```

Le cache évite d'interroger l'API GitHub à chaque visite.

---

# Administration

Accès :

```
/?route=admin
```

Les administrateurs sont enregistrés dans :

```
data/admin.json
```

Les mots de passe sont hashés avec :

```
password_hash()
```

---

# Architecture

```
app/
│
├── controllers/
├── services/
├── templates/
│
public/
│
├── assets/
│   ├── css/
│   ├── js/
│   └── img/
│
data/
│
vendor/
```

---

# Dépendances

Installer avec :

```bash
composer install
```

Le projet utilise notamment :

- twig/twig
- vlucas/phpdotenv

---

# Auteur

Alexis Damien