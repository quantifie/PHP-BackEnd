<?php

namespace Core\Libs\Helpers;
	
use Exception;

/**
 * Class IOHelper
 * @package Libs\IO
 */
abstract class IOHelper
{
	#region Public Fields
    #endregion
    
    #region Private Fields
    #endregion
    
    #region Constructor
    #endregion
    
    #region Public Methods
    /**
	 * Check if the folder exists
	 * and if not create the folder
	 *
	 * @param string $folderPath
	 * @param bool $createIfNotExist
	 * @return bool
	 */
	public static function CheckFolder( $folderPath, $createIfNotExist = true ): bool
	{
		// Check if $folderPath exist
		if ( is_dir( $folderPath ) ) {
			return true;
		}
		
		// Check if $folderPath is a file name
		if ( file_exists( $folderPath ) ) {
			return false;
		}
		
		// Check if $createIfNotExist is true ? create new folder
		if ( $createIfNotExist ) {
			if(!self::CreateFolder( $folderPath, 0777 ))
				{return false;}
		}
		
		return false;
	}
	
	/**
	 * Creates folder with given path
	 *
	 * @param string $path
	 * @param int $mode
	 * @return bool
	 */
	public static function CreateFolder( string $path, int $mode ): bool
	{
		if ( !mkdir( $path, $mode, true ) ) {
			return false;
		} else {
			return true;
		}
	}
	
	/**
    * @param string $fileSignature
    * @param string $uploadDirectory
    * @param string $fileName
    * @return bool
    */
	public static function UploadFile(string $fileSignature, string $uploadDirectory, string $fileName = "") {
	    $fileName = $fileName === "" ? $_FILES[$fileSignature]["name"] : $fileName;

        if(!isset($uploadDirectory) || $uploadDirectory === "") {
            return false;
        }

        if(!self::CheckFolder($uploadDirectory))
        {
            return false;
        }
        
        $uploadedFile = $uploadDirectory . DIRECTORY_SEPARATOR . $fileName;
	    
        if (!move_uploaded_file($_FILES[$fileSignature]['tmp_name'], $uploadedFile)){
            return false;
        }
        
        return true;
    }

    public static function DownloadFile(string $filePath) {
	    return file_get_contents($filePath);
    }

    /**
     * @param string $fileName
     * @param string $content
     * @return bool
     */
    public static function SaveFileBase64(string $fileName, string $content){
	    if (!isset($fileName) || !isset($content))
	        return false;


        if ($fileName === "" || $content === "")
            return false;

        $splittedData = explode(",", $content);
        try {
            file_put_contents($fileName, base64_decode($splittedData[1]));
            return true;
        }catch (Exception $e) {
            return false;
        }
    }
    #endregion
    
    #region Private Methods
    #endregion
    
    #region Helpers
    #endregion
	
}
