<?php
declare(strict_types=1);

namespace Landingi\Tests\ApiBundle\Paginator\OffsetPaginator\QueryBuilderPaginator;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use Landingi\ApiBundle\Pagination\OffsetPagination\Limit;
use Landingi\ApiBundle\Pagination\OffsetPagination\OffsetPagination;
use Landingi\ApiBundle\Pagination\OffsetPagination\Page;
use Landingi\ApiBundle\Paginator\OffsetPaginator\QueryBuilderPaginator\SimpleQueryBuilderPaginator;
use Landingi\Tests\ApiBundle\Fake\Doctrine\FakeDriver;
use PHPUnit\Framework\TestCase;

class SimpleQueryBuilderPaginatorTest extends TestCase
{
    public function testPaginateQuery(): void
    {
        $query = new QueryBuilder(
            new Connection(
                [],
                new FakeDriver()
            )
        );
        $paginator = new SimpleQueryBuilderPaginator();
        $pagination = new OffsetPagination(
            new Page(4),
            new Limit(10)
        );
        $paginatedQuery = $paginator->paginate($query, $pagination);
        $this->assertEquals(
            0,
            $query->getMaxResults()
        );
        $this->assertEquals(
            0,
            $query->getFirstResult()
        );
        $this->assertEquals(
            10,
            $paginatedQuery->getMaxResults()
        );
        $this->assertEquals(
            30,
            $paginatedQuery->getFirstResult()
        );
    }

    public function testCountQuery(): void
    {
        $query = new QueryBuilder(
            new Connection(
                [],
                new FakeDriver()
            )
        );
        $query->select('column');
        $query->from('table');
        $paginator = new SimpleQueryBuilderPaginator();
        $countQuery = $paginator->count($query);
        $this->assertEquals(
            'SELECT column FROM table',
            $query
        );
        $this->assertEquals(
            'SELECT COUNT(1) FROM (SELECT column FROM table) AS derived_table',
            $countQuery
        );
    }
}
