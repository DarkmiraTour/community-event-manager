<?php

declare(strict_types=1);

namespace App\Commands;

use App\Exceptions\User\UnableToDeleteUserException;
use App\Repository\User\UserManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Style\SymfonyStyle;

final class DeleteUserCommand extends Command
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
            ->setName('app:users:delete')
            ->setDescription('Delete an existing user into the CEM app')
            ->setHelp(<<<'HELP'
            This command allows you to delete an existing user into the Community Event Manager. 
            The mandatory information is the email address of the user. 
            The option confirm is mandatory to confirm your delete action.
HELP
            )
            ->addArgument('email-address', InputArgument::REQUIRED, 'Email address')
            ->addOption('confirm', null, InputOption::VALUE_NONE, 'Mandatory option to confirm deletion.')
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output): void
    {
        $messageStyle = new SymfonyStyle($input, $output);

        $emailAddress = $input->getArgument('email-address');
        $isConfirmed = $input->getOption('confirm');

        $messageStyle->title('Delete a existing User');

        if (!filter_var($emailAddress, FILTER_VALIDATE_EMAIL)) {
            $messageStyle->error(sprintf('The email address "%s" is not valid, the user update has been stopped.', $emailAddress));

            return;
        }

        $messageStyle->listing([
            'Launching the User Delete',
            "    With the Email Address : {$emailAddress}",
        ]);

        if (!$isConfirmed) {
            $messageStyle->error('The action is not confirmed!');

            $helper = $this->getHelper('question');

            $question = new ChoiceQuestion(
                'Do you wish to confirm? (default to No)',
                ['No', 'Yes'],
                0
            );

            $confirmResponse = $helper->ask($input, $output, $question);

            if ('Yes' === $confirmResponse) {
                $this->executeDeletion($messageStyle, $emailAddress);
            }

            return;
        }

        $this->executeDeletion($messageStyle, $emailAddress);
    }

    private function executeDeletion(SymfonyStyle $messageStyle, string $emailAddress): void
    {
        $user = $this->userManager->findOneBy(['email' => $emailAddress]);

        if (null === $user) {
            $messageStyle->error(sprintf('The user with the email address "%s" could not be found.', $emailAddress));

            return;
        }

        try {
            $this->userManager->remove($user);
        } catch (UnableToDeleteUserException $exception) {
            $messageStyle->error("An error occurs during the user deletion: {$exception->getMessage()}");

            return;
        }

        $messageStyle->success(sprintf('The user with the email address "%s" has been deleted.', $emailAddress));
    }
}
