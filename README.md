# api-bundle

Automates and simplify API development.

## Installation

1. To `config/packages` add `landingi_api.yaml` with following content
```yaml
landingi_api:
    pagination:
        default_limit: 10

```

2. To `config/bundles.php` add:
```php
Landingi\ApiBundle\LandingiApiBundle::class => ['all' => true]
```

## Usage

- ### use built in Symfony Action Argument Resolving (recommended)
The simplest way to get and use `OffsetPagination` object is to declare it as controller's action argument

See official [Symfony docs](https://symfony.com/doc/current/controller/argument_value_resolver.html)

```php
use Landingi\ApiBundle\Pagination\Offset\OffsetPagination;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class MyController
{
    #[Route('/index', name: 'Index')]
    public function index(OffsetPagination $pagination): Response
    {
        // your beautiful code...
    }
}
```

- ### create `OffsetPagination` object manually
```php
use Landingi\ApiBundle\Pagination\Offset\Limit;
use Landingi\ApiBundle\Pagination\Offset\OffsetPagination;
use Landingi\ApiBundle\Pagination\Offset\Page;

$pagination = new OffsetPagination(
    new Page(1),
    new Limit(10),
);
```

## How it works?
Just add `?page=1&limit=10` to query string (if `limit` is skipped the `default_limit` value is used from `landingi_api.yaml`)
