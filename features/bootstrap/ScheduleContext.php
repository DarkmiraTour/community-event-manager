<?php

declare(strict_types=1);

use Behat\MinkExtension\Context\RawMinkContext;

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
