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
use Core\Libs\Helpers\DateTime;

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
            "MvcText",
            "MvcUser",
            "Crim41Mesh82",
            "qifie",
            "Crim41Mesh82");

        $this->origins = new Origins();
        $this->routes = new Routes();
        $this->dbContext = new ApplicationDbContext();
        $this->core = new Core($this->databaseOption, $this->applicationOption, $this->routes, $this->origins, $this->dbContext);

        $this->Seed();
        $this->Start();
    }

    private function Start(){

        $this->core->Start();
    }

    private function Seed() {
        $this->dbContext->Licenses->Insert([
            "Id" => 10,
            "Active" => 1,
            "CreationDate" => DateTime::Now(),
            "SubscriptionStartDate" => DateTime::Now(),
            "SubscriptionEndDate" => DateTime::Now(),
            "LicenseToken" => "new-license-token",
            "Type" => 1,
            "ManagerId" => -1,
            "Count" => 0,
            "Deleted" => 0,
            "LicenseeId" => 1
        ]);
    }
}