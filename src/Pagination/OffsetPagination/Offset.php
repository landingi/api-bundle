<?php
declare(strict_types=1);

namespace Landingi\ApiBundle\Pagination\OffsetPagination;

final class Offset
{
    private int $offset;

    public function __construct(Page $page, Limit $limit)
    {
        $this->offset = ($page->toInt() - 1) * $limit->toInt();
    }

    public function toInt(): int
    {
        return $this->offset;
    }
}
