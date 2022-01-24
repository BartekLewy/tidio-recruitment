<?php

declare(strict_types=1);

namespace Payroll\Tests\PayrollReport\UserInterface\Http;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PayrollReportControllerTest extends WebTestCase
{
    /**
     * @test
     */
    public function shouldRespondWithHttpStatusOk(): void
    {
        $client = $this->createClient();
        $client->request('GET', '/');

        self::assertResponseIsSuccessful();
    }

    public function shouldRespondWithCorrectStructure(): void
    {
        $client = $this->createClient();
        $client->request('GET', '/');

        self::assertIsArray($client->getResponse());
    }
}