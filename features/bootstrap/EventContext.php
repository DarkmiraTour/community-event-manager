<?php

declare(strict_types=1);

use Behat\MinkExtension\Context\RawMinkContext;

final class EventContext extends RawMinkContext
{
    /**
     * @When /^I am on the event listing page$/
     */
    public function iAmOnTheEventListingPage(): void
    {
        $this->visitPath('/');
    }

    /**
     * @When /^I am on the event creation page$/
     */
    public function iAmOnTheEventCreationPage(): void
    {
        $this->visitPath('events/create');
    }

    /**
     * @Then /^I should be redirected on the event listing page$/
     */
    public function iShouldBeRedirectedOnTheEventListingPage(): void
    {
        $this->assertSession()->addressEquals($this->locatePath('/'));
    }

    /**
     * @When /^I fill the event "([^"]*)" field with "([^"]*)"$/
     */
    public function iFillTheEventFieldWith(string $field, string $value): void
    {
        $field = $this->fixStepArgument('event['.$field.']');
        $value = $this->fixStepArgument($value);
        $this->getSession()->getPage()->fillField($field, $value);
    }

    /**
     * @When /^I fill the event "([^"]*)" "([^"]*)" address field with "([^"]*)"$/
     */
    public function iFillTheEventAddressFieldWith(string $field, string $period, string $value): void
    {
        $field = $this->fixStepArgument("event[$field][$period]");
        $this->getSession()->getPage()->fillField($field, $value);
    }

    private function fixStepArgument(string $argument): string
    {
        return str_replace('\\"', '"', $argument);
    }
}
