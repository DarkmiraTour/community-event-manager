<?php

declare(strict_types=1);

use App\Entity\User;
use Behat\Behat\Hook\Scope\AfterStepScope;
use Behat\Mink\Exception\ExpectationException;
use Behat\Mink\Driver\Selenium2Driver;
use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Testwork\Tester\Result\TestResult;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\KernelInterface;
use WebDriver\Exception\NoAlertOpenError;

final class FeatureContext extends RawMinkContext
{
    private $kernel;
    private $currentUser;
    private $response;

    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * @When a demo scenario sends a request to :path
     */
    public function aDemoScenarioSendsARequestTo(string $path): void
    {
        $this->response = $this->kernel->handle(Request::create($path, Request::METHOD_GET));
    }

    /**
     * @Then the response should be received
     */
    public function theResponseShouldBeReceived(): void
    {
        if ($this->response === null) {
            throw new \RuntimeException('No response received');
        }
    }

    /**
     * @Given I am logged in as an admin
     */
    public function iAmLoggedInAsAnAdmin(): void
    {
        $em = $this->kernel->getContainer()->get('doctrine')->getManager();
        $this->currentUser = $em->getRepository(User::class)->findOneBy([
            'email' => 'admin@test.com',
        ]);

        $this->visitPath('/login');
        $this->getSession()->getPage()->fillField('login[email]', 'admin@test.com');
        $this->getSession()->getPage()->fillField('login[password]', 'adminpass');
        $this->getSession()->getPage()->pressButton('Sign in');
    }

    /**
     * @Given I am logged in as a user
     */
    public function iAmLoggedInAsAUser(): void
    {
        $em = $this->kernel->getContainer()->get('doctrine')->getManager();
        $this->currentUser = $em->getRepository(User::class)->findOneBy([
            'email' => 'user@test.com',
        ]);

        $this->visitPath('/login');
        $this->getSession()->getPage()->fillField('login[email]', 'user@test.com');
        $this->getSession()->getPage()->fillField('login[password]', 'userpass');
        $this->getSession()->getPage()->pressButton('Sign in');
    }

    /**
     * @When /^I click "([^"]*)" on the row containing "([^"]*)"$/
     */
    public function iClickOnTheRowContaining(string $linkName, string $rowText): void
    {
        /** @var $row \Behat\Mink\Element\NodeElement */
        $row = $this->getSession()->getPage()->find('css', sprintf('table tr:contains("%s")', $rowText));
        if (!$row) {
            throw new \Exception(sprintf('Cannot find any row on the page containing the text "%s"', $rowText));
        }

        $row->clickLink($linkName);
    }

    /**
     * @When /^I click "([^"]*)" on the card containing "([^"]*)"$/
     */
    public function iClickOnTheCardContaining(string $linkName, string $rowText): void
    {
        /** @var $row \Behat\Mink\Element\NodeElement */
        $row = $this->getSession()->getPage()->find('css', sprintf('.card:contains("%s")', $rowText));

        if (!$row) {
            throw new \Exception(sprintf('Cannot find any card on the page containing the text "%s"', $rowText));
        }

        $row->clickLink($linkName);
    }

    /**
     * @When /^I press "([^"]*)" on the row containing "([^"]*)" and (confirm|cancel) popup$/
     */
    public function iPressOnOnTheRowContaining(string $buttonName, string $rowText, string $choice): void
    {
        /** @var $row \Behat\Mink\Element\NodeElement */
        $row = $this->getSession()->getPage()->find('css', sprintf('table tr:contains("%s")', $rowText));
        if (!$row) {
            throw new \Exception(sprintf('Cannot find any row on the page containing the text "%s"', $rowText));
        }
        $row->pressButton($buttonName);

        $this->manageAlert($choice);
    }

    /**
     * @When /^I click "([^"]*)" and (confirm|cancel) popup$/
     */
    public function iClickOnAndPopup(string $buttonName, string $choice): void
    {
        $this->getSession()->getPage()->pressButton($buttonName);
        $this->manageAlert($choice);
    }

    /**
     * @Then /^I should have "([^"]*)" at position (\d+)$/
     */
    public function iShouldHaveElementAtPosition(string $rowText, int $position): void
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
    public function iCheckElementOnLineAndColumn(string $check, int $positionLine, int $positionColumn): void
    {
        $elementLine = $this->getSession()->getPage()->find('css', sprintf('table tbody tr:nth-child(%d)', $positionLine));
        $elementColumn = $this->getSession()->getPage()->find('css', sprintf('table tr th:nth-child(%d)', $positionColumn));
        if (!$elementLine || !$elementColumn) {
            throw new \Exception(sprintf('Cannot find any line %d or column %d', $positionLine, $positionColumn));
        }

        $dataLine = $elementLine->getAttribute('data-id');
        $dataColumn = $elementColumn->getAttribute('data-id');
        $checkbox = $this->getSession()->getPage()->find('css', sprintf('table tr[data-id="%s"] td[data-id="%s"] input[type="checkbox"]', $dataLine, $dataColumn));
        if ($check == 'check') {
            $checkbox->check();
            $this->getSession()->wait(1000, 'typeof window.jQuery == "function"');
            return;
        }
        $checkbox->uncheck();
        $this->getSession()->wait(1000, 'typeof window.jQuery == "function"');
    }

