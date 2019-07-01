<?php

declare(strict_types=1);

use Behat\MinkExtension\Context\RawMinkContext;
use App\DataFixtures\SpeakerFixtures;

final class SpeakerContext extends RawMinkContext
{
    private const PATH_SPEAKER = '/speakers/';
    
    /**
     * @When /^I am on the speaker listing page$/
     */
    public function iAmOnTheSpaekerListingPage(): void
    {
        $this->visitPath(self::PATH_SPEAKER);
    }

    /**
     * @When /^I am on the speaker creation page$/
     */
    public function iAmOnTheSpeakerCreationPage(): void
    {
        $this->visitPath(self::PATH_SPEAKER.'create');
    }

    /**
     * @Then /^I should be redirected on the speaker listing page$/
     */
    public function iShouldBeRedirectedOnTheSpeakerListingPage(): void
    {
        $this->assertSession()->addressEquals($this->locatePath(self::PATH_SPEAKER));
    }

    /**
     * @When /^I fill the speaker "([^"]*)" field with "([^"]*)"$/
     */
    public function iFillTheSpeakerFieldWith(string $field, string $value): void
    {
        if ("speaker" === $field) {
            if (isset(SpeakerFixtures::DEFAULT_SPEAKER[$value])) {
                $value = SpeakerFixtures::DEFAULT_SPEAKER[$value];
            } else {
                throw new Exception('Value don\'t exist');
            }
        }
        
        $field = $this->fixStepArgument(sprintf('speaker[%s]', $field));
        $value = $this->fixStepArgument($value);
        $this->getSession()->getPage()->fillField($field, $value);
    }

    /**
     * @When /^I fill the speaker "([^"]*)" "([^"]*)" address field with "([^"]*)"$/
     */
    public function iFillTheSpeakerAddressFieldWith(string $field, string $period, string $value): void
    {
        $field = $this->fixStepArgument(sprintf("event[%s][%s]", $field, $period));
        $this->getSession()->getPage()->fillField($field, $value);
    }

    private function fixStepArgument(string $argument): string
    {
        return str_replace('\\"', '"', $argument);
    }
}
