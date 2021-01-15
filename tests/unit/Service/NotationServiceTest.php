<?php

namespace App\Tests\unit\Service;

use App\Repository\NotationRepository;
use App\Service\NotationService;
use Codeception\Stub;
use Codeception\Test\Unit;
use Exception;
use ReflectionMethod;

/**
 * Class NotationServiceTest.
 *
 * @internal
 * @coversNothing
 */
class NotationServiceTest extends Unit
{
    //region Before

    /**
     * @codingStandardsIgnoreStart
     *
     * @throws Exception
     */
    protected function _before()
    {
    }

    //endregion

    //region Tests

    /**
     * @covers       \App\Service\NotationService::getAvgUsers
     * @dataProvider providerGetAvgUsers
     *
     * @param array $data
     * @param array $expected
     *
     * @throws Exception
     */
    public function testAvgUsers(array $data, array $expected)
    {
        $notationRepository = Stub::make(NotationRepository::class, [
            'findUsersHaveNotation' => Stub\Expected::once($data),
        ], $this);

        $notationService = Stub::make(NotationService::class, [
            'notationRepository' => $notationRepository,
            'getAvgUser' => Stub::consecutive(['avg' => 5], ['avg' => 4], ['avg' => 3], ['avg' => 2], ['avg' => 1]),
        ], $this);

        $method = new ReflectionMethod(get_class($notationService), 'getAvgUsers');
        $method->setAccessible(true);

        $actual = $method->invoke($notationService);
        $this->assertEquals($expected, $actual);
    }

    //endregion

    //region dataProvider

    /**
     * @return iterable
     */
    public static function providerGetAvgUsers(): iterable
    {
        return [
            'case empty' => [
                'data' => [],
                'expected' => [],
            ],
            'case One user' => [
                'data' => [['id' => 1]],
                'expected' => ['avg' => 5],
            ],
            'case many users' => [
                'data' => [['id' => 1], ['id' => 2], ['id' => 3], ['id' => 4], ['id' => 5]],
                'expected' => ['avg' => 3],
            ],
        ];
    }

    //endregion
}
