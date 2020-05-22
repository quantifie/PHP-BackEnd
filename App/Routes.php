<?php


namespace App;

use App\Controllers\LicenseController;
use Core\Http\Enums\RequestTypes;
use Core\Route\RouteBase;

/**
 * Class Router
 * @package Core\Route
 */
class Routes extends RouteBase
{
    
    #region Public Methods
    #endregion
    
    #region Constructor
    /**
     * Router constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->Add("lincese/add", LicenseController::class, "Add", RequestTypes::$Post)
            ->Add("lincese/get", LicenseController::class, "Get", RequestTypes::$Post);
    }


    #endregion
    
    #region Private Methods
    #endregion
    
    #region Helpers
    #endregion
    
}
