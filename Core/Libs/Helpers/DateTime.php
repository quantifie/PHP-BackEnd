<?php

namespace Core\Libs\Helpers;
	
use Exception;

/**
 * Class Date
 * @package Libs\Helpers
 */
abstract class DateTime
{
	#region Public Fields
    #endregion
    
    #region Private Fields
    #endregion
    
    #region Constructor
    #endregion
    
    #region Public Methods
    /**
	 * @return false|string
	 */
	public static function Now()
	{
		return date( "Y-m-d H:i:s" );
	}
	
	/**
	 * @return false|string
	 */
	public static function Day()
	{
		return date( "Y-m-d" );
	}
	
	/**
	 * @return false|string
	 */
	public static function Time()
	{
		return date( "H:i:s:ms" );
	}

	public static function Convert(string $date, string $fromFormat, string $toFormat) {
        try {
            $resultDate =\DateTime::createFromFormat($fromFormat, $date);
            return $resultDate->format($toFormat);
        } catch (Exception $e) {
            return $date;
        }
    }
    #endregion
    
    #region Private Methods
    #endregion
    
    #region Helpers
    #endregion
	
}
