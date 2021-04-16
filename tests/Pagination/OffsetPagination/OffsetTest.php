<?php
declare(strict_types=1);

namespace Landingi\Tests\ApiBundle\Pagination\OffsetPagination;

use Generator;
use Landingi\ApiBundle\Pagination\OffsetPagination\Limit;
use Landingi\ApiBundle\Pagination\OffsetPagination\Offset;
use Landingi\ApiBundle\Pagination\OffsetPagination\Page;
use PHPUnit\Framework\TestCase;

class OffsetTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testToInt(int $page, int $limit, int $output): void
    {
        $this->assertEquals(
            $output,
            (new Offset(
                new Page($page),
                new Limit($limit)
            ))->toInt()
        );
    }

    public function dataProvider(): Generator
    {
        yield [$page = -1, $limit = -1, $offset = 0];
        yield [$page = 0, $limit = 0, $offset = 0];
        yield [$page = 1, $limit = 10, $offset = 0];
        yield [$page = 2, $limit = 10, $offset = 10];
        yield [$page = 3, $limit = 10, $offset = 20];
    }
}
