<?php

declare(strict_types=1);

use Behat\MinkExtension\Context\RawMinkContext;

final class SendInterviewContext extends RawMinkContext
{
    /**
     * @When /^I am on the send an interview speaker "([^"]*)" page$/
     */
    public function iAmOnTheSendAnInterviewPage(string $id): void
    {
        $this->visitPath("speakers/$id/send_interview/");
    }

    /**
     * @Then /^I should be redirected on the speaker show "([^"]*)" page$/
     */
    public function iShouldBeRedirectedOnTheSpeakerShowPage(string $id): void
    {
        $this->visitPath("speakers/$id");
    }

    /**
    * @Then /^I am on the speaker "([^"]*)" page$/
    */
    public function iAmOnTheSpeakerPage(string $id): void
    {
        $this->visitPath("speakers/$id");
    }

    /**
     * @Then /^I am on the edit speaker "([^"]*)" page$/
     */
    public function iAmOnTheEditSpeakerPage(string $id): void
    {
        $this->visitPath("speakers/$id/edit");
    }
}
