<?php
declare(strict_types=1);

namespace Landingi\ApiBundle\ArgumentResolver;

use Generator;
use Landingi\ApiBundle\JsonApi\Parameters;
use Landingi\ApiBundle\JsonApi\ParametersFactory\DefaultParametersFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

final class JsonApiParametersResolver implements ArgumentValueResolverInterface
{
    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        return Parameters::class === $argument->getType();
    }

    public function resolve(Request $request, ArgumentMetadata $argument): Generator
    {
        yield (new DefaultParametersFactory())->create($request);
    }
}
