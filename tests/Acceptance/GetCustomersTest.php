<?php

declare(strict_types=1);

namespace Brammm\TestingWorkshop\Acceptance;

use Fig\Http\Message\StatusCodeInterface;
use Spatie\Snapshots\MatchesSnapshots;

final class GetCustomersTest extends AcceptanceTestCase
{
    use MatchesSnapshots;

    public function testItReturnsTheCorrectResponse(): void
    {
        $response = $this->get('/customers');

        self::assertEquals(StatusCodeInterface::STATUS_OK, $response->getStatusCode());
        $this->assertMatchesJsonSnapshot((string) $response->getBody());
    }
}
