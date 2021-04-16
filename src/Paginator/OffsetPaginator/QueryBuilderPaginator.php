<?php
declare(strict_types=1);

namespace Landingi\ApiBundle\Paginator\OffsetPaginator;

use Doctrine\DBAL\Query\QueryBuilder;
use Landingi\ApiBundle\Pagination\OffsetPagination\OffsetPagination;

interface QueryBuilderPaginator
{
    public function paginate(QueryBuilder $queryBuilder, OffsetPagination $pagination): QueryBuilder;

    public function count(QueryBuilder $queryBuilder): QueryBuilder;
}
