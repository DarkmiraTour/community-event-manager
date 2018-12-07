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
