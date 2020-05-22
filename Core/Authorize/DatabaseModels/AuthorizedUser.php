<?php


namespace Core\Authorize\DatabaseModels;


/**
 * Class AuthorizedUser
 * @package Core\Database\Authorize
 */
class AuthorizedUser
{
    /**
     * @var int
     * |@dataType = bigint
     * |@autoIncrease = true
     * |@key = primary
     */
    public int $Id;

    /**
     * @var int
     * |@dataType = bigint
     * |@isNUllable = false
     */
    public int $UserId;
}