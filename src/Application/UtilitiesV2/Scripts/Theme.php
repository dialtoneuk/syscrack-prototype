<?php
	namespace Framework\Application\UtilitiesV2\Scripts;

	use Framework\Syscrack\Game\Themes;
	use Framework\Application\Settings;
	use Framework\Application\UtilitiesV2\Debug;

	/**
	 * Class Theme
	 *
	 * Automatically created at: 2019-05-18 06:09:22
	 */

	class Theme extends Base
	{

		/**
		 * @var Themes
		 */

		protected static $themes;

		/**
		 * Theme constructor.
		 */

		public function __construct()
		{

			if( isset( self::$themes ) == false )
				self::$themes = new Themes( true );

			parent::__construct();
		}

		/**
	     * The logic of your script goes in this function.
	     *
	     * @param $arguments
	     * @return bool
	     */

	    public function execute($arguments)
	    {

	        if( isset( $arguments["theme"] ) == false )
	            $theme = Settings::setting('theme_default');
	        else
	            $theme = $arguments["theme"];

	        if( self::$themes->themeExists( $theme ) == false )
	            return( $this->error('Theme does not exist:' . $theme ) );

	        self::$themes->set( $theme );
			Debug::echo('Theme set to: ' . $theme );

	        return parent::execute($arguments); // TODO: Change the autogenerated stub
	    }

	    /**
	     * The help index can either be a string or an array containing a set of strings. You can only put strings in
	     * there.
	     *
	     * @return array
	     */

	    public function help()
	    {
	        return([
	            "arguments" => $this->requiredArguments(),
	            "help" => "Hello World"
	        ]);
	    }

	    /**
	     * Example:
	     *  [
	     *      "file"
	     *      "name"
	     *  ]
	     *
	     *  View from the console:
	     *      Theme file=myfile.php name=no_space
	     *
	     * @return array|null
	     */

	    public function requiredArguments()
	    {

	        return parent::requiredArguments();
	    }
	}