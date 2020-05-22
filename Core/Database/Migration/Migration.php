<?php

namespace Core\Database\Migration;

use Core\Options\IDatabaseOption;

/**
 * Class Migration
 * @package Core\Migration
 */
class Migration
{
    #region Public Fields
    #endregion
    
    #region Private Fields
    #endregion

    #region Constructor
    /**
     * @param IDatabaseMigration $databaseMigration
     * @param IDatabaseOption $databaseOption
     */
    public function __construct(IDatabaseMigration $databaseMigration, IDatabaseOption $databaseOption)
    {
        $databaseMigration->AddUser($databaseOption->DbUser(), $databaseOption->DbPassword(), $databaseOption->Host());

        $databaseMigration->GrantUser($databaseOption->DbUser(), $databaseOption->Host(), $databaseOption->DBName());
        $databaseMigration->CreateDatabase($databaseOption->DBName(), $databaseOption->SchemaName(), $databaseOption->Collation());

        $databaseMigration->CreateTables($databaseOption->DBName(), $databaseOption->Collation());
    }
    #endregion

    #region Private Methods
    #endregion
    
    #region Helpers
    #endregion
}
