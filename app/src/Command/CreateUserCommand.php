<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class CreateUserCommand extends Command
{
    protected static $defaultName = 'app:create-user';

    private $em;

    public function __construct(string $name = null, EntityManagerInterface $em)
    {
        $this->em = $em;

        parent::__construct($name);
    }

    protected function configure()
    {
        $this
            ->setDescription('Creates a new user.')
            ->setHelp('This command allows you to create a user...')
            ->addArgument('username', InputArgument::OPTIONAL, 'Username')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');

        $output->writeln('<info>Create new user</info>');

        if (!$input->getArgument('username')) {
           $question = new Question('Please enter your username : [dev@technique.com] ', 'dev@technique.com');
           $input->setArgument('username', $helper->ask($input, $output, $question));
        }

        $question = new Question('Please enter your password : ');
        $question->setHidden(true);
        $pwd = $helper->ask($input, $output, $question);

        $roles = ['ROLE_ADMIN', 'ROLE_USER'];
        $question = new Question('Please enter your role : [ROLE_USER] ', 'ROLE_USER');
        $question->setAutocompleterValues($roles);
        $role = $helper->ask($input, $output, $question);

        $user = (new User())
            ->setEmail($input->getArgument('username'))
            ->setPassword($pwd)
            ->setRoles([$role])
        ;

        $this->em->persist($user);
        $this->em->flush();

        return Command::SUCCESS;
    }
}