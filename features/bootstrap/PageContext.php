<?php

declare(strict_types=1);

use Behat\MinkExtension\Context\RawMinkContext;
use Symfony\Component\HttpFoundation\File\File;

final class PageContext extends RawMinkContext
{
    /**
     * @When /^I am on the page listing page$/
     */
    public function iAmOnThePageListingPage(): void
    {
        $this->visitPath('page/');
    }

    /**
     * @When /^I am on the page creation page$/
     */
    public function iAmOnThePageCreationPage(): void
    {
        $this->visitPath('page/create');
    }

    /**
     * @When /^I am on the page edition page$/
     */
    public function iAmOnThePageEditionPage(): void
    {
        $this->visitPath('page/edit');
    }

    /**
     * @When /^I am on the page view page$/
     */
    public function iAmOnThePageViewPage(): void
    {
        $this->visitPath('page/view');
    }

    /**
     * @When /^I fill page file field with a (simple|huge) "([^"]*)" file test$/
     */
    public function iFillPageFileFieldWithFileTest(string $dimension, string $type): void
    {
        switch ($type) {
            case 'image' : $testFile = $dimension === 'simple' ? 'test.jpg' : 'huge_test.jpg'; break;
            case 'text' : $testFile = 'test.txt'; break;
        }

        $file = new File(dirname(__DIR__).'/testFiles/'.$testFile);
        $field = $this->fixStepArgument('page[background]');
        $this->getSession()->getPage()->fillField('page[background]', $file);
    }

    /**
     * @When /^I fill the page "([^"]*)" field with "([^"]*)"$/
     */
    public function iFillThePageFieldWith(string $field, string $value): void
    {
        $field = $this->fixStepArgument('page['.$field.']');
        $value = $this->fixStepArgument($value);
        $this->getSession()->getPage()->fillField($field, $value);
    }

    /**
     * @Then /^I should be redirected on the page listing page$/
     */
    public function iShouldBeRedirectedOnThePageListPage(): void
    {
        $this->visitPath('page/');
    }

    private function fixStepArgument(string $argument): string
    {
        return str_replace('\\"', '"', $argument);
    }
}