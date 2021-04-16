<?php
declare(strict_types=1);

namespace Landingi\Tests\ApiBundle\Fake\Doctrine;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver;
use Doctrine\DBAL\Driver\API\ExceptionConverter;
use Doctrine\DBAL\Driver\Connection as DriverConnection;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Schema\AbstractSchemaManager;

final class FakeDriver implements Driver
{
    public function connect(array $params): DriverConnection
    {
    }

    public function getDatabasePlatform(): AbstractPlatform
    {
    }

    public function getSchemaManager(Connection $conn, AbstractPlatform $platform): AbstractSchemaManager
    {
    }

    public function getExceptionConverter(): ExceptionConverter
    {
    }
}
