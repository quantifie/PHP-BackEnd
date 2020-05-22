<?php

namespace Core;

use Core\Database\DbContext;
use Core\Database\MysqlDatabaseConnectorFactory;
use Core\Database\Enums\DatabaseTypes;
use Core\Database\Migration\Migration;
use Core\Database\Migration\MysqlDatabaseMigration;
use Core\Entities\ErrorCodes;
use Core\Exceptions\ApplicationNotCreatedException;
use Core\Http\HttpRequest;
use Core\Http\HttpResponse;
use Core\Libs\Helpers\ApplicationHelper;
use Core\Libs\Helpers\Debug;
use Core\Libs\Helpers\RequestHelper;
use Core\Options\ApplicationOptionFactory;
use Core\Options\IApplicationOption;
use Core\Options\IApplicationOptionFactory;
use Core\Options\IDatabaseOption;
use Core\Reflections\Annotations\ClassAnnotations;
use Core\Reflections\Reflections;
use Core\Route\RouteBase;
use Core\Route\RouteModel;
use Core\Security\OriginBase;
use Exception;
use ReflectionMethod;

/**
 * Class Application
 * @package Core
 */
class Core
{
    #region Public Fields
    #endregion

    #region Private Fields
    /**
     * @var RouteBase
     */
    private RouteBase $_routes;

    private OriginBase $_origins;

    private IApplicationOption $_applicationOption;

    private IDatabaseOption $_databaseOption;

    private DbContext $_dbContext;

    #endregion

    #region Constructor

    /**
     * Application constructor.
     * @param IDatabaseOption $databaseOption
     * @param IApplicationOption $applicationOption
     * @param RouteBase $routes
     * @param OriginBase $origins
     * @param DbContext $dbContext
     */
    public function __construct(IDatabaseOption $databaseOption,
                                IApplicationOption $applicationOption,
                                RouteBase $routes,
                                OriginBase $origins,
                                DbContext $dbContext)
    {
        try {
            $this->_routes =  $routes;
            $this->_origins = $origins;
            $this->_applicationOption = $applicationOption;
            $this->_databaseOption = $databaseOption;
            $this->_dbContext = $dbContext;

            ApplicationHelper::SetEnvironment($this->_applicationOption->IsDevelopment(), $this->_applicationOption->ReportErrors());

            /** @var IApplicationOptionFactory $applicationOptionFactory */
            $applicationOptionFactory = new ApplicationOptionFactory();
            $applicationOptionFactory->Set($this->_applicationOption);

            $connectorFactory = new MysqlDatabaseConnectorFactory();
            $connectorFactory->SetDatabaseOption($this->_databaseOption);

            $this->SetMigration();

        } catch (Exception $e) {
            new ApplicationNotCreatedException();
        }
    }
    #endregion

    #region Public Methods
    /**
     * @return void
     */
    public function Start()
    {
        ApplicationHelper::EnableCORS($this->_origins->GetOrigins());

        $url = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';
        $url = trim($url, "/");
        $matchedRoute = $this->_routes->Search($url);
        if ($matchedRoute === false)
            HttpResponse::NotFound("Route not found", ErrorCodes::$RouteNotFound);

        $this->SetControllerAndAction($matchedRoute);
    }

    #endregion

    #region Private Methods

    /**
     * Sets the Controller Object
     * @param RouteModel $routeModel
     * @return void
     */
    private function SetControllerAndAction(RouteModel $routeModel)
    {
        $Request = new HttpRequest($_SERVER['REQUEST_METHOD'] ??= $_SERVER['REQUEST_METHOD'], $this->_applicationOption);
        RequestHelper::CheckRequestType($Request->Type, $routeModel->RequestType);

        try {
            $reflection = new Reflections($routeModel->ControllerName);
            $action = $reflection->getMethod($routeModel->Action);
            $this->CheckAuthorization($reflection, $action);
            $controller = $reflection->GetClass()->newInstance($Request, $routeModel->Params);
            $action->invoke($controller);
        } catch (Exception $e) {
            HttpResponse::Error($e->getMessage() . "  Stack Trace: " . $e->getTraceAsString(), $e->getCode());
        }
    }

    /**
     * @param DbContext $dbContext
     * @return void
     */
    private function SetMigration()
    {
        if ($this->_applicationOption->EnableMigration() === false)
            return;

        if ($this->_databaseOption->Type() === DatabaseTypes::$MySql) {
            $databaseMigration = new MysqlDatabaseMigration($this->_dbContext);
            new Migration($databaseMigration,  $this->_databaseOption);
        } else
            return;
    }

    private function CheckAuthorization(Reflections $reflectionClass, ReflectionMethod $reflectionMethod) {
        $classAnnotations = new ClassAnnotations($reflectionClass);
    }
    #endregion

    #region Helpers
    #endregion

}
