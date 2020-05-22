<?php


namespace App;


use App\DatabaseModels\License;
use Core\Database\DbContext;
use Core\Database\ITableProxy;
use Core\Database\MysqlTableProxy;

class ApplicationDbContext extends DbContext
{
    public ITableProxy $Licenses;

    public function __construct()
    {
        parent::__construct();

        $this->Licenses = new MysqlTableProxy(License::class);
    }
}