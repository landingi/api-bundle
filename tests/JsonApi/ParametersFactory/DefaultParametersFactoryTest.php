<?php
declare(strict_types=1);

namespace Landingi\Tests\ApiBundle\JsonApi\ParametersFactory;

use Generator;
use Landingi\ApiBundle\JsonApi\ParametersFactory\DefaultParametersFactory;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

class DefaultParametersFactoryTest extends TestCase
{
    /**
     * @dataProvider pageUriProvider
     */
    public function testPagination(int $page, int $limit, int $offset, string $uri): void
    {
        // arrange
        $request = Request::create($uri);
        $factory = new DefaultParametersFactory();

        // act
        $parameters = $factory->create($request);

        // assert
        $this->assertEquals(
            $page,
            $parameters->getPage()
        );
        $this->assertEquals(
            $limit,
            $parameters->getLimit()
        );
        $this->assertEquals(
            $offset,
            $parameters->getOffset()
        );
        $this->assertEmpty(
            $parameters->getSort()
        );
        $this->assertEmpty(
            $parameters->getFilters()
        );
    }

    public function pageUriProvider(): Generator
    {
        yield [$page = 1, $limit = 10, $offset = 0, '?page[number]=foo&page[limit]=bar'];
        yield [$page = 1, $limit = 10, $offset = 0, '?page[number]=-1&page[limit]=-1'];
        yield [$page = 1, $limit = 10, $offset = 0, '?page[number]=0&page[limit]=0'];
        yield [$page = 1, $limit = 100, $offset = 0, "?page[number]=$page&page[limit]=999"];
        yield [$page = 1, $limit = 10, $offset = 0, "?page[number]=$page&page[limit]=$limit"];
        yield [$page = 2, $limit = 10, $offset = 10, "?page[number]=$page&page[limit]=$limit"];
        yield [$page = 3, $limit = 10, $offset = 20, "?page[number]=$page&page[limit]=$limit"];
        yield [$page = 1, $limit = 20, $offset = 0, "?page[number]=$page&page[limit]=$limit"];
        yield [$page = 2, $limit = 20, $offset = 20, "?page[number]=$page&page[limit]=$limit"];
        yield [$page = 3, $limit = 20, $offset = 40, "?page[number]=$page&page[limit]=$limit"];
    }

    /**
     * @dataProvider sortUriProvider
     */
    public function testSort(array $sort, string $uri): void
    {
        // arrange
        $request = Request::create($uri);
        $factory = new DefaultParametersFactory();

        // act
        $parameters = $factory->create($request);

        // assert
        $this->assertEquals(
            $sort,
            $parameters->getSort()
        );
    }

    public function sortUriProvider(): Generator
    {
        yield [$sort = [], ''];
        yield [$sort = [], '?sort= '];
        yield [$sort = [], '?sort=,,'];
        yield [$sort = [], '?sort=-,-,'];
        yield [$sort = [], '?sort=-name-,-age-'];
        yield [$sort = ['name' => 'ASC'], '?sort=name,_age'];
        yield [$sort = ['name' => 'ASC', 'age' => 'ASC'], '?sort=name,age'];
        yield [$sort = ['name' => 'DESC', 'age' => 'DESC'], '?sort=-name,-age'];
        yield [$sort = ['name' => 'ASC', 'age' => 'DESC'], '?sort=name,-age,'];
    }
}
