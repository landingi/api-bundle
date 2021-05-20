<?php
declare(strict_types=1);

namespace Landingi\ApiBundle\JsonApi;

use Symfony\Component\HttpFoundation\Request;

interface ParametersFactory
{
    public function create(Request $request): Parameters;
}
