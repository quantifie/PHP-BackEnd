<?php
	
namespace Core\Log;

use Core\Database\DbContext;
use Core\Database\ITableProxy;
use Core\Libs\Helpers\DateTime;
use Exception;

/**
 * Class Logger
 * @package Core\Log
 */
class MysqlLogger implements ILogger
{
	#region Public Fields
    #endregion
    
    #region Private Fields
    private ITableProxy $loggerTable;
    #endregion
    
    #region Constructor
    public function __construct(ITableProxy $loggerTable)
    {
        $this->loggerTable = $loggerTable;
    }
    #endregion
    
    #region Public Methods
    /**
     * @param string $title
     * @param string $message
     * @param string $priority
     * @param string $type
     * @param string $comment
     * @return object
     */
    public function Write(string $title,
                                 string $message,
                                 string $priority,
                                 string $type,
                                 string $comment )
	{
		if ( !isset( $title ) || empty( $title ) ) {
			new Exception( "Log Title can not be empty." );
		}
		
		if ( !isset( $message ) || empty( $message ) ) {
			new Exception( "Log Message can not be empty." );
		}
		
		if ( !isset( $type ) || empty( $type ) ) {
			new Exception( "Log Type can not be empty." );
		}
		
		if ( !isset( $priority ) || empty( $priority ) ) {
			new Exception( "Log Priority can not be empty." );
		}


        return $this->loggerTable->Insert( [
			"Title" => $title,
			"Message" => $message,
			"Type" => $type,
			"Time" => DateTime::Now(),
			"Priority" => $priority,
			"Comment" => $comment
		] );
	}
    #endregion
    
    #region Private Methods
    #endregion
    
    #region Helpers
    #endregion
    
}
