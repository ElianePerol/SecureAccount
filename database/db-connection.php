<?php

// try {
//     // Obtenir l'instance de connexion
//     $db = DatabaseConnection::getInstance();
    
//     // Exemple d'utilisation avec votre table users
//     $stmt = $db->prepare("
//         SELECT id, username, email, created_at 
//         FROM users 
//         WHERE email = ?
//     ");
    
//     $stmt->execute(['exemple@email.com']);
//     $user = $stmt->fetch();
    
// } catch (\RuntimeException $e) {
//     // Gérer l'erreur de connexion
//     error_log($e->getMessage());
//     // Afficher un message d'erreur approprié
// }