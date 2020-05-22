<?php
	
namespace Core\Security;

/**
 * Class Encryption
 * @package Libs\Security
 */
abstract class Encryption
{
	#region Public Fields
    #endregion
    
    #region Private Fields
    #endregion
    
    #region Constructor
    #endregion
    
    #region Public Methods
    /**
	 * @param $data
	 * @return false|string
	 */
	public static function Encrypt( $data )
	{
		$options = [
			'cost' => 12
		];
		return password_hash( $data, PASSWORD_DEFAULT, $options );
	}
	
	/**
	 * @param $data
	 * @param $hash
	 * @return bool
	 */
	public static function Verify( $data, $hash )
	{
		return password_verify( $data, $hash );
	}
    #endregion
    
    #region Private Methods
    #endregion
    
    #region Helpers
    #endregion
	
}
