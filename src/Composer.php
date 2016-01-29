<?php

namespace PhRest;

use \Composer\Script\Event,

    \PhRest\Config\Local,
    \PhRest\Config\Local\Database,
    \PhRest\Config\Local\Security;

/**
 * Class Composer
 * @package PhRest
 */
class Composer {

    /**
     * @param Event $event
     */
    public static function postInstall(Event $event) {
        $io = $event->getIO();

        $adapter = $io->askAndValidate(
            '<info>Enter database adapter (Default to Postgresql)</info> [<comment>Mysql, Postgresql</comment>]: ',
            function ($argument) {
                if (in_array($argument, ['Mysql', 'Postgresql'])) {
                    return $argument;
                }
                throw new \Exception('This is not a valid answer. Please choose Mysql or Postgresql.');
            },
            10,
            'Postgresql'
        );
        $host = $io->ask(
            '<info>Enter database host (Default to localhost)</info>: ',
            'localhost'
        );
        $user = $io->ask(
            '<info>Enter database username</info>: ',
            function ($argument) {
                if ($argument) {
                    return $argument;
                }
                throw new \Exception('This is not a valid answer. User name can\'t be empty');
            },
            10
        );
        $password = $io->ask(
            '<info>Enter database password (Default to "")</info>: ',
            ''
        );
        $live = $io->askAndValidate(
            '<info>Enter live database name</info>: ',
            function ($argument) {
                if ($argument) {
                    return $argument;
                }
                throw new \Exception('This is not a valid answer. Database name can\'t be empty');
            },
            10
        );
        $test = $io->askAndValidate(
            '<info>Enter test database name</info>: ',
            function ($argument) {
                if ($argument) {
                    return $argument;
                }
                throw new \Exception('This is not a valid answer. Database name can\'t be empty');
            },
            10
        );

        self::createConfig($user, $live, $test, $password, $adapter, $host);
    }

    /**
     * @param string $user
     * @param string $live
     * @param string $test
     * @param string $password
     * @param string $adapter
     * @param string $host
     * @return Local
     */
    private static function createConfig($user, $live, $test, $password, $adapter, $host) {
        return (new Local(
            new Database($user, $live, $test, $password, $adapter, $host),
            new Security()
        ))->save();
    }

}