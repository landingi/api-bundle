<?php
declare(strict_types=1);

namespace Landingi\ApiBundle\Pagination\OffsetPagination;

final class Limit
{
    private int $limit;

    public function __construct(int $limit)
    {
        $this->limit = $limit >= 0 ? $limit : 10;
    }

    public function toInt(): int
    {
        return $this->limit;
    }
}
