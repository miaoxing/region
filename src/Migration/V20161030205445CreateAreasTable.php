<?php

namespace Miaoxing\Region\Migration;

use miaoxing\plugin\BaseService;
use services\Scheme;
use Wei\Db;

/**
 * @property Scheme $scheme
 * @property Db $db
 */
class V20161030205445CreateAreasTable extends BaseService
{
    public function up()
    {
        $this->scheme->table('areas')
            ->id()
            ->int('parentId')
            ->string('name', 32)
            ->tinyInt('sort', 2)->comment('顺序,从大到小排列')
            ->index('parentId')
            ->index('name')
            ->exec();

        $file = dirname(dirname(__DIR__)) . '/resources/schemas/areas.sql';
        $this->db->query(file_get_contents($file));
    }

    public function down()
    {
        $this->scheme->dropIfExists('areas');
    }
}
