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





        $stockProfile= json_decode($response->getContent());


        // Assertion
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertSame("AMZN", $stockProfile->symbol);
        $this->assertSame("Amazon.com, Inc.", $stockProfile->shortName);
        $this->assertSame("USD", $stockProfile->currency);
        $this->assertSame("NasdaqGS", $stockProfile->exchangeName);
        $this->assertSame("US", $stockProfile->region);
        $this->assertIsNumeric( $stockProfile->price);
        $this->assertIsFloat( $stockProfile->previousClose);
        $this->assertIsFloat( $stockProfile->priceChange);
    }

}