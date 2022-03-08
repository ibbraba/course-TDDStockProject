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
        //Ping to Yahoo API and grab stock respnse profile ['statusCode' => $StatusCode, 'content' => $JsonContent]

        $stockProfile = $this->yahooFInanceAPIClient->fetchStockProfile($input->getArgument("symbol"), $input->getArgument("region"));

        //Handle Error
        if($stockProfile['statusCode'] !== 200) {

        }

        $stock = $this->serializer->deserialize($stockProfile['content'], Stock::class, 'json');


       $this->entityManager->persist($stock);
       $this->entityManager->flush();

        return Command::SUCCESS;
    }
}
