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

        if (!isset($this->routes[$method])) {
            $this->notFound();
            return;
        }

        foreach ($this->routes[$method] as $routeUri => $action) {
            // Convertir /css/:file en regex
            $pattern = preg_replace('#:([\w]+)#', '([^/]+)', $routeUri);
            $pattern = '#^' . $pattern . '$#';

            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches); // retire l'URL complète
                $this->executeAction($action, $matches); // passer les params
                return;
            }
        }

        $this->notFound();
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
    private function executeAction($action, $params = [])
    {
        list($controller, $method) = explode('@', $action);
        $controllerClass = "App\\Controllers\\{$controller}";

        if (class_exists($controllerClass)) {
            $controllerInstance = new $controllerClass();

            if (method_exists($controllerInstance, $method)) {
                call_user_func_array([$controllerInstance, $method], $params);
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