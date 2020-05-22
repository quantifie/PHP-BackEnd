<?php

namespace Core\Libs\Helpers;


use Core\Entities\ErrorCodes;
use Core\Http\HttpRequest;
use Core\Http\HttpResponse;

/**
 * Class RequestUtils
 * @package Libs\Helpers
 */
abstract class RequestHelper
{
    #region Public Fields
    #endregion

    #region Private Fields
    #endregion

    #region Constructor
    #endregion

    #region Public Methods
    public static function CheckRequestBody(HttpRequest $request, string $requestRootName = "")
    {

        if ($requestRootName === "") {
            $bodyExists = isset($request->Body);
        } else {
            $bodyExists = isset($request->Body->{$requestRootName});
        }

        if ($bodyExists === false)
            HttpResponse::BadRequest("A request body must be provided in POST request", ErrorCodes::$RequestBodyNotFound);
    }

    /**
     * @param string $httpRequestType
     * @param string $methodRequestType
     */
    public static function CheckRequestType(string $httpRequestType, string $methodRequestType)
    {
        if ($httpRequestType !== "OPTIONS") {
            if ($httpRequestType !== $methodRequestType)
                HttpResponse::BadRequest("The requested resource does not support http method {$httpRequestType}", ErrorCodes::$RequestTypeMismatch);
        }else {
            Debug::Log($_SERVER['REQUEST_METHOD']);
        }
    }

    /**
     * @param object $object
     * @param array $fieldNames
     */
    public static function CheckRequirements(object $object, array $fieldNames)
    {
        $requiredFieldsErrorMessage = [];
        foreach ($fieldNames as $field) {
            if (!isset($object->{$field})) {
                array_push($requiredFieldsErrorMessage, "{$field} field is required");
            }
        }

        if (!empty($requiredFieldsErrorMessage))
            HttpResponse::BadRequest(implode(",", $requiredFieldsErrorMessage), ErrorCodes::$RequirementsNotPresented);
    }
    #endregion

    #region Private Methods
    #endregion

    #region Helpers
    #endregion

}
