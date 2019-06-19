<?php
	declare(strict_types=1);

	namespace Framework\Application\UtilitiesV2\Scripts;

	/**
	 * Created by PhpStorm.
	 * User: lewis
	 * Date: 25/08/2018
	 * Time: 17:15
	 */

	use Framework\Application\UtilitiesV2\Debug;
	use Framework\Application\UtilitiesV2\Makers;
	use Framework\Application\UtilitiesV2\TokenReader;

	/**
	 * Class Make
	 * @package Framework\Application\UtilitiesV2\Scripts
	 */
	class Make extends Base
	{

		/**
		 * @var Makers
		 */

		protected static $makers;

		/**
		 * Make constructor.
		 */

		public static function setup()
		{

			if( isset( self::$makers ) == false )
				self::$makers = new Makers();

			parent::setup();
		}

		/**
		 * @param $arguments
		 *
		 * @return bool
		 * @throws \Exception
		 */

		public function execute($arguments)
		{

			
			$keys = array_keys($arguments);

			if (isset($keys[0]) == false)
				if (isset($arguments["make"]))
					$classname = $arguments["make"];
				else
					throw new \Error("please include a class name");
			else
				$classname = $keys[0];

			array_shift($arguments);

			if (self::$makers->exist($classname) == false)
				throw new \Error("script does not exist: " . $classname);

			$required = self::$makers->getRequiredTokens($classname);

			if (empty($required) == false)
			{

				if (isset($arguments["arguments"]) == false)
				{

					$keys = array_keys($arguments);

					if (isset($keys[0]) == false)
						throw new \Error("arguments not present");
					else
					{

						if ($keys[0] == $classname)
							array_shift($keys[0]);

						foreach ($required as $key => $item)
							if (isset($keys[$key]))
								$arguments[$item] = $keys[$key];
							else
							{

								if ($item == "namespace")
									$arguments[$item] = self::$makers->getNamespace( $classname );

								if ($item == "classname")
									$arguments[$item] = "MyClass";
							}
					}
				}
				else
					$arguments = array_merge($arguments, $this->parse($arguments));

				$tokens = TokenReader::dataInstance([
					"values" => $arguments
				]);
			}
			else
				$tokens = TokenReader::dataInstance([
					null
				]);

			if (isset($arguments["path"]) == false)
				$path = self::$makers->getFilepath( $classname );
			else
				$path = $arguments["path"];

			$path = $path . $arguments["classname"] . ".php";

			if (file_exists($path))
				throw new \Error("file exists! unsafe to make class.");

			try
			{

				$result = self::$makers->process($tokens, ucfirst( $classname ), $path);

				if (empty($result) || $result == null)
					throw new \Exception("object passed was null but file could have still been made");

				Debug::echo("\n[SUCCESS!] File created! " . $result->path . "\n");
			} catch (\Exception $e)
			{

				Debug::echo("[FAILED] Failed to create file!");
				throw $e;
			}

			return parent::execute($arguments); // TODO: Change the autogenerated stub
		}

		/**
		 * @return array
		 */

		public function help()
		{

			return ([
				"arguments" => [
					"[type] Refers to what kind of thing to make. [autoexec:collection:convention:page:script]",
					"[classname] The name of the class (Case Sensitive).",
					"[namespace:optional] Specify a custom namespace.",
					"[path:optional] Specify a custom output path."
				],
				"help" => [
					"Creates class based based off of a template. Useful when developing. Supports a wide range of class types",
					"such as Computers, Softwares and Scripts."
				]
			]);
		}

		/**
		 * @return array|null
		 */

		public function requiredArguments()
		{

			return ([]);
		}
	}