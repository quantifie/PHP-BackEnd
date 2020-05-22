<?php

namespace Core\Options;
	
/**
 * Class PathConfigs
 * @package Options
 */
class PathOption
{
	#region Public Fields
    #endregion
    
    #region Private Fields
    #endregion
    
    #region Constructor
    #endregion
    
    #region Public Methods
    #endregion
    
    #region Private Methods
    #endregion
    
    #region Helpers
    #endregion
    /**
     * Directory Separator
     */
    public string $Ds;

    /**
     * Application Root Path
     */
    public string $AppPath;
    /**
     * Log Path
     */
    public string $LogPath;
    
    public function __construct()
    {
        $this->Ds = DIRECTORY_SEPARATOR;
        $this->AppPath = "";
        $this->LogPath = $this->AppPath . "Core" . $this->Ds . "Log" . $this->Ds;
    }
}
