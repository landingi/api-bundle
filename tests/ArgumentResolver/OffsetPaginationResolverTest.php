<?php
declare(strict_types=1);

namespace Landingi\Tests\ApiBundle\ArgumentResolver;

use Landingi\ApiBundle\ArgumentResolver\OffsetPaginationResolver;
use Landingi\ApiBundle\Pagination\OffsetPagination\Limit;
use Landingi\ApiBundle\Pagination\OffsetPagination\OffsetPagination;
use Landingi\ApiBundle\Pagination\OffsetPagination\Page;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class OffsetPaginationResolverTest extends TestCase
{
    public function testSupportsOffsetPagination(): void
    {
        $resolver = new OffsetPaginationResolver(10);
        $request = new Request();
        $metaData = new ArgumentMetadata(
            $name = 'any',
            $type = OffsetPagination::class,
            $isVariadic = (bool) random_int(0, 1),
            $hasDefaultValue = (bool) random_int(0, 1),
            $defaultValue = null
        );
        $this->assertTrue(
            $resolver->supports(
                $request,
                 $metaData
            )
        );
    }

    public function testItCreatesOffsetPaginationFromQueryStringParams(): void
    {
        $metaData = new ArgumentMetadata(
            $name = 'any',
            $type = OffsetPagination::class,
            $isVariadic = (bool) random_int(0, 1),
            $hasDefaultValue = (bool) random_int(0, 1),
            $defaultValue = null
        );
        $resolver = new OffsetPaginationResolver(30);
        $request = new Request([
            'page' => 1,
            'limit' => 10,
        ]);
        $generator = $resolver->resolve($request, $metaData);
        $this->assertEquals(
            new OffsetPagination(
                new Page(1),
                new Limit(10)
            ),
            $generator->current()
        );
    }

    public function testItUsesDefaultLimitAndDefaultPage(): void
    {
        $metaData = new ArgumentMetadata(
            $name = 'any',
            $type = OffsetPagination::class,
            $isVariadic = (bool) random_int(0, 1),
            $hasDefaultValue = (bool) random_int(0, 1),
            $defaultValue = null
        );
        $resolver = new OffsetPaginationResolver(30);
        $request = new Request();
        $generator = $resolver->resolve($request, $metaData);
        $this->assertEquals(
            new OffsetPagination(
                new Page(1),
                new Limit(30)
            ),
            $generator->current()
        );
    }
}
