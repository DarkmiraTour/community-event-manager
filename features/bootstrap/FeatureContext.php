<?php

use Behat\Behat\Hook\Scope\AfterStepScope;
use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Testwork\Tester\Result\TestResult;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;

class FeatureContext extends RawMinkContext
{
    private $kernel;

    /**
     * @var Response|null
     */
    private $response;

    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * @When a demo scenario sends a request to :path
     */
    public function aDemoScenarioSendsARequestTo(string $path)
    {
        $this->response = $this->kernel->handle(Request::create($path, 'GET'));
    }

    /**
     * @Then the response should be received
     */
    public function theResponseShouldBeReceived()
    {
        if ($this->response === null) {
            throw new \RuntimeException('No response received');
        }
    }

    /**
     * @When /^I click "([^"]*)" on the row containing "([^"]*)"$/
     */
    public function iClickOnOnTheRowContaining($linkName, $rowText)
    {
        /** @var $row \Behat\Mink\Element\NodeElement */
        $row = $this->getSession()->getPage()->find('css', sprintf('table tr:contains("%s")', $rowText));
        if (!$row) {
            throw new \Exception(sprintf('Cannot find any row on the page containing the text "%s"', $rowText));
        }

        $row->clickLink($linkName);
    }

    /**
     * @When /^I press "([^"]*)" on the row containing "([^"]*)" and (confirm|cancel) popup$/
     */
    public function iPressOnOnTheRowContaining($buttonName, $rowText, $choice)
    {
        /** @var $row \Behat\Mink\Element\NodeElement */
        $row = $this->getSession()->getPage()->find('css', sprintf('table tr:contains("%s")', $rowText));
        if (!$row) {
            throw new \Exception(sprintf('Cannot find any row on the page containing the text "%s"', $rowText));
        }

        $row->pressButton($buttonName);

        switch ($choice) {
            case 'confirm' : $this->getSession()->getDriver()->getWebDriverSession()->accept_alert(); break;
            case 'cancel' : $this->getSession()->getDriver()->getWebDriverSession()->dismiss_alert(); break;
        }
    }

    /**
     * @When /^I click on (left|right|up|down) arrow of element "([^"]*)"$/
     */
    public function iClickOnArrowOfElement($direction, $rowText)
    {
        /** @var $elementTh \Behat\Mink\Element\NodeElement */
        $elementTh = $this->getSession()->getPage()->find('css', sprintf('table th:contains("%s") .fa-caret-%s', $rowText, $direction));

        /** @var $elementTd \Behat\Mink\Element\NodeElement */
        $elementTd = $this->getSession()->getPage()->find('css', sprintf('table td:contains("%s") .fa-caret-%s', $rowText, $direction));
        if (!$elementTh && !$elementTd) {
            throw new \Exception(sprintf('Cannot find any row on the page containing the text "%s"', $rowText));
        }

        $element = (!$elementTh) ? $elementTd : $elementTh;
        $element->click();
        $this->getSession()->wait(500, 'typeof window.jQuery == "function"');
    }

    /**
     * @Then /^I should have "([^"]*)" at position (\d+)$/
     */
    public function iShouldHaveElementAtPosition($rowText, $position)
    {
        $elementThPosition = $this->getSession()->getPage()->find('css', sprintf('table tr th:nth-child(%d)', $position));
        $elementTh = $this->getSession()->getPage()->find('css', sprintf('table tr th:contains("%s")', $rowText));
        $elementTdPosition = $this->getSession()->getPage()->find('css', sprintf('table tbody tr:nth-child(%d) td:first-child', $position));
        $elementTd = $this->getSession()->getPage()->find('css', sprintf('table tr td:contains("%s")', $rowText));
        if (!$elementTh && !$elementThPosition && !$elementTd && !$elementTdPosition) {
            throw new \Exception(sprintf('Cannot find any text "%s" at the position %d', $rowText, $position));
        }

        $elementPosition = ($elementTh) ? $elementThPosition : $elementTdPosition;
        $element = ($elementTh) ? $elementTh : $elementTd;
        if ($element->getText() != $elementPosition->getText()) {
            throw new \Exception(sprintf('Cannot find any text "%s" at the position %d', $rowText, $position));
        }
    }

