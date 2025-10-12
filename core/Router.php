<?php
namespace Core;

/**
 * SYSTÈME DE ROUTING
 * ==================
 * Gère les routes GET et POST
 * Dirige vers les contrôleurs appropriés
 */
class Router
{
    private $routes = [];
    
    /**
     * Définir une route GET
     * @param string $path   Le chemin URL
     * @param string $action Controller@method
     */
    public function get($path, $action)
    {
        $this->routes['GET'][$path] = $action;
    }
    
    /**
     * Définir une route POST
     * @param string $path   Le chemin URL
     * @param string $action Controller@method
     */
    public function post($path, $action)
    {
        $this->routes['POST'][$path] = $action;
    }
    
    /**
     * Exécuter le router
     * Analyse l'URL et la méthode HTTP
     * Lance le contrôleur correspondant
     */
    public function run()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = $this->getUri();
        
        // Vérifier si la route existe
        if (isset($this->routes[$method][$uri])) {
            $action = $this->routes[$method][$uri];
            $this->executeAction($action);
        } else {
            $this->notFound();
        }
    }
    
    /**
     * Récupérer l'URI nettoyée
     */
    private function getUri()
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        
        // Supprimer le slash final
        $uri = rtrim($uri, '/');
        
        // Gérer la racine
        if ($uri === '') {
            $uri = '/';
        }
        
        return $uri;
    }
    
    /**
     * Exécuter l'action du contrôleur
     */
    private function executeAction($action)
    {
        // Séparer Controller@method
        list($controller, $method) = explode('@', $action);
        
        // Construire le nom complet de la classe
        $controllerClass = "App\\Controllers\\{$controller}";
        
        // Vérifier et exécuter
        if (class_exists($controllerClass)) {
            $controllerInstance = new $controllerClass();
            
            if (method_exists($controllerInstance, $method)) {
                $controllerInstance->$method();
            } else {
                $this->error("Méthode {$method} introuvable dans {$controller}");
            }
        } else {
            $this->error("Contrôleur {$controller} introuvable");
        }
    }
    
    /**
     * Page 404
     */
    private function notFound()
    {
        http_response_code(404);
        echo "<h1>404 - Page non trouvée</h1>";
        echo "<p>La page demandée n'existe pas.</p>";
        echo "<a href='/'>Retour à l'accueil</a>";
    }
    
    /**
     * Erreur générique
     */
    private function error($message)
    {
        http_response_code(500);
        echo "<h1>Erreur</h1>";
        echo "<p>{$message}</p>";
    }
}