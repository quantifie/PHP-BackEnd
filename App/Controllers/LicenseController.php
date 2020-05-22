<?php

namespace App\Controllers;

use App\DatabaseModels\License;
use App\DataModels\Requests\LicenseAddRequest;
use App\DataModels\Requests\LicenseGetRequest;
use App\DataModels\Responses\LicenseAddResponse;
use App\DataModels\Responses\LicenseGetResponse;
use App\Logic\LicenseLogic;
use Core\Controller;
use Core\Entities\ErrorCodes;
use Core\Http\HttpRequest;
use Core\Http\HttpResponse;
use Core\Libs\Helpers\Mapper;
use Core\Libs\Helpers\RequestHelper;

/**
 * Class LicenseController
 * @package Controllers
 */
class LicenseController extends Controller
{
    #region Public Fields
    #endregion

    #region Private Fields
    private LicenseLogic $_logic;
    #endregion

    #region Public Methods
    /**
     * LicenseController constructor.
     * @param HttpRequest $request
     * @param array $params
     */
    public function __construct(HttpRequest $request, array $params)
    {
        parent::__construct($request, $params);
        $this->_logic = new LicenseLogic();
    }

    /**
     * Gets a license data by given id
     */
    public function Get()
    {
        /** @var LicenseGetRequest $request */
        $request = $this->Request->Body;
        RequestHelper::CheckRequirements($request, ["Token", "Id", "IncludeSubLicenses"]);

        $license = $this->_logic->Get($request->Id, $request->IncludeSubLicenses);

        if (!isset($license))
            HttpResponse::Error("License not found", ErrorCodes::$RecordNotFound);

        $response = new LicenseGetResponse();
        $response->License = $license;
        HttpResponse::Ok($response);
    }

    /**
     * Adds a new license
     */
    public function Add()
    {
        /** @var LicenseAddRequest $request */
        $request = $this->Request->Body;
        //AuthHelper::CheckManagerToken($request->Token, $this->Context);

        RequestHelper::CheckRequirements($request, ["Token"]);
        RequestHelper::CheckRequirements($request->License, ["ManagerId", "Type", "Count", "SubscriptionStartDate", "SubscriptionEndDate", "LicenseeId"]);

        $addedLicense = $this->_logic->Add(Mapper::Map($request->License, License::class, true));

        if ($addedLicense === false)
            HttpResponse::Error("License not added.", ErrorCodes::$RecordNotAdded);

        $response = new LicenseAddResponse();
        $response->License = $addedLicense;

        HttpResponse::Ok($response);
    }


    #endregion

    #region Private Methods

    #endregion

    #region Helpers
    #endregion
}