    /**
     * @Then /^I (check|uncheck) element on line (\d+) and column (\d+)$/
     */
    public function iCheckElementOnLineAndColumn($check, $positionLine, $positionColumn)
    {
        $elementLine = $this->getSession()->getPage()->find('css', sprintf('table tbody tr:nth-child(%d)', $positionLine));
        $elementColumn = $this->getSession()->getPage()->find('css', sprintf('table tr th:nth-child(%d)', $positionColumn));
        if (!$elementLine || !$elementColumn) {
            throw new \Exception(sprintf('Cannot find any line %d or column %d', $positionLine, $positionColumn));
        }

        $dataLine = $elementLine->getAttribute('data-id');
        $dataColumn = $elementColumn->getAttribute('data-id');
        $checkbox = $this->getSession()->getPage()->find('css', sprintf('table tr[data-id="%s"] td[data-id="%s"] input[type="checkbox"]', $dataLine, $dataColumn));
        if ($check == "check") {
            $checkbox->check();
            $this->getSession()->wait(500, 'typeof window.jQuery == "function"');
            return;
        }
        $checkbox->uncheck();
        $this->getSession()->wait(500, 'typeof window.jQuery == "function"');
    }

    /**
     * @Then /^I click (check|button) on line (\d+) and column (\d+)$/
     */
    public function iClickObjectOnLineAndColumn($object, $positionLine, $positionColumn)
    {
        $elementLine = $this->getSession()->getPage()->find('css', sprintf('table tbody tr:nth-child(%d)', $positionLine));
        $elementColumn = $this->getSession()->getPage()->find('css', sprintf('table tr th:nth-child(%d)', $positionColumn));
        if (!$elementLine || !$elementColumn) {
            throw new \Exception(sprintf('Cannot find any line %d or column %d', $positionLine, $positionColumn));
        }

        $dataLine = $elementLine->getAttribute('data-id');
        $dataColumn = $elementColumn->getAttribute('data-id');

        if ($object == "check") {
            $element = $this->getSession()->getPage()->find('css', sprintf('table tr[data-id="%s"] td[data-id="%s"] .fa-check', $dataLine, $dataColumn));
            $element->click();
            $this->getSession()->wait(500, 'typeof window.jQuery == "function"');
            return;
        }

        $element = $this->getSession()->getPage()->find('css', sprintf('table tr[data-id="%s"] td[data-id="%s"] button', $dataLine, $dataColumn));
        $element->click();
        $this->getSession()->wait(500, 'typeof window.jQuery == "function"');
    }

    /**
     * @Then /^I fill element on line (\d+) and column (\d+) with "([^"]*)"$/
     */
    public function iFillElementOnLineAndColumn($positionLine, $positionColumn, $text)
    {
        $elementLine = $this->getSession()->getPage()->find('css', sprintf('table tbody tr:nth-child(%d)', $positionLine));
        $elementColumn = $this->getSession()->getPage()->find('css', sprintf('table tr th:nth-child(%d)', $positionColumn));
        if (!$elementLine || !$elementColumn) {
            throw new \Exception(sprintf('Cannot find any line %d or column %d', $positionLine, $positionColumn));
        }

        $dataLine = $elementLine->getAttribute('data-id');
        $dataColumn = $elementColumn->getAttribute('data-id');
        $input = $this->getSession()->getPage()->find('css', sprintf('table tr[data-id="%s"] td[data-id="%s"] input[type="text"]', $dataLine, $dataColumn));
        $input->setValue($text);
    }

