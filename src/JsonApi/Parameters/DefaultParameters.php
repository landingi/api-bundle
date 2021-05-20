<?php
declare(strict_types=1);

namespace Landingi\ApiBundle\JsonApi\Parameters;

use Landingi\ApiBundle\JsonApi\Parameters;

final class DefaultParameters implements Parameters
{
    public function __construct(
        private int $page,
        private int $limit,
        private array $sort = [],
        private array $filters = [],
    ) {
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function getOffset(): int
    {
        return ($this->page - 1) * $this->limit;
    }

    public function getSort(): array
    {
        return $this->sort;
    }

    public function getFilters(): array
    {
        return $this->filters;
    }
}
