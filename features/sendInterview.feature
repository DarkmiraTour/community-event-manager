Feature: Send an Interview
  In order to test Sending Interview form
  As an admin
  I need to be able to access the "send an Interview" button, fill the form and submit

  Scenario: I reset the send interview flag to No
    Given I am logged in as an admin
    When I am on the edit speaker "82e7325c-36b3-4c33-a0e8-743c6013e008" page
    And I select "0" from "speaker[isInterviewSent]"
    And I press "Save speaker"
    Then I should be redirected on the speaker show "82e7325c-36b3-4c33-a0e8-743c6013e008" page
    And I should see "Send an Interview"

  Scenario: I fill the send an Interview form
    Given I am logged in as an admin
    When I am on the speaker "82e7325c-36b3-4c33-a0e8-743c6013e008" page
    And I click "Send an Interview" link
    And I am on the send an interview speaker "82e7325c-36b3-4c33-a0e8-743c6013e008" page
    And I should see "Question 1 (custom)"
    And I press "Send"
    Then I should be redirected on the speaker show "82e7325c-36b3-4c33-a0e8-743c6013e008" page
    And I should not see "Send an Interview"
