<?php

namespace Miaoxing\Region\Migration;

use miaoxing\plugin\BaseService;
use services\Scheme;

/**
 * @property Scheme $scheme
 */
class V20161030205445CreateAreasTable extends BaseService
{
    public function up()
    {
        $this->scheme->table('area2')
            ->id()
            ->int('parentId')
            ->string('name', 32)
            ->tinyInt('sort', 2)->comment('顺序,从大到小排列')
            ->exec();
    }

    public function down()
    {
        $this->scheme->dropIfExists('area2');
    }
}
