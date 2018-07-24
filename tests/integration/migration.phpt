<?php

namespace Test;

use Phore\Dba\PhoreDba;
use Phore\DbaMigrations\InitialMigration;
use Phore\DbaMigrations\Migration;
use Phore\DbaMigrations\MigrationKernel;
use Phore\DbaMigrations\MigrationManager;
use Phore\DbaMigrations\Registry\SqliteMigrationRegistry;

require_once __DIR__ . "/../../vendor/autoload.php";


class __Migration_1 implements Migration
{

    public function getVersion(): int
    {
        return 1;
    }

    public function up(PhoreDba $db)
    {
        $db->query('CREATE TABLE Service (
            serviceId TEXT PRIMARY KEY NOT NULL
            
        );');

        $db->query('CREATE TABLE ServiceDomain (
            domain TEXT PRIMARY KEY NOT NULL,
            serviceId TEXT
        );');
    }

    public function down(PhoreDba $db)
    {
        $db->query("DROP Table Service");
        $db->query("DROP TABLE ServiceDomain");
    }

    public function getPredecessor(): Migration
    {
        return new InitialMigration();
    }
}


MigrationKernel::AddOnMigration(function () {
    $mm = new MigrationManager(new SqliteMigrationRegistry());
    $mm->upgrade(PhoreDba::Get(), new __Migration_1());
});


MigrationKernel::RunMigrations(PhoreDba::InitDSN("sqlite:/tmp/demo.db3"));

