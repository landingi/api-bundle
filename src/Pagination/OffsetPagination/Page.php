<?php
declare(strict_types=1);

namespace Landingi\ApiBundle\Pagination\OffsetPagination;

final class Page
{
    private int $page;

    public function __construct(int $page)
    {
        $this->page = $page >= 1 ? $page : 1;
    }

    public function toInt(): int
    {
        return $this->page;
    }
}
