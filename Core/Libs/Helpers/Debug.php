<?php

namespace Core\Libs\Helpers;
	
/**
 * Class Log
 * @package Libs\Helpers
 */
abstract class Debug
{
	#region Public Fields
    #endregion
    
    #region Private Fields
    #endregion
    
    #region Constructor
    #endregion
    
    #region Public Methods
    /**
	 * @param $message
	 */
	public static function Log( $message )
	{
	    http_response_code(200);
        header("Content-Type: application/json");
        echo json_encode($message, JSON_NUMERIC_CHECK);
	}
    #endregion
    
    #region Private Methods
    #endregion
    
    #region Helpers
    #endregion
	
}
