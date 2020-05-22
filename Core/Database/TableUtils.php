<?php


namespace Core\Database;


use Core\Database\Enums\KeyValueOperators;

/**
 * Class TableUtils
 * @package Core\Database
 */
abstract class TableUtils
{
	#region Public Fields
    #endregion
    
    #region Private Fields
    #endregion
    
    #region Constructor
    #endregion
    
    #region Public Methods
    /**
     * Checks the given email address is exists
     *
     * @param MysqlTableProxy $table
     * @param string $columnName
     * @param string|int|bool|double $value
     * @return bool
     */
    public static function RecordExists(MysqlTableProxy $table, string $columnName, $value)
    {
        $select = $table->Select([$columnName])
            ->Where($columnName, KeyValueOperators::$Equal, $value)
            ->Single();

        return $select === false ? false : true;
    }
    
    /**
     * @param bool $value
     * @return string
     */
    public static function BoolToText(bool $value)
    {
        if ($value === true)
            return "YES";
        else {
            return "NO";
        }
    }

    /**
     * @param string $columnKeyType
     * @return string
     */
    public static function ColumnKeyToKeyType(string $columnKeyType): string
    {
        switch ($columnKeyType) {
            case "primary":
                return "PRIMARY KEY";
            case "unique":
                return "UNIQUE";
            case "multiply":
                return "MULTIPLE";
            default:
                return "";
        }
    }
    #endregion
    
    #region Private Methods
    #endregion
    
    #region Helpers
    #endregion
}
