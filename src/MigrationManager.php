<?php
/**
 * Created by PhpStorm.
 * User: matthes
 * Date: 02.07.18
 * Time: 12:49
 */

namespace Phore\DbaMigrations;



use Phore\Dba\PhoreDba;

class MigrationManager
{

    /**
     * @var MigrationRegistry
     */
    private $migrationRegistry;

    public function __construct(MigrationRegistry $migrationRegistry)
    {
        $this->migrationRegistry = $migrationRegistry;
    }

    /**
     * @param Migration $headMigration
     * @param int       $fromVersion
     *
     * @return Migration[]
     */
    private function getMigrations (Migration $headMigration, $fromVersion=0)
    {
        $migrations = [];
        $curMigration = $headMigration;
        while ( ! $curMigration instanceof InitialMigration) {
            if ($curMigration->getVersion() > $fromVersion) {
                $migrations[] = $curMigration;
            }
            $curMigration = $curMigration->getPredecessor();
        }
        return array_reverse($migrations);
    }


    public function upgrade (PhoreDba $dba, Migration $headMigration)
    {

        $this->migrationRegistry->ensureInstalled($dba);

        $curInstalledVersion = $this->migrationRegistry->getInstalledVersion($dba);
        $migrations = $this->getMigrations($headMigration, $curInstalledVersion);
        if (count ($migrations) == 0) {
            return;
        }
        //echo "\nInstalled Version: $curInstalledVersion - Target-Version: {$headMigration->getVersion()}";
        foreach ($migrations as $curMigration) {

            //echo "\nRunning migration: ". get_class($curMigration) . "->up()";
            if ($curMigration->getVersion() == 0)
                throw new \InvalidArgumentException("Version number must be bigger than '0'");
            $curMigration->up($dba);
        }

        //echo "\nMigration done. Writing version.";
        $this->migrationRegistry->setInstalledVersion($dba, $curMigration->getVersion());
    }

}