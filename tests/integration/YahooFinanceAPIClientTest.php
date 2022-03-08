<?php


namespace App\Tests\integration;


use App\Tests\DatabaseDenpendenciesTestCase;

class YahooFinanceAPIClientTest extends DatabaseDenpendenciesTestCase
{
    /**
     ** @test
     * @group integraion
     */
    public function test_yahoo_finance_api_return_correct_data()
    {
        $yahooFinanceAPIClient = self::bootKernel()->getContainer()->get('yahoo-finance-api-client');

        $response = $yahooFinanceAPIClient->fetchStockProfile("AMZN", "US");


        // Assertion
        $this->assertSame("AMZN", $stockProfile->symbol);
        $this->assertSame("Amazon INC", $stockRecord->getShortName());
        $this->assertSame("USD", $stockRecord->getCurrency());
        $this->assertSame("Nasdaq", $stockRecord->getExchangeName());
        $this->assertSame("US", $stockRecord->getRegion());
        $this->assertSame(-100, $stockRecord->getPriceChange());
        $this->assertEquals(1000, $stockRecord->getPrice());
        $this->assertEquals(1100, $stockRecord->getPreviousClose());
    }

}