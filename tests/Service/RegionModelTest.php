<?php

namespace MiaoxingTest\Service;

use Miaoxing\Plugin\Test\BaseTestCase;
use Miaoxing\Region\Service\RegionModel;

class RegionModelTest extends BaseTestCase
{
    /**
     * @dataProvider providerForGetShortName
     * @param mixed $attributes
     * @param mixed $shortName
     */
    public function testGetShortName($attributes, $shortName)
    {
        $region = RegionModel::new($attributes);
        $this->assertSame($shortName, $region->shortName);
    }

    public static function providerForGetShortName(): array
    {
        return [
            [
                [
                    'name' => 'Long name',
                    'shortName' => 'Short name',
                ],
                'Short name',
            ],
            [
                [
                    'name' => 'Long name',
                ],
                'Long name',
            ],
            [
                [
                    'name' => 'Long name',
                    'shortName' => '',
                ],
                'Long name',
            ],
            [
                [
                    'name' => 'Long name',
                    'shortName' => null,
                ],
                'Long name',
            ],
        ];
    }
}
