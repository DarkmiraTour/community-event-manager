<?php

declare(strict_types=1);

use Behat\MinkExtension\Context\RawMinkContext;

final class OrganisationContext extends RawMinkContext
{
    private const PATH_ORGANISATION = '/organisations/';

    /**
     * @When /^I am on the page listing organisations$/
     */
    public function iAmOnThePageListingOrganisations(): void
    {
        $this->visitPath(self::PATH_ORGANISATION);
    }

    /**
     * @When /^I am on the organisation import page$/
     */
    public function iAmOnTheOrganisationImportPage(): void
    {
        $this->visitPath(self::PATH_ORGANISATION.'upload');
    }

    /**
     * @Then /^I should be redirected on the organisation listing page$/
     */
    public function iShouldBeRedirectedOnOrganisationListingPage(): void
    {
        $this->assertSession()->addressEquals($this->locatePath(self::PATH_ORGANISATION));
    }
}
