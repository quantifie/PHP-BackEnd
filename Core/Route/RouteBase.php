<?php


namespace Core\Route;


/**
 * Class BaseRoutes
 * @package Core\Route
 */
class RouteBase
{
	#region Public Fields
	/**
     * @var RouteModel[]
     */
    public array $Routes;

    public array $Params;
    #endregion
    
    #region Private Fields
    #endregion
    
    #region Constructor
    /**
     * BaseRoute constructor.
     */
    public function __construct()
    {
        $this->Routes = [];
        $this->Params = [];
    }
    #endregion
    
    #region Public Methods
    /**
     * @param string $endPoint
     * @param string $controllerName ;
     * @param string $actionName
     * @param string $requestType
     * @return RouteBase
     */
    public function Add(string $endPoint, string $controllerName, string $actionName, string $requestType = "GET") {
        $newRoute = new RouteModel();
        $newRoute->Action = $actionName;
        $newRoute->ControllerName = $controllerName;
        $newRoute->EndPoint = $endPoint;
        $newRoute->RequestType = $requestType;

        array_push($this->Routes, $newRoute);

        return $this;
    }

    /**
     * @param string $url
     * @return RouteModel|false
     */
    public function Search(string $url) {
        $exactMatch = $this->FindExactMatch($url);
        if ($exactMatch !== false)
            return $exactMatch;

        $anyMatch = $this->FindParametricRoute($url);
        if ($anyMatch !== false)
            return $anyMatch;

        return false;
    }
    #endregion
    
    #region Private Methods
    /**
     * @param string $url
     * @return RouteModel|false
     */
    private function FindExactMatch(string $url) {
        $matchedRoutes = array_keys(array_column($this->Routes, "EndPoint"), $url, true);
        if (count($matchedRoutes) > 0) {
            $matchedRoute = $this->Routes[$matchedRoutes[0]];
            $matchedRoute->Params = [];
            return $matchedRoute;
        }

        return false;
    }

    /**
     * @param string $url
     * @return RouteModel|false
     */
    private function FindParametricRoute(string $url) {
        /** @var RouteModel[] $routesHasComma */
        $routesHasComma = array_filter($this->Routes, function (RouteModel $route) {
            return strpos($route->EndPoint, ":") === false ? false : true;
        });

        $urlArray = explode("/", trim($url));

        foreach ($routesHasComma as $route) {
            $explodedRoute = explode("/", trim($route->EndPoint, "/"));

            $routeParams = array_filter($explodedRoute, function ($route) {
                return strpos($route, ":") === false ? false : true;
            });

            $routeRestArray = array_diff($explodedRoute, array_values($routeParams));

            $urlRestArray = array_slice($urlArray, 0, count($routeRestArray));

            $urlParams = array_slice($urlArray, count($urlRestArray), count($urlArray) - count($urlRestArray));

            if ($urlRestArray === $routeRestArray && count($urlParams) === count($routeParams)) {
                $i = 0;
                foreach ($routeParams as $routeParam) {
                    $route->Params[trim($routeParam, ":")] = $urlParams[$i];
                    $i++;
                }
                return $route;
            }
        }

        return false;
    }
    #endregion
    
    #region Helpers
    #endregion
    

    

    
}
