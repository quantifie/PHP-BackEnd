<?php

namespace Core\Libs\Helpers;

use Core\Http\HttpResponse;
use Core\Options\PathOption;

/**
 * Class ApplicationUtils
 * @package Libs\Helpers
 */
abstract class ApplicationHelper
{
    #region Public Fields
    #endregion

    #region Private Fields
    #endregion

    #region Constructor
    #endregion

    #region Public Methods
    /**
     * Sets the environment base on choices
     * @param bool $isDevelopment
     * @param bool $reportErrors
     * @return void
     */
    public static function SetEnvironment(bool $isDevelopment, bool $reportErrors)
    {
        if ($isDevelopment) {
            self::ShowErrors();
        } else {
            self::HideErrors();
        }

        if ($reportErrors) {
            $pathOption = new PathOption();
            self::LogErrors($pathOption->LogPath, 'Errors.log');
        } else {
            self::DontLogErrors();
        }
    }

    /**
     * Shows errors on display (browser ui)
     * @return void
     */
    public static function ShowErrors()
    {
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
    }

    /**
     * Hides errors from display (browser ui)
     * @return void
     */
    public static function HideErrors()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        ini_set('display_startup_errors', 0);
    }

    /**
     * Enables the error logging and sets the path of log file
     * @param string $directory
     * @param string $fileName
     * @return void
     */
    public static function LogErrors(string $directory, string $fileName)
    {
        IOHelper::CheckFolder($directory);

        ini_set('log_errors', 1);
        ini_set('error_log', $directory . $fileName);
    }

    /**
     * Close the error logging
     * @return void
     */
    public static function DontLogErrors()
    {
        ini_set('log_errors', 0);
    }

    /**
     * Enables or disables CORS Headers
     * @param array $allowedOrigins
     * @return void
     */
    public static function EnableCORS(array $allowedOrigins)
    {

        if (count($allowedOrigins) <= 0)
            return;

        if (!isset($_SERVER["REMOTE_ADDR"]))
            HttpResponse::Forbidden("Remote Address did not resolved.", 403);

        if (array_search($_SERVER["REMOTE_ADDR"], $allowedOrigins) === false) {
            HttpResponse::Forbidden($_SERVER["REMOTE_ADDR"] . " is not allowed.", 403);
        }

        if (isset($_SERVER['HTTP_ORIGIN'])) {

            if (array_search($_SERVER["HTTP_ORIGIN"], $allowedOrigins) === false) {
                HttpResponse::Forbidden($_SERVER["HTTP_ORIGIN"] . " is not allowed.", 403);
            }
            // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
            // you want to allow, and if so:
            header("Access-Control-Allow-Origin: ". $_SERVER["HTTP_ORIGIN"]);
            header("Access-Control-Allow-Credentials: true");
            header("Access-Control-Allow-Methods: GET,POST,OPTIONS,DELETE,PUT");
            header("Access-Control-Max-Age: 86400");    // cache for 1 day
        }

        if (!isset($_SERVER["REQUEST_METHOD"]))
            return;

        // Access-Control headers are received during OPTIONS requests
        if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {

            if (isset($_SERVER["HTTP_ACCESS_CONTROL_REQUEST_METHOD"]))
                // may also be using PUT, PATCH, HEAD etc
                header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

            if (isset($_SERVER["HTTP_ACCESS_CONTROL_REQUEST_HEADERS"]))
                header("Access-Control-Allow-Headers: " . $_SERVER["HTTP_ACCESS_CONTROL_REQUEST_HEADERS"]);

            return;
        }
    }

    #endregion

    #region Private Methods
    #endregion

    #region Helpers
    #endregion


}
