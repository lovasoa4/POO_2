<?php
// ============================================
// 3. core/Autoloader.php
// ============================================
namespace Core;

/**
 * AUTOLOADER PSR-4
 * ================
 * Charge automatiquement les classes selon leur namespace
 * 
 * Mappings :
 * - Core\ClassName    -> core/ClassName.php
 * - App\Models\User   -> app/Models/User.php
 * - App\Controllers\* -> app/Controllers/*.php
 */
class Autoloader
{
    public static function register()
    {
        spl_autoload_register(function ($class) {            
            // Remplacer les backslash par des slashes
            $class = str_replace('\\', '/', $class);            
            
            // Séparer le namespace et le nom de classe
            $parts = explode('/', $class);
            
            // Déterminer le chemin selon le namespace de base
            if ($parts[0] === 'Core') {
                // Core\Router -> core/Router.php
                array_shift($parts); // Enlever 'Core'
                $file = ROOT . '/core/' . implode('/', $parts) . '.php';
            } elseif ($parts[0] === 'App') {
                // App\Models\User -> app/Models/User.php
                array_shift($parts); // Enlever 'App'
                $file = ROOT . '/app/' . implode('/', $parts) . '.php';
            } else {
                return;
            }
           
            // Charger le fichier s'il existe
            if (file_exists($file)) {
                require_once $file;
            }
        });
    }
     

    
}