<?php

namespace App\Command;

use App\Repository\CartRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
// entity manager
use Doctrine\ORM\EntityManagerInterface;
#[AsCommand(
    name: 'app:cart:delete-old',
    description: 'Send email when product quantity is empty',
)]
class DeleteOldCartCommand extends Command
{
    private CartRepository $cartRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(CartRepository $cartRepository, EntityManagerInterface $entityManager, string $name = null)
    {
        $this->cartRepository = $cartRepository;
        $this->entityManager = $entityManager;
        parent::__construct($name);
    }

   

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $carts = $this->cartRepository->findByOneWeekOld();
        

        foreach ($carts as $cart) {
            $this->entityManager->remove($cart);
            $this->entityManager->flush();  
        }

        return Command::SUCCESS;
    }
}
