<?php
declare(strict_types=1);

namespace Landingi\Tests\ApiBundle\JsonApi\ParametersFactory;

use Generator;
use InvalidArgumentException;
use Landingi\ApiBundle\JsonApi\ParametersFactory\MemberName;
use PHPUnit\Framework\TestCase;

class MemberNameTest extends TestCase
{
    /**
     * @dataProvider allowedNamesProvider
     * @doesNotPerformAssertions
     */
    public function testAllowed(string $name): void
    {
        new MemberName($name);
    }

    public function allowedNamesProvider(): Generator
    {
        yield ['foo'];
        yield ['foo-bar'];
        yield ['foo_bar'];
    }

    /**
     * @dataProvider notAllowedNamesProvider
     */
    public function testNotAllowed(string $name): void
    {
        $this->expectExceptionObject(
            new InvalidArgumentException(
                'Given member name contains not allowed characters'
            )
        );
        new MemberName($name);
    }

    public function notAllowedNamesProvider(): Generator
    {
        yield [''];
        yield [' '];
        yield ['-'];
        yield ['_'];
        yield ['_foo'];
        yield ['foo_'];
        yield ['-foo'];
        yield ['foo-'];
        yield ["\t"];
        yield ["\r"];
        yield ["\n"];
    }
}
