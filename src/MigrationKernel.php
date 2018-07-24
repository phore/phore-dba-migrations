<?php
/**
 * Created by PhpStorm.
 * User: matthes
 * Date: 02.07.18
 * Time: 14:26
 */

namespace Phore\DbaMigrations;



use Phore\Dba\PhoreDba;

class MigrationKernel
{
    private static $migrations = [];


    public static function _GetOnMigration ()
    {
        return self::$migrations;
    }


    public static function AddOnMigration (callable $fn)
    {
        self::$migrations[] = $fn;
    }

    public static function RunMigrations (PhoreDba $dba)
    {
        foreach (self::$migrations as $migration) {
            $migration($dba);
        }
    }

}