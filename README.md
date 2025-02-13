# Développement d'un Système de Création de Compte et d'Identification Sécurisé

## Contexte
Vous êtes chargé de développer un système de création de compte et d'identification pour une application web. Cette application doit être sécurisée et respecter les bonnes pratiques en matière de cybersécurité. Le système doit inclure des fonctionnalités de gestion des utilisateurs, d'authentification, et de protection contre les attaques courantes.

## Objectifs
- Développer un système de création de compte sécurisé.
- Implémenter une authentification robuste avec gestion des sessions.
- Protéger l'application contre les attaques courantes (injections SQL, XSS, CSRF).
- Mettre en place une journalisation des accès et des incidents.

## Étapes du TP

### Partie 1 : Création de Compte Sécurisé

#### 1. Formulaire de Création de Compte
- Créez un formulaire HTML pour la création de compte avec les champs suivants :
  - Nom d'utilisateur
  - Adresse e-mail
  - Mot de passe
  - Confirmation du mot de passe
- Validez les entrées côté client (JavaScript) et côté serveur (PHP) :
  - Le mot de passe doit contenir au moins 12 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial.
  - L'adresse e-mail doit être valide.

#### 2. Hachage des Mots de Passe
- Utilisez une fonction de hachage sécurisée (ex : `password_hash` en PHP) pour stocker les mots de passe dans la base de données.
- Ajoutez un grain de sel (salage) pour renforcer la sécurité.

#### 3. Gestion des Erreurs
- Gérez les erreurs courantes (ex : nom d'utilisateur déjà pris, e-mail déjà utilisé) en affichant des messages d'erreur clairs à l'utilisateur.

### Partie 2 : Authentification et Gestion des Sessions

#### 1. Formulaire d'Authentification
- Créez un formulaire d'authentification avec les champs suivants :
  - Nom d'utilisateur ou e-mail
  - Mot de passe
- Validez les entrées côté serveur.

#### 2. Vérification des Identifiants
- Vérifiez que le nom d'utilisateur ou l'e-mail existe dans la base de données.
- Utilisez `password_verify` pour comparer le mot de passe saisi avec le mot de passe haché stocké.

#### 3. Gestion des Sessions
- Créez une session sécurisée pour l'utilisateur après une authentification réussie.
- Utilisez des cookies sécurisés (`HttpOnly` et `Secure`) pour stocker l'identifiant de session.
- Implémentez une déconnexion sécurisée qui détruit la session.

#### 4. Authentification à Deux Facteurs (2FA)
- Ajoutez une option pour l'authentification à deux facteurs en utilisant un code OTP (One-Time Password) envoyé par e-mail.

### Partie 3 : Protection contre les Attaques Courantes

#### 1. Protection contre les Injections SQL
- Utilisez des requêtes préparées pour toutes les interactions avec la base de données.
- Validez et filtrez toutes les entrées utilisateur.

#### 2. Protection contre les Attaques XSS
- Échappez les données avant de les afficher dans les pages web (ex : `htmlspecialchars` en PHP).
- Validez les entrées utilisateur pour éviter l'injection de code JavaScript.

#### 3. Protection contre les Attaques CSRF
- Générez un jeton CSRF pour chaque formulaire et vérifiez-le lors de la soumission.
- Utilisez des bibliothèques ou frameworks pour simplifier la gestion des jetons CSRF.

### Partie 4 : Journalisation et Sécurité des Données

#### 1. Journalisation des Accès
- Enregistrez les tentatives de connexion (réussies et échouées) dans un fichier journal.
- Incluez des informations telles que l'heure, l'adresse IP, et le nom d'utilisateur.

#### 2. Chiffrement des Données Sensibles
- Chiffrez les données sensibles (ex : adresses e-mail) avant de les stocker dans la base de données.
- Utilisez des algorithmes de chiffrement symétrique (ex : AES) ou asymétrique (ex : RSA).

#### 3. Gestion des Droits d'Accès
- Créez des rôles utilisateurs (ex : administrateur, utilisateur standard) et attribuez des droits d'accès en fonction des rôles.
- Restreignez l'accès aux fonctionnalités sensibles (ex : suppression de compte) aux utilisateurs autorisés.

### Partie 5 : Tests et Validation

#### 1. Tests Unitaires
- Écrivez des tests unitaires pour vérifier le bon fonctionnement des fonctions de création de compte, d'authentification, et de gestion des sessions.
- Testez les cas limites (ex : mot de passe trop court, e-mail invalide).

---

## Technologies Utilisées
- **Back-end** : PHP (avec gestion sécurisée des sessions et authentification)
- **Base de données** : MySQL avec requêtes préparées
- **Front-end** : HTML, CSS, JavaScript (validation côté client)
- **Sécurité** :
  - Hachage des mots de passe avec `password_hash`
  - Requêtes préparées pour éviter les injections SQL
  - Échappement des entrées pour prévenir le XSS
  - Protection CSRF avec jetons sécurisés
  - Authentification à deux facteurs (OTP par e-mail)
  - Chiffrement des données sensibles (AES, RSA)
