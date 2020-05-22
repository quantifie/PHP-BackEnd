<?php

namespace Core\Log;

use DateTime;

/**
 * Class Log
 * @package Models
 */
class Log
{
    /**
     * @var int
     * |@dataType = bigint
     * |@key = primary
     * |@autoIncrement = true
     */
    public int $Id;

    /**
     * @var string
     * |@dataType = varchar(64)
     * |@isNullable = false
     */
    public string $Title;

    /**
     * @var string
     * |@dataType = varchar(32)
     * |@isNullable = true
     */
    public string $Type;

    /**
     * @var string
     * |@dataType = varchar(1024)
     * |@isNullable = false
     */
    public string $Message;

    /**
     * @var DateTime
     * |@dataType = DateTime
     * |@isNullable = false
     * |@default = '2019-01-01'
     */
    public DateTime $Time;

    /**
     * @var string
     * |@dataType = varchar(32)
     * |@isNUllable = true
     */
    public string $Priority;

    /**
     * @var string
     * |@dataType = varchar(512)
     * |@isNullable = true
     */
    public string $Comment;

}
