<?php


namespace Core\Authorize\DatabaseModels;


/**
 * Class Authorize
 * @package Core\Database\Authorize
 */
class Authorize
{
    /**
     * @var int
     * |@dataType = bigint
     * |@autoIncrease = true
     * |@key = primary
     */
    public int $Id;

    /**
     * @var string
     * |@dataType = varchar(256)
     * |@isNullable = false
     * |@key = unique
     */
    public string $AccessToken;

    /**
     * @var string
     * |@dataType = datetime
     * |@isNullable = false
     * |@key = unique
     */
    public string $ExpiredDate;

    /**
     * @var int
     * |@dataType = bigint
     * |@isNullable = false
     */
    public int $UserId;
}