<?php

namespace App\Command;

use App\Repository\ProductRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Psr\Log\LoggerInterface;

#[AsCommand(
    name: 'app:product-empty:alert',
    description: 'Logg when product quantity is empty',
)]
class ProductEmptySendEmailCommand extends Command
{
    private ProductRepository $productRepository;
    private LoggerInterface $logger;

    public function __construct(ProductRepository $productRepository, LoggerInterface $logger, string $name = null)
    {
        $this->productRepository = $productRepository;
        $this->logger = $logger;
        parent::__construct($name);
    }
 

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $products = $this->productRepository->findBy(
            [
                'quantity' => 0
            ]
        );

        foreach ($products as $product) {
            $this->logger->ERROR('Product quantity is empty', [
                'product' => $product->getName()
            ]);
        }

        return Command::SUCCESS;
    }
}
