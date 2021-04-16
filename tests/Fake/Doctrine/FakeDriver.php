<?php
declare(strict_types=1);

namespace Landingi\Tests\ApiBundle\Fake\Doctrine;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver;

final class FakeDriver implements Driver
{
    public function getName()
    {
    }

    public function getDatabase(Connection $conn)
    {
    }

    public function connect(array $params, $username = null, $password = null, array $driverOptions = [])
    {
    }

    public function getDatabasePlatform()
    {
    }

    public function getSchemaManager(Connection $conn)
    {
    }
}
