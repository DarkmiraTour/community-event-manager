Feature: Slot type
  In order to test CRUD on slot types
  As an admin
  I need to be able to list all benefits and fill forms

  Scenario: I add a slot type
    Given I am logged in as an admin
    When I am on the slot type creation page
    And I fill the slot type "description" field with "Slot Type 6"
    And I press "Add"
    Then I should be redirected on the slot type listing page
    And I should see "Slot Type 6"

  Scenario: I don't fill all data needed when i add a slot type
    Given I am logged in as an admin
    When I am on the slot type creation page
    And I press "Add"
    Then I should see "This value should not be blank."

  Scenario: I don't fill all data needed when i edit a slot type "Slot Type 6"
    Given I am logged in as an admin
    When I am on the slot type listing page
    And I click "Edit" on the row containing "Slot Type 6"
    And I fill the slot type "description" field with ""
    And I press "Save"
    Then I should see "This value should not be blank."

  Scenario: I edit the slot type "Slot Type 6"
    Given I am logged in as an admin
    When I am on the slot type listing page
    And I click "Edit" on the row containing "Slot Type 6"
    And I fill the slot type "description" field with "Slot Type 7"
    And I press "Save"
    Then I should be redirected on the slot type listing page
    And I should see "Slot Type 7"

  @javascript
  Scenario: I cancel the delete of slot type "Slot Type 7"
    Given I am logged in as an admin
    When I am on the slot type listing page
    And I press "Delete" on the row containing "Slot Type 7" and cancel popup
    Then I should see "Slot Type 7"

  @javascript
  Scenario: I confirm the delete of slot type "Slot Type 7"
    Given I am logged in as an admin
    When I am on the slot type listing page
    And I press "Delete" on the row containing "Slot Type 7" and confirm popup
    Then I should not see "Slot Type 7"
