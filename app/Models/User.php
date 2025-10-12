<?php
namespace App\Models;

/**
 * MODÈLE USER - VERSION STATIQUE (sans base de données)
 */
class User
{
    // Données statiques en mémoire
    private static $users = [
        [
            'id' => 1,
            'name' => 'Jean Dupont',
            'email' => 'jean.dupont@example.com',
            'created_at' => '2024-01-15 10:30:00'
        ],
        [
            'id' => 2,
            'name' => 'Marie Martin',
            'email' => 'marie.martin@example.com',
            'created_at' => '2024-01-16 14:20:00'
        ],
        [
            'id' => 3,
            'name' => 'Pierre Durand',
            'email' => 'pierre.durand@example.com',
            'created_at' => '2024-01-17 09:15:00'
        ],
        [
            'id' => 4,
            'name' => 'Sophie Leblanc',
            'email' => 'sophie.leblanc@example.com',
            'created_at' => '2024-01-18 16:45:00'
        ]
    ];
    
    /**
     * Récupérer tous les utilisateurs
     */
    public function getAll()
    {
        return self::$users;
    }
    
    /**
     * Récupérer un utilisateur par ID
     */
    public function getById($id)
    {
        foreach (self::$users as $user) {
            if ($user['id'] == $id) {
                return $user;
            }
        }
        return null;
    }
    
    /**
     * Créer un nouvel utilisateur
     */
    public function create($data)
    {
        // Générer un nouvel ID
        $maxId = 0;
        foreach (self::$users as $user) {
            if ($user['id'] > $maxId) {
                $maxId = $user['id'];
            }
        }
        
        $newUser = [
            'id' => $maxId + 1,
            'name' => $data['name'],
            'email' => $data['email'],
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        // Ajouter à la liste (en mémoire seulement)
        self::$users[] = $newUser;
        
        return true;
    }
    
    /**
     * Supprimer un utilisateur
     */
    public function delete($id)
    {
        foreach (self::$users as $key => $user) {
            if ($user['id'] == $id) {
                unset(self::$users[$key]);
                // Réindexer le tableau
                self::$users = array_values(self::$users);
                return true;
            }
        }
        return false;
    }
    
    /**
     * Vérifier si un email existe déjà
     */
    public function emailExists($email)
    {
        foreach (self::$users as $user) {
            if ($user['email'] === $email) {
                return true;
            }
        }
        return false;
    }
}