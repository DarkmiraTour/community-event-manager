<?php

declare(strict_types=1);

namespace App\Commands;

use App\Exceptions\User\UnableToSaveUserException;
use App\Repository\User\UserManagerInterface;
use App\ValueObject\Username;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Validator\Exception\InvalidOptionsException;

final class UpdateUserInformationCommand extends Command
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
            ->setName('app:users:update')
            ->setDescription('Update an existing user into the CEM app')
            ->setHelp(<<<'HELP'
                This command allows you to update an existing user into the Community Event Manager. 
                The mandatory information is the email address of the user.
                The information you can update are the email address and the username.
HELP
            )
            ->addArgument('email-address', InputArgument::REQUIRED, 'Email address')
            ->addOption('new-email-address', null, InputOption::VALUE_OPTIONAL, 'New Email Address')
            ->addOption('new-username', null, InputOption::VALUE_OPTIONAL, 'New Username')
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output): void
    {
        $messageStyle = new SymfonyStyle($input, $output);

        $emailAddress = $input->getArgument('email-address');
        $newUsername = $input->getOption('new-username');
        $newEmailAddress = $input->getOption('new-email-address');

        $messageStyle->title('Update a existing User');

        if (!$this->checkCommandEntries($messageStyle, $emailAddress, $newEmailAddress, $newUsername)) {
            return;
        }

        if (null !== $newUsername) {
            try {
                $usernameValue = new Username($newUsername);
            } catch (InvalidOptionsException $exception) {
                $messageStyle->error(sprintf('The username "%s" is not valid, %s. The user creation has been stopped.', $newUsername, Username::getCreationConstraint()));

                return;
            }
        }

        $messageStyle->listing($this->prepareListing($emailAddress, $newEmailAddress, $newUsername));

        $user = $this->userManager->findOneBy(['email' => $emailAddress]);

        if (null === $user) {
            $messageStyle->error("The user with the email address {$emailAddress} could not be found.");

            return;
        }

        try {
            $this->userManager->updateUserInformation($user, $newEmailAddress, $usernameValue ?? null);
        } catch (UnableToSaveUserException $exception) {
            $messageStyle->error('An error occurs during the user update: '.$exception->getMessage());

            return;
        }

        $messageStyle->success("The user {$emailAddress} has been updated.");
    }

    private function prepareListing(string $emailAddress, ?string $newEmailAddress, ?string $newUsername): array
    {
        $listingArray = [
            'Launching the User Update',
            '    With the Email Address '.$emailAddress,
        ];

        if (null !== $newEmailAddress) {
            $listingArray[] = '    By updating email address to '.$newEmailAddress;
        }

        if (null !== $newUsername) {
            $listingArray[] = '    By updating username to '.$newUsername;
        }

        return $listingArray;
    }

    private function checkCommandEntries(SymfonyStyle $messageStyle, string $emailAddress, ?string $newEmailAddress, ?string $newUsername): bool
    {
        if (null === $newEmailAddress && null === $newUsername) {
            $messageStyle->error('No information to update has been given');

            return false;
        }

        if (!filter_var($emailAddress, FILTER_VALIDATE_EMAIL)) {
            $messageStyle->error(sprintf('The email address "%s" is not valid, the user update has been stopped.', $emailAddress));

            return false;
        }

        if (null !== $newEmailAddress && !filter_var($newEmailAddress, FILTER_VALIDATE_EMAIL)) {
            $messageStyle->error(sprintf('The email address "%s" is not valid, the user update has been stopped.', $newEmailAddress));

            return false;
        }

        return true;
    }
}
