<?php
	
	namespace Core\Database\TableActionContainers;
	
	/**
	 * Class Column
	 * @package Libs\Enums
	 */
	class Column
	{
        /**
         * @var string
         */
        public string $Name;

        /**
         * @var string
         */
        public string $Alias;

        /**
         * Column constructor.
         * @param string $name
         * @param string $alias
         */
        public function __construct(string $name, string $alias )
		{
			$this->Name = $name;
			$this->Alias = $alias;
		}
	}
