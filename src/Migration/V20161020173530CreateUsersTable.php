<?php

namespace Miaoxing\Region\Migration;

use services\Scheme;

/**
 * @property Scheme $scheme
 */
class V20161020173530CreateUsersTable
{
    public function up()
    {
        $this->scheme->table('regions')
            ->id()
            ->integer('parentId')
            ->string('name', 32)
            ->tinyInteger('sort')->comment('顺序,从大到小排列')
            ->exec();
    }

    public function down()
    {
        $this->scheme->dropIfExists('users');
    }
}
