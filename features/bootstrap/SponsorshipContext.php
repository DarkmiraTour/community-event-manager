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

final class SponsorshipContext extends RawMinkContext
{
    /**
     * @When /^I click on (left|right|up|down) arrow of element "([^"]*)"$/
     */
    public function iClickOnArrowOfElement(string $direction, string $rowText): void
    {
        $elementTh = $this->getSession()->getPage()->find('css', sprintf('table th:contains("%s") .fa-caret-%s', $rowText, $direction));
        $elementTd = $this->getSession()->getPage()->find('css', sprintf('table td:contains("%s") .fa-caret-%s', $rowText, $direction));
        if (!$elementTh && !$elementTd) {
            throw new \Exception(sprintf('Cannot find any row on the page containing the text "%s"', $rowText));
        }

        $element = (!$elementTh) ? $elementTd : $elementTh;
        $element->click();
        $this->getSession()->wait(5000, 'typeof window.jQuery == "function"');
    }

    /**
     * @When /^I am on the sponsorship benefit listing page$/
     */
    public function iAmOnTheSponsorshipBenefitListingPage(): void
    {
        $this->visitPath('sponsorship-benefit/');
    }

    /**
     * @When /^I am on the sponsorship level listing page$/
     */
    public function iAmOnTheSponsorshipLevelListingPage(): void
    {
        $this->visitPath('sponsorship-level/');
    }

    /**
     * @When /^I am on the sponsorship benefit creation page$/
     */
    public function iAmOnTheSponsorshipBenefitCreationPage(): void
    {
        $this->visitPath('sponsorship-benefit/create');
    }

    /**
     * @When /^I am on the sponsorship level creation page$/
     */
    public function iAmOnTheSponsorshipLevelCreationPage(): void
    {
        $this->visitPath('sponsorship-level/create');
    }

    /**
     * @When /^I am on the sponsorship level benefit edition page$/
     */
    public function iAmOnTheSponsorshipLevelEditionPage(): void
    {
        $this->visitPath('sponsorship-level-benefit/edit');
    }

    /**
     * @Then /^I should be redirected on the sponsorship benefit listing page$/
     */
    public function iShouldBeRedirectedOnTheSponsorshipBenefitListingPage(): void
    {
        $this->visitPath('sponsorship-benefit/');
    }

    /**
     * @Then /^I should be redirected on the sponsorship level listing page$/
     */
    public function iShouldBeRedirectedOnTheSponsorshipLevelListPage(): void
    {
        $this->visitPath('sponsorship-level/');
    }

    /**
     * @When /^I fill the sponsorship benefit "([^"]*)" field with "([^"]*)"$/
     */
    public function iFillTheSponsorshipBenefitFieldWith(string $field, string $value): void
    {
        $field = $this->fixStepArgument('sponsorship_benefit['.$field.']');
        $value = $this->fixStepArgument($value);
        $this->getSession()->getPage()->fillField($field, $value);
    }

    /**
     * @When /^I fill the sponsorship level "([^"]*)" field with "([^"]*)"$/
     */
    public function iFillTheSponsorshipLevelFieldWith(string $field, string $value): void
    {
        $field = $this->fixStepArgument('sponsorship_level['.$field.']');
        $value = $this->fixStepArgument($value);
        $this->getSession()->getPage()->fillField($field, $value);
    }

    private function fixStepArgument(string $argument): string
    {
        return str_replace('\\"', '"', $argument);
    }
}