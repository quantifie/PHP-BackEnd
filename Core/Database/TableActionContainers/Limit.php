<?php
	
	namespace Core\Database\TableActionContainers;
	
	/**
	 * Class Limit
	 * @package Libs\Enums
	 */
	class Limit
	{
        /**
         * @var int
         */
        public int $Limit;

        /**
         * @var int
         */
        public int $Offset;

        /**
         * Limit constructor.
         * @param int $limit
         * @param int $offset
         */
        public function __construct(int $limit, int $offset )
		{
			$this->Limit = $limit;
			$this->Offset = $offset;
		}
	}
