<?php
/**
 * Created by PhpStorm.
 * User: matthes
 * Date: 02.07.18
 * Time: 12:58
 */

namespace Phore\DbaMigrations;



use Phore\Dba\PhoreDba;

interface Migration
{
    /**
     * Minimum Version is 1 (InitialMigration)
     *
     * @return int
     */
    public function getVersion() : int;
    public function up(PhoreDba $db);
    public function down(PhoreDba $db);
    public function getPredecessor() : Migration;
}