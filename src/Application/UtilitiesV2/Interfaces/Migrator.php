<?php
	declare(strict_types=1);
	/**
	 * Created by PhpStorm.
	 * User: lewis
	 * Date: 20/07/2018
	 * Time: 18:54
	 */

	namespace Framework\Application\UtilitiesV2\Interfaces;


	/**
	 * Interface Migrator
	 * @package Framework\Application\UtilitiesV2\Interfaces
	 */
	interface Migrator
	{

		public function migrate();
	}