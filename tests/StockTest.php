<?php


namespace App\Tests;


use App\Entity\Stock;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class StockTest extends DatabaseDenpendenciesTestCase
{


    /**
     * @test
     * Unit Test
     * Test Each field of our Stock Entity
     */
    public function test_stock_can_be_created_in_db(){

        //SetUP

        //Stock
        $stock = new Stock();


        //symbol
        $price = 1000;
        $previousClose = 1100;
        $stock->setSymbol("AMZN")
              ->setShortName("Amazon INC")
              ->setCurrency("USD")
              ->setExchangeName("Nasdaq")
              ->setRegion("US")
              ->setPriceChange($price - $previousClose)
              ->setPrice($price)
              ->setPreviousClose($previousClose);


        $this->entityManager->persist($stock);
        $this->entityManager->flush();


        $stockRepository = $this->entityManager->getRepository(Stock::class);

        $stockRecord = $stockRepository->findOneBy(["symbol" => "AMZN"]);
        //dd($stockRecord->getShortName());

        //Assertion (One for each field)

        $this->assertEquals("Amazon INC", $stockRecord->getShortName());
        $this->assertEquals("USD", $stockRecord->getCurrency());
        $this->assertEquals("Nasdaq", $stockRecord->getExchangeName());
        $this->assertEquals("US", $stockRecord->getRegion());
        $this->assertEquals(-100, $stockRecord->getPriceChange());
        $this->assertEquals(1000, $stockRecord->getPrice());
        $this->assertEquals(1100, $stockRecord->getPreviousClose());

    }

}