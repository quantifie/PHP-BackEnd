<?php
	
	namespace Core\Database;


    /**
     * Class ColumnAnnotation
     * @package Core\Database
     */
    class TableColumnAnnotation extends TableColumnAnnotationBase
	{
        /**
         * @var string
         */
        public string $DataType ;

        /**
         * @var int
         */
        public ?int $Length ;

        /**
         * @var bool
         */
        public bool $IsNullable = false;

        /**
         * @var string
         */
        public ?string $Key ;

        /**
         * @var bool
         */
        public bool $AutoIncrement = false;

        /**
         * @var string
         */
        public string $DefaultValue;

        /**
         * @var bool
         */
        public bool $Indexed = false;

        /**
         * @var bool
         */
        public bool $NoSerialize = false;
	}
