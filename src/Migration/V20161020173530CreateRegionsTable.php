<?php

namespace Miaoxing\Region\Migration;

use Wei\Migration\BaseMigration;

class V20161020173530CreateRegionsTable extends BaseMigration
{
    public function up()
    {
        $this->schema->table('regions')
            ->id()
            ->uInt('parent_id')
            ->string('name', 32)
            ->string('short_name', 32)
            ->uSmallInt('sort')->comment('顺序，从大到小排列')
            ->bool('has_children')
            ->index('parent_id')
            ->index('name')
            ->exec();

        $file = dirname(__DIR__, 2) . '/resources/schemas/regions.sql';
        $content = file_get_contents($file);
        $content = str_replace('%prefix%', $this->db->getTablePrefix(), $content);
        $this->db->executeUpdate($content);
    }

    public function down()
    {
        $this->schema->dropIfExists('regions');
    }
}
