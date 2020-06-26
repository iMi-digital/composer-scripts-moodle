<?php

namespace IMI\ComposerScriptsMoodle;

use IMI\DatabaseHelper\Mysql;
use IMI\DatabaseHelper\Operations\Dump;
use Symfony\Component\Yaml\Yaml;

class DbDump extends AbstractCommand
{

    /**
     * Read DB parameters and dump database to master, stripping tables
     *
     * Reads env DUMP_STRIP_ADDITIONAL (string, space separated list) or NONE to not strip anything
     */
    public static function dump()
    {
        $dump = new Dump(self::getDatabaseInstance());

        if (getenv('DUMP_STRIP_ADDITIONAL') !== 'NONE') {
            $dump->setStrip('mdl_log mdl_log_display mdl_log_queries ' . getenv('DUMP_STRIP_ADDITIONAL'));
        }
        $dump->setFilename(getenv('DUMP_FILE_NAME') ?? 'sql/master.sql');
        $dump->setAddTime('no');

        foreach ($dump->createExec()->getCommands() as $command) {
            echo $command . PHP_EOL;
            shell_exec($command);
        }
    }
}