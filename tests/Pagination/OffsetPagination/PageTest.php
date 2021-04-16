<?php
declare(strict_types=1);

namespace Landingi\Tests\ApiBundle\Pagination\OffsetPagination;

use Generator;
use Landingi\ApiBundle\Pagination\OffsetPagination\Page;
use PHPUnit\Framework\TestCase;

class PageTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testToInt(int $input, int $output): void
    {
        $this->assertEquals(
            $output,
            (new Page($input))->toInt()
        );
    }

    public function dataProvider(): Generator
    {
        yield [$input = -1, $output = 1];
        yield [$input = 0, $output = 1];
        yield [$input = 1, $output = 1];
        yield [$input = 10, $output = 10];
    }
}
