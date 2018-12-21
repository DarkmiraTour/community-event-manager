<?php

declare(strict_types=1);

use App\Entity\User;
use Behat\Behat\Hook\Scope\AfterStepScope;
use Behat\Mink\Driver\Selenium2Driver;
use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Testwork\Tester\Result\TestResult;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\KernelInterface;
use WebDriver\Exception\NoAlertOpenError;

final class ScheduleContext extends RawMinkContext
{
    /**
     * @When /^I am on the slot type listing page$/
     */
    public function iAmOnTheSlotTypeListingPage(): void
    {
        $this->visitPath('schedule/slot-type/');
    }

    /**
     * @When /^I am on the slot type creation page$/
     */
    public function iAmOnTheSlotTypeCreationPage(): void
    {
        $this->visitPath('schedule/slot-type/create');
    }

    /**
     * @Then /^I should be redirected on the slot type listing page$/
     */
    public function iShouldBeRedirectedOnTheSlotTypeListingPage(): void
    {
        $this->visitPath('schedule/slot-type/');
    }

    /**
     * @When /^I fill the slot type "([^"]*)" field with "([^"]*)"$/
     */
    public function iFillTheSlotTypeFieldWith(string $field, string $value): void
    {
        $field = $this->fixStepArgument('slot_type['.$field.']');
        $value = $this->fixStepArgument($value);
        $this->getSession()->getPage()->fillField($field, $value);
    }

    private function fixStepArgument(string $argument): string
    {
        return str_replace('\\"', '"', $argument);
    }
}