    /**
     * @Then /^I click (check|button) on line (\d+) and column (\d+)$/
     */
    public function iClickObjectOnLineAndColumn(string $object, int $positionLine, int $positionColumn): void
    {
        $elementLine = $this->getSession()->getPage()->find('css', sprintf('table tbody tr:nth-child(%d)', $positionLine));
        $elementColumn = $this->getSession()->getPage()->find('css', sprintf('table tr th:nth-child(%d)', $positionColumn));
        if (!$elementLine || !$elementColumn) {
            throw new \Exception(sprintf('Cannot find any line %d or column %d', $positionLine, $positionColumn));
        }

        $dataLine = $elementLine->getAttribute('data-id');
        $dataColumn = $elementColumn->getAttribute('data-id');

        if ($object == 'check') {
            $element = $this->getSession()->getPage()->find('css', sprintf('table tr[data-id="%s"] td[data-id="%s"] .fa-check', $dataLine, $dataColumn));
            $element->click();
            $this->getSession()->wait(1000, 'typeof window.jQuery == "function"');
            return;
        }

        $element = $this->getSession()->getPage()->find('css', sprintf('table tr[data-id="%s"] td[data-id="%s"] button', $dataLine, $dataColumn));
        $element->click();
        $this->getSession()->wait(1000, 'typeof window.jQuery == "function"');
    }

    /**
     * Wait for an element appears.
     * Useful to wait before modal opens.
     *
     * @Then /^(?:|I ) wait until I see "(?P<text>(?:[^"]|\\")*)"$/
     */
    public function iWaitForText($text)
    {
        $text = $this->fixStepArgument($text);

        $this->waitForCallback(5, function () use ($text) {
            $this->assertSession()->pageTextContains($text);
        });
    }

    /**
     * Wait for an element appears.
     * Useful to wait before modal opens.
     *
     * @Then I wait until I dont see :text
     */
    public function iWaitUntilIDontSee($text)
    {
        $text = $this->fixStepArgument($text);

        $this->waitForCallback(5, function () use ($text) {
            $this->assertSession()->pageTextNotContains($text);
        });
    }

    /**
     * @param int $timeout in seconds
     * @throws ExpectationException If callback still fails after timeout
     * @throws InvalidArgumentException
     */
    private function waitForCallback($timeout, $callback)
    {
        if (!is_callable($callback)) {
            throw new \InvalidArgumentException('Given callback is not a valid callable');
        }

        $start = time();
        $end = $start + $timeout;
        $lastException = null;

        do {
            try {
                $result = call_user_func($callback, $this);

                if ($result) {
                    break;
                }
            } catch (ExpectationException $exception) {
                $lastException = $exception;
            }

        } while (time() < $end);

        if (null !== $lastException) {
            throw $lastException;
        }

        return $result;
    }

    /**
     * @Then /^I fill element on line (\d+) and column (\d+) with "([^"]*)"$/
     */
    public function iFillElementOnLineAndColumn(int $positionLine, int $positionColumn, string $text): void
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
    public function iShouldHaveElementOnLineAndColumnCheck(int $positionLine, int $positionColumn, string $check): void
    {
        $elementLine = $this->getSession()->getPage()->find('css', sprintf('table tbody tr:nth-child(%d)', $positionLine));
        $elementColumn = $this->getSession()->getPage()->find('css', sprintf('table tr th:nth-child(%d)', $positionColumn));
        if (!$elementLine || !$elementColumn) {
            throw new \Exception(sprintf('Cannot find any line %d or column %d', $positionLine, $positionColumn));
        }

        $dataLine = $elementLine->getAttribute('data-id');
        $dataColumn = $elementColumn->getAttribute('data-id');
        $checkbox = $this->getSession()->getPage()->find('css', sprintf('table tr[data-id="%s"] td[data-id="%s"] input[type="checkbox"]', $dataLine, $dataColumn));

        if ($check === 'checked') {
            if ($checkbox->getValue() === '') {
                throw new \Exception(sprintf('The checkbox in line %d and column %d is not checked', $positionLine, $positionColumn));
            }
            return;
        }

        if ($checkbox->getValue() === 'on') {
            throw new \Exception(sprintf('The checkbox in line %d and column %d is checked', $positionLine, $positionColumn));
        }
    }

    /**
     * @Then /^I should have element on line (\d+) and column (\d+) filled with "([^"]*)"$/
     */
    public function iShouldHaveElementOnLineAndColumnFilled(int $positionLine, int $positionColumn, string $text): void
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
    public function iShouldHaveElementOnLineAndColumnNotFilled(int $positionLine, int $positionColumn): void
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
     * @When /^I click "([^"]*)" link$/
     */
    public function iClickLink(string $linkText): void
    {
        $link = $this->getSession()->getPage()->findLink($linkText);
        $link->click();
    }

    /**
     * @AfterStep
     */
    public function takeScreenshotAfterFailedStep(AfterStepScope $scope): void
    {
        if (TestResult::FAILED === $scope->getTestResult()->getResultCode()) {
            $driver = $this->getSession()->getDriver();
            if (!$driver instanceof Selenium2Driver) {
                return;
            }

            $this->saveScreenshot();
        }
    }

    private function manageAlert(string $type): void
    {
        $driver = $this->getSession()->getDriver();
        if ($driver instanceof Selenium2Driver) {
            for ($i = 0; $i < 10; $i++) {
                try {
                    switch ($type) {
                        case 'confirm' : $driver->getWebDriverSession()->accept_alert(); break;
                        case 'cancel' : $driver->getWebDriverSession()->dismiss_alert(); break;
                    }
                    break;
                }
                catch (NoAlertOpenError $e) {
                    sleep(2);
                    $i++;
                }
            }
        }
    }

    private function fixStepArgument(string $argument): string
    {
        return str_replace('\\"', '"', $argument);
    }
}
