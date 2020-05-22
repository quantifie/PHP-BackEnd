<?php

namespace Core\Database;



use Core\Log\Log;

/**
 * Class DbContext
 * @package Core
 */
class DbContext
{
    #region Public Methods
    public ITableProxy $Logs;
    public ITableProxy $Authorizes;
    #endregion
    
    #region Constructor
    public function __construct()
    {
        $this->Logs = new MysqlTableProxy(Log::class);
        //$this->Authorizes = new MysqlTableProxy(Authorize::class);
    }
    #endregion

}
