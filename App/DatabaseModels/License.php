<?php


namespace App\DatabaseModels;


/**
 * Class License
 * @package DatabaseModels
 */
class License
{
    /**
     * @var int
     * |@dataType = bigint
     * |@autoIncrement = true
     * |@key = primary
     */
    public int $Id;

    /**
     * @var bool
     * |@dataType = boolean
     * |@isNullable = false
     * |@default = false
     */
    public bool $Active;

    /**
     * @var string
     * |@dataType = datetime
     * |@isNullable = false
     */
    public string $CreationDate;

    /**
     * @var string
     * |@dataType = datetime
     * |@isNullable = false
     */
    public string $SubscriptionStartDate;

    /**
     * @var string
     * |@dataType = datetime
     * |@isNullable = false
     */
    public string $SubscriptionEndDate;
    
    /**
     * @var string
     * |@dataType = varchar(256)
     * |@isNullable = false
     */
    public string $LicenseToken;

    /**
     * @var string
     * |@dataType = smallint
     * |@isNullable = false
     */
    public string $Type;

    /**
     * @var int
     * |@dataType = bigint
     * |@isNullable = false
     * |@default = -1
     */
    public int $ManagerId;

    /**
     * @var int
     * |@dataType = smallint
     * |@isNullable = false
     * |@default = 0
     */
    public int $Count;

    /**
     * @var bool
     * |@dataType = tinyint(1)
     * |@isNullable = false
     * |@default = false
     */
    public bool $Deleted;

    /**
     * @var int
     * |@dataType = bigint
     * |@isNullable = false
     */
    public int $LicenseeId;

}
