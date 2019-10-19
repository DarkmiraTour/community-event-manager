Feature: Send an Interview
  In order to test Sending Interview form
  As an admin
  I need to be able to access the "send an Interview" button, fill the form and submit

  Scenario: I reset the send interview flag to No
    Given I am logged in as an admin
    And I am on "/speakers"
    When I click "Edit" on the row containing "Behat"
    And I select "0" from "speaker_form[isInterviewSent]"
    And I press "Save speaker"
    Then I should see "Speaker"
    And I should see "Behat"
    And I should see "Send an Interview"

  Scenario: I fill the send an Interview form
    Given I am logged in as an admin
    And I am on "/speakers"
    When I click "mr" on the row containing "Behat"
    And I click "Send an Interview" link
    Then I should see "Send the interview"
    And I should see "Question 1 (custom)"
    And I press "Send"
    Then I should see "Speaker"
    And I should see "Behat"
    But I should not see "Send an Interview"
