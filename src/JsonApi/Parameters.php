<?php
declare(strict_types=1);

namespace Landingi\ApiBundle\JsonApi;

interface Parameters
{
    public function getPage(): int;
    public function getLimit(): int;
    public function getOffset(): int;
    public function getSort(): array;
    public function getFilters(): array;
}
