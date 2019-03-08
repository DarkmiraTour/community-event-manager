Feature: Sponsorship Level
  In order to test CRUD on sponsorship levels
  As an admin
  I need to be able to list all levels and fill forms

  Scenario: I add a sponsorship level
    Given I am logged in as an admin
    When I am on the sponsorship level creation page
    And I fill the sponsorship level "label" field with "Level 4"
    And I fill the sponsorship level "price" field with "100"
    And I press "Add"
    Then I should be redirected on the sponsorship level listing page
    And I should see "Level 4"

  Scenario: I fill a string in price instead of a double when i add a sponsorship level
    Given I am logged in as an admin
    When I am on the sponsorship level creation page
    And I fill the sponsorship level "label" field with "Level 4"
    And I fill the sponsorship level "price" field with "error"
    And I press "Add"
    Then I should see "This value is not valid."

  Scenario: I don't fill all data needed when i add a sponsorship level
    Given I am logged in as an admin
    When I am on the sponsorship level creation page
    And I press "Add"
    Then I should see "This value should not be blank."

  Scenario: I fill a string in price instead of a double when i edit a sponsorship level "Level 4"
    Given I am logged in as an admin
    When I am on the sponsorship level listing page
    And I click "Edit" on the row containing "Level 4"
    And I fill the sponsorship level "label" field with "Level 10"
    And I fill the sponsorship level "price" field with "Level error"
    And I press "Save"
    Then I should see "This value is not valid."

  Scenario: I don't fill all data needed when i edit a sponsorship level "Level 4"
    Given I am logged in as an admin
    When I am on the sponsorship level listing page
    And I click "Edit" on the row containing "Level 4"
    And I fill the sponsorship level "label" field with ""
    And I fill the sponsorship level "price" field with ""
    And I press "Save"
    Then I should see "This value should not be blank."

  Scenario: I edit the sponsorship level "Level 4"
    Given I am logged in as an admin
    When I am on the sponsorship level listing page
    And I click "Edit" on the row containing "Level 4"
    And I fill the sponsorship level "label" field with "Level 10"
    And I press "Save"
    Then I should be redirected on the sponsorship level listing page
    And I should see "Level 10"

  Scenario: I cancel the delete of sponsorship level "Level 10"
    Given I am logged in as an admin
    When I am on the sponsorship level listing page
    And I click "Delete" on the row containing "Level 10"
    And I should see "Do you wish to confirm \"Level 10\" sponsorship level deletion?"
    And I click "Back to list" link
    Then I should be redirected on the sponsorship level listing page
    And I should see "Level 10"

  Scenario: I confirm the delete of sponsorship level "Level 10"
    Given I am logged in as an admin
    When I am on the sponsorship level listing page
    And I click "Delete" on the row containing "Level 10"
    And I should see "Do you wish to confirm \"Level 10\" sponsorship level deletion?"
    And I press "Delete"
    Then I should be redirected on the sponsorship level listing page
    And I should not see "Level 10"
