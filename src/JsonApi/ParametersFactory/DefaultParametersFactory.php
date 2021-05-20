<?php
declare(strict_types=1);

namespace Landingi\ApiBundle\JsonApi\ParametersFactory;

use InvalidArgumentException;
use Landingi\ApiBundle\JsonApi\Parameters;
use Landingi\ApiBundle\JsonApi\Parameters\DefaultParameters;
use Landingi\ApiBundle\JsonApi\ParametersFactory;
use Symfony\Component\HttpFoundation\Request;

final class DefaultParametersFactory implements ParametersFactory
{
    public function create(Request $request): Parameters
    {
        $pagination = is_array($request->get('page')) ? $request->get('page') : [];
        $sort = [];

        foreach (explode(',', $request->get('sort', '')) as $field) {
            if (!$field) {
                continue;
            }

            $direction = 'ASC';

            if (str_starts_with($field, '-')) {
                $direction = 'DESC';
                $field = ltrim($field, $field[0]);
            }

            try {
                $sort[(string) new MemberName($field)] = $direction;
            } catch (InvalidArgumentException $e) {
                continue;
            }
        }

        return new DefaultParameters(
            max((int) ($pagination['number'] ?? 1), 1),
            max(min((int) ($pagination['limit'] ?? 10), 100), 10),
            $sort
        );
    }
}
