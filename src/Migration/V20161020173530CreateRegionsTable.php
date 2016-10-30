<?php

namespace Miaoxing\Region\Migration;

use miaoxing\plugin\BaseService;
use services\Scheme;
use Wei\Db;

/**
 * @property Scheme $scheme
 * @property Db $db
 */
class V20161020173530CreateRegionsTable extends BaseService
{
    public function up()
    {
        $this->scheme->table('regions')
            ->id()
            ->int('parentId')
            ->string('name', 32)
            ->tinyInt('sort', 2)->comment('顺序,从大到小排列')
            ->exec();

        //$file = dirname(dirname(__DIR__)) . '/resources/schemas/regions.sql';
        //$this->db->executeUpdate(file_get_contents($file));
    }

    public function down()
    {
        $this->scheme->dropIfExists('regions');
    }
}
