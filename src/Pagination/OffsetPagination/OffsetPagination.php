<?php
declare(strict_types=1);

namespace Landingi\ApiBundle\Pagination\OffsetPagination;

final class OffsetPagination
{
    private Page $page;
    private Limit $limit;
    private Offset $offset;

    public function __construct(
        Page $page,
        Limit $limit,
    ) {
        $this->page = $page;
        $this->limit = $limit;
        $this->offset = new Offset($page, $limit);
    }

    public function getPage(): Page
    {
        return $this->page;
    }

    public function getLimit(): Limit
    {
        return $this->limit;
    }

    public function getOffset(): Offset
    {
        return $this->offset;
    }
}
