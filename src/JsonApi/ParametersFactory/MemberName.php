<?php
declare(strict_types=1);

namespace Landingi\ApiBundle\JsonApi\ParametersFactory;

use InvalidArgumentException;

final class MemberName
{
    public function __construct(private string $name)
    {
        if (!preg_match('/^[A-Za-z0-9]([A-Za-z0-9_-]*[A-Za-z0-9])?$/', $name)) {
            throw new InvalidArgumentException('Given member name contains not allowed characters');
        }
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