    /**
     * @Then /^I should have element on line (\d+) and column (\d+) (checked|unchecked)$/
     */
    public function iShouldHaveElementOnLineAndColumnCheck($positionLine, $positionColumn, $check)
    {
        $elementLine = $this->getSession()->getPage()->find('css', sprintf('table tbody tr:nth-child(%d)', $positionLine));
        $elementColumn = $this->getSession()->getPage()->find('css', sprintf('table tr th:nth-child(%d)', $positionColumn));
        if (!$elementLine || !$elementColumn) {
            throw new \Exception(sprintf('Cannot find any line %d or column %d', $positionLine, $positionColumn));
        }

        $dataLine = $elementLine->getAttribute('data-id');
        $dataColumn = $elementColumn->getAttribute('data-id');
        $checkbox = $this->getSession()->getPage()->find('css', sprintf('table tr[data-id="%s"] td[data-id="%s"] input[type="checkbox"]', $dataLine, $dataColumn));

        if ($check === "checked") {
            if ($checkbox->getValue() === "") {
                throw new \Exception(sprintf('The checkbox in line %d and column %d is not checked', $positionLine, $positionColumn));
            }
            return;
        }

        if ($checkbox->getValue() === "on") {
            throw new \Exception(sprintf('The checkbox in line %d and column %d is checked', $positionLine, $positionColumn));
        }
    }

    /**
     * @Then /^I should have element on line (\d+) and column (\d+) filled with "([^"]*)"$/
     */
    public function iShouldHaveElementOnLineAndColumnFilled($positionLine, $positionColumn, $text)
    {
        $elementLine = $this->getSession()->getPage()->find('css', sprintf('table tbody tr:nth-child(%d)', $positionLine));
        $elementColumn = $this->getSession()->getPage()->find('css', sprintf('table tr th:nth-child(%d)', $positionColumn));
        if (!$elementLine || !$elementColumn) {
            throw new \Exception(sprintf('Cannot find any line %d or column %d', $positionLine, $positionColumn));
        }

        $dataLine = $elementLine->getAttribute('data-id');
        $dataColumn = $elementColumn->getAttribute('data-id');
        $input = $this->getSession()->getPage()->find('css', sprintf('table tr[data-id="%s"] td[data-id="%s"] input[type="text"]', $dataLine, $dataColumn));
        if ($input->getValue() !== $text) {
            throw new \Exception(sprintf('The element in line %d and column %d is not filled with "%s"', $positionLine, $positionColumn, $text));
        }
    }

    /**
     * @Then /^I should have element on line (\d+) and column (\d+) not filled$/
     */
    public function iShouldHaveElementOnLineAndColumnNotFilled($positionLine, $positionColumn)
    {
        $elementLine = $this->getSession()->getPage()->find('css', sprintf('table tbody tr:nth-child(%d)', $positionLine));
        $elementColumn = $this->getSession()->getPage()->find('css', sprintf('table tr th:nth-child(%d)', $positionColumn));
        if (!$elementLine || !$elementColumn) {
            throw new \Exception(sprintf('Cannot find any line %d or column %d', $positionLine, $positionColumn));
        }

        $dataLine = $elementLine->getAttribute('data-id');
        $dataColumn = $elementColumn->getAttribute('data-id');
        $input = $this->getSession()->getPage()->find('css', sprintf('table tr[data-id="%s"] td[data-id="%s"] input[type="text"]', $dataLine, $dataColumn));
        if ($input->getValue() !== "") {
            throw new \Exception(sprintf('The element in line %d and column %d is filled', $positionLine, $positionColumn));
        }
    }

    /**
     * @AfterStep
     */
    public function takeScreenshotAfterFailedStep(AfterStepScope $scope)
    {
        if (TestResult::FAILED === $scope->getTestResult()->getResultCode()) {
            $driver = $this->getSession()->getDriver();

            if (!$driver instanceof Behat\Mink\Driver\Selenium2Driver) {
                return;
            }

            $this->saveScreenshot();
        }
    }
}
