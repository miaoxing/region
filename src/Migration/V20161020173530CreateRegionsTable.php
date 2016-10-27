<?php

namespace Miaoxing\Region\Migration;

use miaoxing\plugin\BaseService;
use services\Scheme;

/**
 * @property Scheme $scheme
 */
class V20161020173530CreateRegionsTable extends BaseService
{
    public function up()
    {
        $this->scheme->table('regions2')
            ->id()
            ->int('parentId')
            ->string('name', 32)
            ->tinyInt('sort', 2)->comment('顺序,从大到小排列')
            ->exec();
    }

    public function down()
    {
        $this->scheme->dropIfExists('regions2');
    }
}
