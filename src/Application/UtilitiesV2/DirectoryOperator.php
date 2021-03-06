<?php
	declare(strict_types=1);
	/**
	 * Created by PhpStorm.
	 * User: lewis
	 * Date: 03/07/2018
	 * Time: 18:29
	 */

	namespace Framework\Application\UtilitiesV2;


	/**
	 * Class DirectoryOperator
	 * @package Framework\Application\UtilitiesV2
	 */
	class DirectoryOperator
	{

		/**
		 * @var string
		 */
		protected $path;
		/**
		 * @var array
		 */
		public $contents;

		/**
		 * DirectoryOperator constructor.
		 *
		 * @param $path
		 * @param bool $auto_read
		 *
		 * @throws \Error
		 */

		public function __construct($path, $auto_read = true)
		{

			//if( file_exists( SYSCRACK_ROOT . $path ) == false )
			//throw new \Error("Directory does not exist");

			if (is_file(SYSCRACK_ROOT . $path))
				throw new \Error("Path references file not directory");

			$this->path = $path;

			if ($auto_read)
				$this->read();
		}

		/**
		 * @return mixed
		 */

		public function get()
		{

			if ($this->hasContents() == false)
				$this->read();

			return ($this->contents);
		}

		/**
		 * @param $path
		 * @param bool $reread
		 */

		public function setPath($path, $reread = true)
		{

			$this->path = $path;

			if ($reread)
				$this->read();
		}

		/**
		 * @return string
		 */

		public function path()
		{

			return ($this->path);
		}

		/**
		 * @return array|null
		 * @throws \Error
		 */

		public function getDirs()
		{

			return ($this->scrape(true));
		}

		/**
		 * @param $file
		 * @param string $extension
		 *
		 * @return bool
		 */

		public function has($file, $extension = ".json")
		{

			if (count(explode(".", $file)) == 1)
				$file = $file . $extension;

			$array = json_decode(json_encode($this->contents), true);

			foreach ($array as $key => $value)
				if ($value == SYSCRACK_ROOT . $this->path . $file)
					return true;

			return false;
		}

		/**
		 * @param $file
		 * @param string $extension
		 * @param bool $array
		 *
		 * @return mixed|null
		 */

		public function getJson($file, $extension = ".json", $array = true)
		{

			if (count(explode(".", $file)) == 1)
				$file = $file . $extension;

			foreach ($this->contents as $path => $content)
			{

				if ($content == SYSCRACK_ROOT . $this->path . $file)
				{

					return json_decode(file_get_contents(SYSCRACK_ROOT . $this->path . $file), $array);
				}
			}


			return null;
		}

		/**
		 * @param array $extension
		 *
		 * @return array
		 * @throws \Error
		 */

		public function search(array $extension = [".js"])
		{

			if (is_array($extension) == false)
				throw new \Error();


			if ($this->hasContents() == false)
				$this->read();

			if (empty($this->contents))
				return null;

			$results = [];

			foreach ($this->contents as $path => $content)
			{

				foreach ($extension as $item)
				{

					if (strpos($content, $item) !== false )
						$results[] = $content;
				}
			}

			return ($results);
		}

		/**
		 * @throws \Error
		 */

		public function read()
		{

			$this->contents = $this->scrape();
		}

		/**
		 * @return bool
		 * @throws \Error
		 */

		public function isEmpty()
		{

			if (empty($this->scrape()))
				return true;

			return false;
		}


		/**
		 * @return bool
		 * @throws \Error
		 */

		public function hasDirs()
		{

			if (empty($this->scrape(true)))
				return false;

			return true;
		}

		/**
		 * @param array $results
		 * @param bool $path
		 *
		 * @return array
		 */

		public function omit(array $results, $path = true)
		{

			foreach ($results as $key => $value)
			{

				if ($path)
					$results[$key] = str_replace(SYSCRACK_ROOT . $this->path, "", $value);
				else
					$results[$key] = str_replace(SYSCRACK_ROOT, "", $value);
			}

			return ($results);
		}

		/**
		 * @return bool
		 */

		private function hasContents()
		{

			return (empty($this->contents));
		}

		/**
		 * @param bool $dir_only
		 *
		 * @return array|null
		 * @throws \Error
		 */

		private function scrape($dir_only = false)
		{

			Debug::message("Scrapping Path: " . $this->path);

			if ($dir_only)
				$options = GLOB_ONLYDIR;
			else
				$options = 0;

			$contents = glob(SYSCRACK_ROOT . $this->path . "*", $options);

			if (empty($contents))
				return null;

			return ($contents);
		}
	}