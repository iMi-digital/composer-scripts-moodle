<?php

namespace IMI\ComposerScriptsMoodle;

use IMI\DatabaseHelper\Mysql;
use IMI\DatabaseHelper\Operations\Dump;
use Symfony\Component\Yaml\Yaml;

class AbstractCommand
{

    public static function loadConfigToGlobal()
    {
        global $CFG;

        $cwd = getcwd();
        define('CLI_SCRIPT', true);
        require_once __DIR__ . '/../../../../config.php';
        chdir($cwd); // moodle seems to change the directory

    }

    public static function getDatabaseInstance()
    {
        global $CFG;

        self::loadConfigToGlobal();;

        $mysql = new Mysql([
            'host' => $CFG->dbhost,
            'username' => $CFG->dbuser,
            'password' => $CFG->dbpass,
            'dbname' => $CFG->dbname
        ]);

        return $mysql;
    }
}