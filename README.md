# API REST - Plateforme de Diffusion Vidéo

## Description

Ce projet consiste à créer une **API REST** permettant la gestion des informations des utilisateurs et des vidéos pour une nouvelle plateforme de diffusion vidéo. L'API fournit des réponses au format **JSON** et permet de gérer les vidéos et les informations d'un utilisateur via des opérations classiques d'une API REST (CRUD : Create, Read, Update, Delete).

Une base de données est fournie, mais elle n'est pas obligatoire pour le bon fonctionnement du projet.

## Fonctionnalités de l'API

### 1. Gestion des Utilisateurs
- **Créer un utilisateur** : Ajout d'un nouvel utilisateur dans le système.
- **Lire les informations d'un utilisateur** : Récupérer les informations d'un utilisateur spécifique via son ID.
- **Mettre à jour les informations d'un utilisateur** : Modifier les informations associées à un utilisateur.
- **Supprimer un utilisateur** : Retirer un utilisateur de la plateforme.

### 2. Gestion des Vidéos
- **Ajouter une vidéo** : Un utilisateur peut uploader une vidéo à son compte.
- **Lire les informations d'une vidéo** : Récupérer les détails d'une vidéo spécifique (titre, description, URL, etc.).
- **Mettre à jour une vidéo** : Modifier les informations d'une vidéo (par exemple, mettre à jour la description).
- **Supprimer une vidéo** : Retirer une vidéo d'un utilisateur.

### 3. Format des Réponses
- Toutes les réponses de l'API sont au format **JSON**, ce qui permet une interaction facile avec les systèmes frontend ou d'autres services.

## Prérequis

Avant de commencer à utiliser l'API, assurez-vous d'avoir un environnement de développement fonctionnel avec les prérequis suivants :

- **Node.js** et **npm** (pour l'installation et l'exécution du projet).
- Une base de données (optionnelle) fournie avec le projet, mais vous êtes libre de ne pas l'utiliser si vous préférez une autre solution.
