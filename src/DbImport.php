<?php

namespace IMI\ComposerScriptsMoodle;

use IMI\DatabaseHelper\Mysql;
use IMI\DatabaseHelper\Operations\Dump;
use IMI\DatabaseHelper\Operations\Import;
use Symfony\Component\Yaml\Yaml;

class DbImport extends AbstractCommand
{

    /**
     * Read DB parameters and dump database to master, stripping tables
     *
     * Reads env DUMP_STRIP_ADDITIONAL (string, space separated list)
     */
    public static function import()
    {
        $dump = new Import(self::getDatabaseInstance());
        $dump->setIsPipeViewerAvailable(true);
        $dump->setFilename(getenv('DUMP_FILE_NAME') ?? 'sql/master.sql');

        foreach ($dump->createExec()->getCommands() as $command) {
            echo $command . PHP_EOL;
            shell_exec($command);
        }
    }
}