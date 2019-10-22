Feature: Send an Interview
  In order to test Sending Interview form
  As an admin
  I need to be able to access the "send an Interview" button, fill the form and submit

  Scenario: I reset the send interview flag to No
    Given I am logged in as an admin
    And I click "Manage" on the card containing "DarkmiraTour Behat"
    When I click "Speakers" link
    And I follow "Edit"
    And I select "0" from "speaker[isInterviewSent]"
    And I press "Save speaker"
    Then I should see "Send an Interview"

  Scenario: I fill the send an Interview form
    Given I am logged in as an admin
    And I click "Manage" on the card containing "DarkmiraTour Behat"
    When I click "Speakers" link
    And I follow "Show"
    And I click "Send an Interview" link
    Then I should see "Send the interview"
    And I should see "Question 1 (custom)"
    And I press "Send"
    Then I should see "Speaker"
    But I should not see "Send an Interview"
