<?php
/**
 * Created by PhpStorm.
 * User: matthes
 * Date: 02.07.18
 * Time: 12:59
 */

namespace Phore\DbaMigrations;



use Phore\Dba\PhoreDba;

final class InitialMigration implements Migration
{

    /**
     * Minimum Version is 1 (InitialMigration)
     *
     * @return int
     */
    public function getVersion(): int
    {
        return 0;
    }

    public function up(PhoreDba $db)
    {
        throw new \InvalidArgumentException("called up() on InitialMigration.");
    }

    public function down(PhoreDba $db)
    {
        throw new \InvalidArgumentException("called down() on InitialMigration.");
    }

    public function getPredecessor(): Migration
    {
        throw new \InvalidArgumentException("called getPredecessor() on InitialMigration.");
    }
}