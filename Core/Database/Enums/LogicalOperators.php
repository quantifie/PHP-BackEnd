<?php
	
	/**
	 * LogicalOperator Types
	 *
	 * PHP version 7
	 *
	 * LICENSE: This source file is subject to version 3 of the GPL license
	 * that is available through the world-wide-web at the following URI:
	 * https://www.gnu.org/licenses/gpl-3.0.en.html.
	 * If you did not receive a copy of
	 * the GPL License and are unable to obtain it through the web, please
	 * send a note to licence@oyazicioglu.com so we can mail you a copy immediately.
	 *
	 * @category   PHP
	 * @package    Metropolis City Showcase
	 * @author     Ömer YAZICIOĞLU <info@oyazicioglu.com>
	 * @copyright  2005-2019 Ömer YAZICIOĞLU
	 * @license    https://www.gnu.org/licenses/lgpl-3.0.html  LGPL License 3.0
	 * @version    SVN: $Id$
	 * @since      File available since Release 2.0
	 * @deprecated File deprecated in Release 0.0
	 */
	
	namespace Core\Database\Enums;

    /**
     * Class LogicalOperators
     * @package Core\Database\Enums
     */
    abstract class LogicalOperators
	{
        /**
         * @var string
         */
        public static string $And = 'AND';
        /**
         * @var string
         */
        public static string $Or = 'OR';
	}
