<?php
declare(strict_types=1);

namespace Landingi\ApiBundle\Doctrine;

use Doctrine\DBAL\Query\QueryBuilder;

interface Query
{
    public function getResult(QueryBuilder $queryBuilder): array;
}
