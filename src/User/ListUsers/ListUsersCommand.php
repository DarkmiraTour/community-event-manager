<?php

declare(strict_types=1);

namespace App\User\ListUsers;

use App\User\User;
use App\User\UserManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

final class ListUsersCommand extends Command
{
    private $userManager;

    public function __construct(UserManagerInterface $userManager)
    {
        parent::__construct();

        $this->userManager = $userManager;
    }

    public function configure(): void
    {
        $this
            ->setName('app:users:list')
            ->setDescription('Get the list of all Users in CEM app')
            ->setHelp('This command allows you to print at the screen all users recorded into the Community Event Manager.')
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output): void
    {
        $messageStyle = new SymfonyStyle($input, $output);

        $messageStyle->title('Users list');

        $usersList = $this->userManager->findAll();

        $resultArray = [];
        /** @var User $user */
        foreach ($usersList as $user) {
            $resultArray[] = $user->toArray();
        }

        if (empty($resultArray)) {
            $messageStyle->warning('The table User appears to be empty.');
        }

        $messageStyle->table(
            ['Email Address', 'Username', 'Role'],
            $resultArray
        );
    }
}
