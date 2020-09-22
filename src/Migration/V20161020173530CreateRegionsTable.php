<?php

namespace Miaoxing\Region\Migration;

use Wei\Migration\BaseMigration;

class V20161020173530CreateRegionsTable extends BaseMigration
{
    public function up()
    {
        $this->schema->table('regions')
            ->id()
            ->int('parentId')
            ->string('name', 32)
            ->tinyInt('sort', 2)->comment('顺序,从大到小排列')
            ->index('parentId')
            ->index('name')
            ->exec();

        $file = dirname(dirname(__DIR__)) . '/resources/schemas/regions.sql';
        $this->db->executeUpdate(file_get_contents($file));
    }

    public function down()
    {
        $this->schema->dropIfExists('regions');
    }
}
