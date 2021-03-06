<?php
	declare(strict_types=1);

	namespace Framework\Application\UtilitiesV2\Conventions;

	/**
	 * Class ThemeData
	 *
	 * Automatically created at: 2019-05-01 15:57:52
	 */

	use Framework\Application\UtilitiesV2\Convention;

	/**
	 * Class ThemeData
	 * @package Framework\Application\UtilitiesV2\Conventions
	 * @property string name
	 * @property string description
	 * @property string author
	 * @property int version
	 * @property array data
	 */
	class ThemeData extends Convention
	{

		/**
		 * The syntax for requirements is as follows
		 *
		 *  "key" => "type"
		 *
		 * so for instance
		 *
		 *  "settings"  => "array"  : Specifies that this should be an array
		 *  "filename"  => "string" : Specifies that this should be a string
		 *  "admin"     => "bool"   : Specifies that this should be a bool
		 *  "admin"     => "int"    : Specifies that this should be a number
		 *  "dynamic"   => null     : Specifies that it is a "dynamic" field, thus may or may not have a value
		 * @var array
		 */

		protected $requirements = [
			"name" => "string",
			"description" => "string",
			"author" => "string",
			"website" => "string",
			"version" => "int",
			"data" => "dynamic"
		];
	}