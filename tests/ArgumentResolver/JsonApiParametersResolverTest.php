<?php
declare(strict_types=1);

namespace Landingi\Tests\ApiBundle\ArgumentResolver;

use Landingi\ApiBundle\ArgumentResolver\JsonApiParametersResolver;
use Landingi\ApiBundle\JsonApi\Parameters;
use Landingi\ApiBundle\JsonApi\ParametersFactory\DefaultParametersFactory;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class JsonApiParametersResolverTest extends TestCase
{
    public function testSupportsParameters(): void
    {
        $resolver = new JsonApiParametersResolver();
        $request = new Request();
        $metaData = new ArgumentMetadata(
            $name = 'any',
            $type = Parameters::class,
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

    public function testCreatesParameters(): void
    {
        $resolver = new JsonApiParametersResolver();
        $request = new Request();
        $metaData = new ArgumentMetadata(
            $name = 'any',
            $type = Parameters::class,
            $isVariadic = (bool) random_int(0, 1),
            $hasDefaultValue = (bool) random_int(0, 1),
            $defaultValue = null
        );
        $factory = new DefaultParametersFactory();
        $this->assertEquals(
            $factory->create($request),
            $resolver->resolve($request, $metaData)->current()
        );
    }
}
