<?php

declare(strict_types=1);

namespace Payroll\Tests\PayrollReport\UserInterface\Http;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

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

    /**
     * @test
     */
    public function shouldRespondWithBadRequestWhenFilterIsNotSupported(): void
    {
        $client = $this->createClient();
        $client->request('GET', '/?filter[non-supported-file]=value');

        self::assertEquals(
            '{"error":"Field non-supported-file is not valid filter.","code":1002}',
            $client->getResponse()->getContent()
        );
        self::assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
    }


    /**
     * @test
     */
    public function shouldRespondWithBadRequestWhenSortIsNotSupported(): void
    {
        $client = $this->createClient();
        $client->request('GET', '/?sort[non-supported-file]=ASC');

        self::assertEquals(
            '{"error":"Field non-supported-file is not supported for sorting","code":1000}',
            $client->getResponse()->getContent()
        );
        self::assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
    }

    /**
     * @test
     */
    public function shouldRespondWithBadRequestWhenSortOrderIsNotSupported(): void
    {
        $client = $this->createClient();
        $client->request('GET', '/?sort[firstName]=sdf');

        self::assertEquals(
            '{"error":"Invlid sort order applied, use ASC or DESC instead","code":1001}',
            $client->getResponse()->getContent()
        );
        self::assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
    }

    /**
     * @test
     * @dataProvider getSupportedFiltersAndSortedOrderValues
     */
    public function shouldRespondWithStatusOkAfterApplyingSupportedFiltersAndSortOrders(string $query): void
    {
        $client = $this->createClient();
        $client->request('GET', '/?' . $query);

        self::assertResponseIsSuccessful();
    }

    public function getSupportedFiltersAndSortedOrderValues(): array
    {
        return [
            'sort firstname asc' => ['?sort[firstName]=ASC'],
            'sort firstname desc' => ['?sort[firstName]=DESC'],
            'sort lastname asc' => ['?sort[lastName]=ASC'],
            'sort lastname desc' => ['?sort[lastName]=DESC'],
            'sort bonustype asc' => ['?sort[bonusType]=ASC'],
            'sort bonustype desc' => ['?sort[bonusType]=DESC'],
            'sort department asc' => ['?sort[department]=ASC'],
            'sort department desc' => ['?sort[department]=DESC'],
            'sort basisOfRemuneration asc' => ['?sort[basisOfRemuneration]=ASC'],
            'sort basisOfRemuneration desc' => ['?sort[basisOfRemuneration]=DESC'],
            'sort additionalRemuneration asc' => ['?sort[additionalRemuneration]=ASC'],
            'sort additionalRemuneration desc' => ['?sort[additionalRemuneration]=DESC'],
            'sort fullRemuneration asc' => ['?sort[fullRemuneration]=ASC'],
            'sort fullRemuneration desc' => ['?sort[fullRemuneration]=DESC'],
            'filter firstname' => ['?filter[firstName]=Adam'],
            'filter lastname' => ['?filter[lastName]=Kowalski'],
            'filter department' => ['?filter[department]=HR']
        ];
    }
}