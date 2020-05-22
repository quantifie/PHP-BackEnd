<?php


namespace Core\Http;


use Core\DataModels\CoreResponse;
use Core\DataModels\CoreResponseModel;
use Core\DataModels\IResponse;
use Core\Options\ApplicationOptionFactory;

/**
 * Class Response
 * @package Core\Http
 */
class HttpResponse
{
    /**
     * @param IResponse $response
     * @param CoreResponse|null $additionalObject
     */
    public static function Ok(CoreResponse $additionalObject = null)
    {
        http_response_code(200);

        if (isset($additionalObject)){
            if (gettype($additionalObject) === CoreResponse::class){
                $additionalObject->SetMessage("Ok");
                $additionalObject->SetNumber(0);
            }
            die(json_encode($additionalObject, JSON_NUMERIC_CHECK));
        } else {
            die(json_encode(self::CreateResponse("Ok", 0, "Ok"), JSON_NUMERIC_CHECK));
        }
    }

    /**
     * @param string $message
     * @param int $number
     */
    public static function Error(string $message, int $number)
    {
        http_response_code(500);
        die(json_encode(self::CreateResponse($message, $number, "Internal Server Error"), JSON_NUMERIC_CHECK));
    }

    /**
     * @param string $message
     * @param int $number
     */
    public static function BadRequest(string $message, int $number)
    {
        http_response_code(400);
        die(json_encode(self::CreateResponse($message, $number, "Bad Request"), JSON_NUMERIC_CHECK));
    }

    /**
     * @param string $message
     * @param int $number
     */
    public static function NotFound(string $message, int $number)
    {
        http_response_code(404);
        die(json_encode(self::CreateResponse($message, $number, "Not Found"), JSON_NUMERIC_CHECK));
    }

    /**
     * @param string $message
     * @param int $number
     */
    public static function Forbidden(string $message, int $number) {
        http_response_code(403);
        die(json_encode(self::CreateResponse($message, $number, "Forbidden"), JSON_NUMERIC_CHECK));
    }

    /**
     * @param string $message
     * @param int $number
     * @param string $productionErrorMessage
     * @return CoreResponseModel
     */
    private static function CreateResponse(string $message, int $number, $productionErrorMessage): CoreResponseModel {
        $applicationOption = new ApplicationOptionFactory();
        $errorMessage = $applicationOption->Get()->IsDevelopment() === true ? $message : $productionErrorMessage;

        $response = new CoreResponse($number, $errorMessage);
        return $response->Object();
    }
}