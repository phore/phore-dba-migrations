<?php
/**
 * Created by PhpStorm.
 * User: matthes
 * Date: 02.07.18
 * Time: 16:01
 */

namespace Phore\DbaMigrations\Registry;


use Phore\Dba\Ex\NoDataException;
use Phore\Dba\PhoreDba;
use Phore\DbaMigrations\MigrationRegistry;

class SqliteMigrationRegistry implements MigrationRegistry
{

    const REGISTRY_NAME = "__MigrationRegistry";
    const MANGER_CREATE_SQL = <<<EOT
        CREATE TABLE IF NOT EXISTS __MigrationRegistry (
            store_id TEXT NOT NULL,
            installed_version INTEGER NOT NULL,
            PRIMARY KEY (store_id)
        )
EOT;

    public function ensureInstalled(PhoreDba $dba)
    {
        echo "\nTrying to create Table";
        $dba->query(self::MANGER_CREATE_SQL);
        try {
            echo "\nLoading Head version";
            $row = $dba->query("SELECT * FROM ".self::REGISTRY_NAME
                ." WHERE store_id='HEAD'")->first();

        } catch (NoDataException $e) {
            //throw $e;
            echo "\nCreating registry (INSERT INTO...)";
            $dba->query("INSERT INTO " . self::REGISTRY_NAME . " (store_id, installed_version) VALUES ('HEAD', '0');");
        }
    }

    public function getInstalledVersion(PhoreDba $dba): int
    {
        $row = $dba->query("SELECT * FROM " . self::REGISTRY_NAME . " WHERE store_id='HEAD'")->first();
        return $row["installed_version"];
    }

    public function setInstalledVersion(PhoreDba $dba, int $newVersion)
    {
        echo "\nUpdating version to $newVersion";
        $dba->query("UPDATE " . self::REGISTRY_NAME . " SET installed_version = ? WHERE store_id='HEAD'", [$newVersion]);
    }
}