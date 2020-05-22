<?php


use App\ApplicationDbContext;
use App\Origins;
use App\Routes;
use Core\Core;
use Core\Database\DbContext;
use Core\Options\ApplicationOption;
use Core\Options\IApplicationOption;
use Core\Options\IDatabaseOption;
use Core\Options\MysqlDatabaseOption;
use Core\Route\RouteBase;
use Core\Security\OriginBase;

class Application
{
    private IApplicationOption $applicationOption;
    private IDatabaseOption $databaseOption;
    private OriginBase $origins;
    private RouteBase $routes;
    private DbContext $dbContext;
    private Core $core;

    public function __construct()
    {
        $this->applicationOption = new ApplicationOption(true,true);
        $this->databaseOption = new MysqlDatabaseOption(
            "localhost",
            "XLoopLicenseManagerTest",
            "XLoopLicenseAdmin",
            "Crim41Mesh82",
            "qifie",
            "Crim41Mesh82");

        $this->origins = new Origins();
        $this->routes = new Routes();
        $this->dbContext = new ApplicationDbContext();
        $this->core = new Core($this->databaseOption, $this->applicationOption, $this->routes, $this->origins, $this->dbContext);
    }

    public function Start(){
        $this->core->Start();
    }
}