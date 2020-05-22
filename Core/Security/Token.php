<?php

namespace Core\Security;
	
/**
 * Class Token
 * @package Libs\Security
 */
abstract class Token
{
	#region Public Fields
    #endregion
    
    #region Private Fields
    #endregion
    
    #region Constructor
    #endregion
    
    #region Public Methods
    /**
	 * @param int $length
	 * @return string
	 */
	public static function Create( $length = 24 )
	{
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen( $characters );
		$randomString = '';
		for ( $i = 0; $i < $length; $i++ ) {
			$randomString .= $characters[ rand( 0, $charactersLength - 1 ) ];
		}
		return $randomString;
	}
    #endregion
    
    #region Private Methods
    #endregion
    
    #region Helpers
    #endregion
	
}
