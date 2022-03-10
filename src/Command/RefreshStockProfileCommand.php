<?php

namespace App\Command;

use App\Entity\Stock;
use App\Http\FinanceApiClientInterface;
use App\Http\YahooFinanceAPIClient;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class RefreshStockProfileCommand extends Command
{
    protected static $defaultName = 'app:refresh-stock-profile';
    protected static $defaultDescription = 'Add a short description for your command';
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var SerializerInterface
     */
    private $serializer;
    /**
     * @var FinanceApiClientInterface
     *
     */
    private $financeApiClient;


    public function __construct(EntityManagerInterface $entityManager, FinanceApiClientInterface $financeApiClient,
                                SerializerInterface $serializer
                              )
    {
        $this->entityManager = $entityManager;


        $this->serializer = $serializer;


        $this->financeApiClient= $financeApiClient;

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



        $stockProfile = $this->financeApiClient->fetchStockProfile($input->getArgument("symbol"), $input->getArgument("region"));

        //Handle Error
        if($stockProfile['statusCode'] !== 200) {

            dd($stockProfile['statusCode']);
        }

/*        $stock = $this->serializer->deserialize()*/
        /*
         * TODO : Change YahooFinance to Polygon and fix serializer error
         */




        /*        dd($stockProfile['content']);*/
        $stock = $this->serializer->deserialize($stockProfile['content'], Stock::class, 'json', array("arrtibutes" => "id"));
       $this->entityManager->persist($stock);
       $this->entityManager->flush();

        return Command::SUCCESS;
    }
}
