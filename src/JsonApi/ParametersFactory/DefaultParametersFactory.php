<?php
declare(strict_types=1);

namespace Landingi\ApiBundle\JsonApi\ParametersFactory;

use Landingi\ApiBundle\JsonApi\Parameters;
use Landingi\ApiBundle\JsonApi\Parameters\DefaultParameters;
use Landingi\ApiBundle\JsonApi\ParametersFactory;
use Symfony\Component\HttpFoundation\Request;

final class DefaultParametersFactory implements ParametersFactory
{
    public function create(Request $request): Parameters
    {
        $pagination = $request->get('page');

        if (false === is_array($pagination)) {
            $pagination = [];
        }

        return new DefaultParameters(
            max((int) ($pagination['number'] ?? 1), 1),
            max(min((int) ($pagination['limit'] ?? 10), 100), 10)
        );
    }
}
