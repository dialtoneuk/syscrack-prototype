<?php
    namespace Framework\Syscrack\Game\Computers;

    /**
     * Lewis Lancaster 2017
     *
     * Class Vpc
     *
     * @package Framework\Syscrack\Game\Computer
     */

    use Framework\Exceptions\SyscrackException;
    use Framework\Syscrack\Game\AccountDatabase;
    use Framework\Syscrack\Game\AddressDatabase;

    use Framework\Syscrack\Game\BaseClasses\BaseComputer;

    class Vpc extends BaseComputer
    {

        /**
         * @var AddressDatabase
         */

        protected static $addressdatabase;

        /**
         * @var AccountDatabase
         */

        protected static $accountdatabase;

        /**
         * Vpc constructor.
         */

        public function __construct()
        {

            if( isset( self::$addressdatabase ) == false )
                self::$addressdatabase = new AddressDatabase();


            if( isset( self::$accountdatabase ) == false )
                self::$accountdatabase = new AccountDatabase();

            parent::__construct( true );
        }

        /**
         * The configuration
         *
         * @return array
         */

        public function configuration()
        {

            return array(
                'installable'   => true,
                'type'          => 'vpc'
            );
        }

        /**
         * @param $computerid
         * @param $userid
         * @param array $software
         * @param array $hardware
         * @param array $custom
         */

        public function onStartup($computerid, $userid, array $software = [], array $hardware = [], array $custom = [])
        {

            if( self::$addressdatabase->hasDatabase( $userid ) == false )
                self::$addressdatabase->saveDatabase( $userid );

            if( self::$accountdatabase->hasDatabase( $userid ) == false )
                self::$accountdatabase->saveDatabase( $userid, [] );

            parent::onStartup( $computerid, $userid, $software, $hardware, $custom );
        }

        /**
         * What to do on reset
         *
         * @param $computerid
         */

        public function onReset($computerid)
        {

            $userid = $this->computer->getComputer( $computerid )->userid;

            if( self::$addressdatabase->hasDatabase( $userid ) == false )
                self::$addressdatabase->saveDatabase( $userid, [] );

            if( self::$accountdatabase->hasDatabase( $userid ) == false )
                self::$accountdatabase->saveDatabase( $userid, [] );

            parent::onReset( $computerid );
        }

        /**
         * What to do on login
         *
         * @param $computerid
         *
         * @param $ipaddress
         */

        public function onLogin($computerid, $ipaddress)
        {

            if( self::$internet->ipExists( $ipaddress ) == false )
                throw new SyscrackException();

            self::$internet->setCurrentConnectedAddress( $ipaddress );

            $this->log( $computerid, 'Logged in as root', $this->getCurrentComputerAddress() );
            $this->logToIP( $this->getCurrentComputerAddress(), 'Logged in as root at <' . $ipaddress . '>');
        }

        /**
         * What do on logout
         *
         * @param $computerid
         *
         * @param $ipaddress
         */

        public function onLogout($computerid, $ipaddress)
        {

            if( self::$internet->ipExists( $ipaddress ) == false )
                throw new SyscrackException();

            self::$internet->setCurrentConnectedAddress( null );
        }
    }