<?php

namespace App\Command;

use App\Entity\Stock;
use App\Http\YahooFinanceAPIClient;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class RefreshStockProfileCommand extends Command
{
    protected static $defaultName = 'app:refresh-stock-profile';
    protected static $defaultDescription = 'Add a short description for your command';
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var YahooFinanceAPIClient
     */
    private $yahooFInanceAPIClient;


    public function __construct(EntityManagerInterface $entityManager, YahooFinanceAPIClient $yahooFInanceAPIClient)
    {
        $this->entityManager = $entityManager;
        $this->yahooFInanceAPIClient = $yahooFInanceAPIClient;


        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription(self::$defaultDescription)
            ->addArgument('symbol', InputArgument::REQUIRED, 'Stock Symbol')
            ->addArgument('region', InputArgument::REQUIRED, 'Stock Region')

        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $stockProfile = $this->yahooFInanceAPIClient->fetchStockProfile($input->getArgument("symbol"));


        $stock = new Stock();
        $stock->setSymbol($stockProfile->symbol)
            ->setShortName($stockProfile->ShortName)
            ->setCurrency($stockProfile->currency)
            ->setExchangeName($stockProfile->ExchangeName)
            ->setRegion($stockProfile->region)
            ->setPrice($stockProfile->Price)
            ->setPreviousClose($stockProfile->previousClose)
        ->setPriceChange($stockProfile->Price - $stockProfile->previousClose);


       $this->entityManager->persist($stock);
       $this->entityManager->flush();

        return Command::SUCCESS;
    }
}
