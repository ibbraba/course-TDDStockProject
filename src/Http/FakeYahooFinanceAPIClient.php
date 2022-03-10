<?php


namespace App\Http;


class FakeYahooFinanceAPIClient implements FinanceApiClientInterface
{
    public static $statusCode = 200;
    public static $content = "";


    public function fetchStockProfile(string $symbol, string $region){



        return [
            "statusCode" => self::$statusCode,
            "content" => self::$content
        ];

    }

/*'{"symbol":"AMZN","currency":"USD","exchangeName":"NasdaqGS","shortName":"Amazon.com, Inc.","region":"US","price":2956.94,"previousClose":2785.58,"priceChange":171.36}'*/
}