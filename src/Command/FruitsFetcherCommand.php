<?php
// src/Command/CreateUserCommand.php
namespace App\Command;

use App\Entity\Fruit;
use DbMailer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Mailer\MailerInterface;

use Symfony\Component\Mime\Email;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

// the name of the command is what users type after "php bin/console"
#[AsCommand(name: 'fruits:fetch')]
class FruitsFetcherCommand extends Command
{
    public function __construct(
        private HttpClientInterface $client,
        private EntityManagerInterface $entityManager,
        private MailerInterface $mailer,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln(['Starting fetching']);
        try {
            $response = $this->client->request('GET', 'https://fruityvice.com/api/fruit/all');

            // $contentType = 'application/json'
            $content = $response->getContent();
            // $content = '{"id":521583, "name":"symfony-docs", ...}'
            $content = $response->toArray();

            $counter = 0;

            foreach ($content as $item) {
                $fruit = new Fruit();

                $fruit->setGenus($item['genus']);
                $fruit->setName($item['name']);
                $fruit->setFamily($item['family']);
                $fruit->setOrder($item['order']);
                $fruit->setNutritions(json_encode($item['nutritions']));
                $this->entityManager->persist($fruit);
                $this->entityManager->flush();
                $counter++;
            }

        
            $output->writeln(['Objects inserted: '.$counter]);
            $output->writeln(['=======================']);

            $email = (new Email())
            ->from('test@example.com')
            ->to('fatullayevm@gmail.com')
            ->subject('DB executed')
            ->text('Fruits scraped and inserted to the database')
            ->html('<p>Check the logs</p>');

            $this->mailer->send($email);


            $output->writeln(['Email has been sent']);


            return Command::SUCCESS;
        } catch (DecodingExceptionInterface $error) {
            $output->writeln([$error]);
            return Command::FAILURE;
        }



        // or return this if some error happened during the execution
        // (it's equivalent to returning int(1))
        // return Command::FAILURE;

        // or return this to indicate incorrect command usage; e.g. invalid options
        // or missing arguments (it's equivalent to returning int(2))
        // return Command::INVALID
    }
}
