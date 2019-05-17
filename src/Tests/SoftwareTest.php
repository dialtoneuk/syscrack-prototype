<?php
	/**
	 * Created by PhpStorm.
	 * User: newsy
	 * Date: 05/05/2019
	 * Time: 17:11
	 */

	namespace Framework\Tests;

	use Framework\Syscrack\Game\Software;

	class SoftwareTest extends BaseTestCase
	{

		/**
		 * @var Software
		 */

		protected static $software;

		/**
		 * @var int
		 */

		protected static $softwareid;

		/**
		 * @var int
		 */

		protected static $userid = 1;

		/**
		 * @var int
		 */

		protected static $computerid = 1000;

		public static function setUpBeforeClass(): void
		{

			if( isset( self::$software ) == false )
				self::$software = new Software();

			parent::setUpBeforeClass();
		}

		public static function tearDownAfterClass(): void
		{

			self::$software->deleteSoftware(self::$softwareid);
			parent::tearDownAfterClass();
		}


		public function testCreateSoftware()
		{

			$softwareid = self::$software->createSoftware("Text", self::$userid, self::$computerid);
			$this->assertIsNumeric($softwareid);

			self::$softwareid = $softwareid;
		}

		public function testGetSoftware()
		{

			$this->assertNotEmpty(self::$software->getSoftware(self::$softwareid));
		}
	}
