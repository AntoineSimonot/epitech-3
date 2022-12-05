<?php

namespace App\Command;

use App\Repository\ClientRepository;
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
    name: 'app:client:birth-day',
    description: 'Send email when product quantity is empty',
)]
class HappyBirthdayComand extends Command
{
    private ClientRepository $clientRepository;
    private EntityManagerInterface $entityManager;
    private MailerInterface $mailer;

    public function __construct(ClientRepository $clientRepository, EntityManagerInterface $entityManager, MailerInterface $mailer, string $name = null)
    {
        $this->clientRepository = $clientRepository;
        $this->entityManager = $entityManager;
        $this->mailer = $mailer;
        parent::__construct($name);
    }
    


   

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $clients = $this->clientRepository->findByBirthday();

        $email = (new Email())
        ->from('hello@example.com')
        ->to('you@example.com')
        ->subject('Time for Symfony Mailer!')
        ->text('Happy Birthday!')
        ->html('Happy Birthday!');

        try {
            $this->mailer->send($email);
        } catch (Ecxeption $e) {
            $io->error($e->getMessage());
        }

        
        return Command::SUCCESS;
    }
}
