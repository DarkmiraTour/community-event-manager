<?php

declare(strict_types=1);

use Behat\MinkExtension\Context\RawMinkContext;
use App\DataFixtures\SpeakerFixtures;

final class TalkContext extends RawMinkContext
{
    private const PATH_TALK = '/talks/';
    
    /**
     * @When /^I am on the talk listing page$/
     */
    public function iAmOnTheTalkListingPage(): void
    {
        $this->visitPath(self::PATH_TALK);
    }

    /**
     * @When /^I am on the talk creation page$/
     */
    public function iAmOnTheTalkCreationPage(): void
    {
        $this->visitPath(self::PATH_TALK.'create');
    }

    /**
     * @Then /^I should be redirected on the talk listing page$/
     */
    public function iShouldBeRedirectedOnTheTalkListingPage(): void
    {
        $this->assertSession()->addressEquals($this->locatePath(self::PATH_TALK));
    }

    /**
     * @When /^I fill the talk "([^"]*)" field with "([^"]*)"$/
     */
    public function iFillTheTalkFieldWith(string $field, string $value): void
    {
        if ("speaker" === $field) {
            if (isset(SpeakerFixtures::DEFAULT_SPEAKER[$value])) {
                $value = SpeakerFixtures::DEFAULT_SPEAKER[$value];
            } else {
                throw new Exception('Value don\'t exist');
            }
        }
        
        $field = $this->fixStepArgument(sprintf('create_talk_form[%s]', $field));
        $value = $this->fixStepArgument($value);
        $this->getSession()->getPage()->fillField($field, $value);
    }

    /**
     * @When /^I fill the talk "([^"]*)" "([^"]*)" address field with "([^"]*)"$/
     */
    public function iFillTheTalkAddressFieldWith(string $field, string $period, string $value): void
    {
        $field = $this->fixStepArgument(sprintf("event[%s][%s]", $field, $period));
        $this->getSession()->getPage()->fillField($field, $value);
    }

    private function fixStepArgument(string $argument): string
    {
        return str_replace('\\"', '"', $argument);
    }
}
