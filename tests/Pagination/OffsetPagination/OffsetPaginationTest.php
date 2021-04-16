<?php
declare(strict_types=1);

namespace Landingi\Tests\ApiBundle\Pagination\OffsetPagination;

use Landingi\ApiBundle\Pagination\OffsetPagination\Limit;
use Landingi\ApiBundle\Pagination\OffsetPagination\Offset;
use Landingi\ApiBundle\Pagination\OffsetPagination\OffsetPagination;
use Landingi\ApiBundle\Pagination\OffsetPagination\Page;
use PHPUnit\Framework\TestCase;

class OffsetPaginationTest extends TestCase
{
    public function testGetPage(): void
    {
        $pagination = new OffsetPagination(
            new Page(1),
            new Limit(10),
        );
        $this->assertEquals(
            new Page(1),
            $pagination->getPage()
        );
    }

    public function testGetLimit(): void
    {
        $pagination = new OffsetPagination(
            new Page(1),
            new Limit(10),
        );
        $this->assertEquals(
            new Limit(10),
            $pagination->getLimit()
        );
    }

    public function testGetOffset(): void
    {
        $pagination = new OffsetPagination(
            new Page(1),
            new Limit(10),
        );
        $this->assertEquals(
            new Offset(
                new Page(1),
                new Limit(10),
            ),
            $pagination->getOffset()
        );
    }
}
