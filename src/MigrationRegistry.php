<?php
/**
 * Created by PhpStorm.
 * User: matthes
 * Date: 02.07.18
 * Time: 16:00
 */

namespace Phore\DbaMigrations;


use Phore\Dba\PhoreDba;

interface MigrationRegistry
{

    public function ensureInstalled(PhoreDba $dba);

    public function getInstalledVersion(PhoreDba $dba) : int;

    public function setInstalledVersion(PhoreDba $dba, int $newVersion);

}