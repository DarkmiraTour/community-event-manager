<?php

declare(strict_types=1);

namespace App\Commands;

use App\Exceptions\User\UnableToCreateUserException;
use App\Exceptions\ValueObject\Username\InvalidUsernameException;
use App\Repository\User\UserManagerInterface;
use App\ValueObject\Username;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

final class CreateUserCommand extends Command
{
    private $userManager;

    public function __construct(UserManagerInterface $userManager)
    {
        parent::__construct();

        $this->userManager = $userManager;
    }

    public function configure(): void
    {
        $usernameHelp = Username::getCreationConstraint();
        $this
            ->setName('app:users:create')
            ->setDescription('Create a new user into the CEM app')
            ->setHelp(<<<HELP
                    This command allows you to create a new user into the Community Event Manager. 
                    The mandatory information are the email address and the username of the new customer.
                    $usernameHelp
                    The password for this user will be set by default and printed on the screen fro you to transfer.
HELP
            )
            ->addArgument('email-address', InputArgument::REQUIRED, 'Email address')
            ->addArgument('username', InputArgument::REQUIRED, 'Username')
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output): void
    {
        $messageStyle = new SymfonyStyle($input, $output);

        $emailAddress = $input->getArgument('email-address');
        $username = $input->getArgument('username');

        $messageStyle->title('Create a new User');

        if (!filter_var($emailAddress, FILTER_VALIDATE_EMAIL)) {
            $messageStyle->error(sprintf('The email address "%s" is not valid, the user creation has been stopped.', $emailAddress));

            return;
        }

        try {
            $usernameValue = new Username($username);
        } catch (InvalidUsernameException $exception) {
            $messageStyle->error(sprintf('The username "%s" is not valid, %s. The user creation has been stopped.', $username, Username::getCreationConstraint()));

            return;
        }

        $defaultPassword = substr(password_hash(uniqid(), 'sha256'), 0, 12);

        $messageStyle->listing([
            'Launching the User Creation',
            "    With email address: {$emailAddress}",
            "    With username: {$username}",
            "    With the default password: {$defaultPassword}",
        ]);

        try {
            $newUser = $this->userManager->create($emailAddress, $usernameValue->__toString(), $defaultPassword);
        } catch (UnableToCreateUserException $exception) {
            $messageStyle->error('An error occurs during the user creation: '.$exception->getMessage());

            return;
        }

        $messageStyle->success(sprintf('The user has been created with the email address "%s" and the username "%s".', $newUser->getEmailAddress(), $newUser->getUsername()));

        $messageStyle->caution(sprintf("Don't forget to communicate the password \"%s\" to the new user", $defaultPassword));
    }
}
