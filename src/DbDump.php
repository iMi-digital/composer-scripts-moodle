<?php

namespace IMI\ComposerScriptsMoodle;

use IMI\DatabaseHelper\Mysql;
use IMI\DatabaseHelper\Operations\Dump;
use Symfony\Component\Yaml\Yaml;

class DbDump
{

    /**
     * Read DB parameters and dump database to master, stripping tables
     *
     * Reads env DUMP_STRIP_ADDITIONAL (string, space separated list)
     */
    public static function dumpToMaster()
    {
        global $CFG;
        require_once __DIR__ . '/../../../config.php';

        $mysql = new Mysql([
            'host' => $CFG->dbhost,
            'username' => $CFG->dbuser,
            'password' => $CFG->dbpass,
            'dbname' => $CFG->dbname
        ]);

        $dump = new Dump($mysql);
        $dump->setStrip('mdl_log mdl_log_display mdl_log_queries mdl_lock_db ' . getenv('DUMP_STRIP_ADDITIONAL'));
        $dump->setFilename('sql/master.sql');
        $dump->setAddTime('no');

        foreach ($dump->createExec()->getCommands() as $command) {
            echo $command . PHP_EOL;
            shell_exec($command);
        }
    }
}