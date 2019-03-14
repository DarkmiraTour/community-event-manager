<?php

declare(strict_types=1);

use Behat\MinkExtension\Context\RawMinkContext;

final class InterviewQuestionContext extends RawMinkContext
{
    /**
     * @When /^I am on the interview question listing page$/
     */
    public function iAmOnTheInterviewQuestionListingPage(): void
    {
        $this->visitPath('interview-question/');
    }

    /**
     * @When /^I am on the interview question creation page$/
     */
    public function iAmOnTheInterviewQuestionCreationPage(): void
    {
        $this->visitPath('interview-question/create');
    }

    /**
     * @Then /^I should be redirected on the interview question listing page$/
     */
    public function iShouldBeRedirectedOnTheInterviewQuestionListingPage(): void
    {
        $this->visitPath('interview-question/');
    }

    /**
     * @When /^I fill the interview question "([^"]*)" field with "([^"]*)"$/
     */
    public function iFillTheInterviewQuestionFieldWith(string $field, string $value): void
    {
        $field = $this->fixStepArgument('interview_question['.$field.']');
        $value = $this->fixStepArgument($value);
        $this->getSession()->getPage()->fillField($field, $value);
    }

    private function fixStepArgument(string $argument): string
    {
        return str_replace('\\"', '"', $argument);
    }
}
