<?php
declare(strict_types=1);

namespace Landingi\ApiBundle\ArgumentResolver;

use Generator;
use Landingi\ApiBundle\Pagination\OffsetPagination\Limit;
use Landingi\ApiBundle\Pagination\OffsetPagination\OffsetPagination;
use Landingi\ApiBundle\Pagination\OffsetPagination\Page;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

final class OffsetPaginationResolver implements ArgumentValueResolverInterface
{
    public function __construct(private int $defaultLimit)
    {
    }

    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        return OffsetPagination::class === $argument->getType();
    }

    public function resolve(Request $request, ArgumentMetadata $argument): Generator
    {
        yield new OffsetPagination(
            new Page($request->query->getInt('page', 1)),
            new Limit($request->query->getInt('limit', $this->defaultLimit)),
        );
    }
}
