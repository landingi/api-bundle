<?php
declare(strict_types=1);

namespace Landingi\ApiBundle\Paginator\OffsetPaginator\QueryBuilderPaginator;

use Doctrine\DBAL\Query\QueryBuilder;
use Landingi\ApiBundle\Pagination\OffsetPagination\OffsetPagination;
use Landingi\ApiBundle\Paginator\OffsetPaginator\QueryBuilderPaginator;

final class SimpleQueryBuilderPaginator implements QueryBuilderPaginator
{
    public function paginate(QueryBuilder $queryBuilder, OffsetPagination $pagination): QueryBuilder
    {
        $clonedQueryBuilder = clone $queryBuilder;
        $clonedQueryBuilder->setFirstResult(
            $pagination->getOffset()->toInt()
        );
        $clonedQueryBuilder->setMaxResults(
            $pagination->getLimit()->toInt()
        );

        return $clonedQueryBuilder;
    }

    public function count(QueryBuilder $queryBuilder): QueryBuilder
    {
        $clonedQueryBuilder = clone $queryBuilder;
        $clonedQueryBuilder->select("COUNT(1) FROM ({$queryBuilder->getSQL()}) AS derived_table");
        $clonedQueryBuilder->resetQueryPart('from');

        return $clonedQueryBuilder;
    }
}
