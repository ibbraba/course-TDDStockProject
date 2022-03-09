<?php


namespace App\Http;


use phpDocumentor\Reflection\Types\This;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class YahooFinanceAPIClient
{
    /**
     * @var HttpClientInterface
     */
    private $client;

    private const URL = "https://yfapi.net/v6/finance/quote";
    private $YahooAPIKEY;

    public function __construct(HttpClientInterface $client, $YahooAPIKEY)
    {
        $this->client = $client;
        $this->YahooAPIKEY = $YahooAPIKEY;
    }

    public function fetchStockProfile($symbol, $region){

        $request = $this->client->request("GET", self::URL, [
            //Parameters
            "query" => [
                "symbols" => $symbol,
                "region" => $region
            ],
            'headers' => [
/*                'accept' => 'application/json',*/
                "x-api-key" => $this->YahooAPIKEY
            ]


        ]);


        //decodes JSON objects as PHP array, since 7.2.0 used by default if $assoc parameter is null
        $stockprofile=json_decode($request->getContent())->quoteResponse->result[0];



        $stockProfileAsArray = [
            "symbol" => $stockprofile->symbol,
            "currency"=> $stockprofile->currency,
            "exchangeName" => $stockprofile->fullExchangeName,
            "shortName" => $stockprofile->shortName,
            "region" => $stockprofile->region,
            "price" => $stockprofile->regularMarketPrice,
            "previousClose" => $stockprofile->regularMarketPreviousClose,
            "priceChange" => $stockprofile->regularMarketPrice - $stockprofile->regularMarketPreviousClose
        ];

        return [
            "statusCode" => 200,
            "content" => json_encode($stockProfileAsArray)
        ];

    }


}