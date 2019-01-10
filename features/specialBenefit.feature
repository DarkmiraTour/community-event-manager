Feature: Special benefit
  In order to test CRUD on special benefits
  As an admin
  I need to be able to list all special benefits and fill forms

  Scenario: I add a special benefit
    Given I am logged in as an admin
    When I am on the special benefit creation page
    And I fill the special benefit "label" field with "Special Package 11"
    And I fill the special benefit "price" field with "100"
    And I fill the special benefit "description" field with "It's a description for special package 11"
    And I press "Add"
    Then I should be redirected on the special benefit listing page
    And I should see "Special Package 11"

  Scenario: I fill a string in price instead of a double when i add a special benefit
    Given I am logged in as an admin
    When I am on the special benefit creation page
    And I fill the special benefit "label" field with "Special Package 12"
    And I fill the special benefit "price" field with "error"
    And I fill the special benefit "description" field with "It's a description for special package 12"
    And I press "Add"
    Then I should see "This value is not valid."

  Scenario: I don't fill all data needed when i add a special benefit
    Given I am logged in as an admin
    When I am on the special benefit creation page
    And I press "Add"
    Then I should see "This value should not be blank."

  Scenario: I fill a string in price instead of a double when i edit the special benefit "Special Package 11"
    Given I am logged in as an admin
    When I am on the special benefit listing page
    And I click "Edit" on the row containing "Special Package 11"
    And I fill the special benefit "label" field with "Special Package 12"
    And I fill the special benefit "price" field with "error"
    And I fill the special benefit "description" field with "It's a description for special package 12"
    And I press "Save"
    Then I should see "This value is not valid."

  Scenario: I don't fill all data needed when i edit a special benefit "Special Package 11"
    Given I am logged in as an admin
    When I am on the special benefit listing page
    And I click "Edit" on the row containing "Special Package 11"
    And I fill the special benefit "label" field with ""
    And I fill the special benefit "price" field with ""
    And I fill the special benefit "description" field with ""
    And I press "Save"
    Then I should see "This value should not be blank."

  Scenario: I edit the special benefit "Special Package 11"
    Given I am logged in as an admin
    When I am on the special benefit listing page
    And I click "Edit" on the row containing "Special Package 11"
    And I fill the special benefit "label" field with "Special Package 12"
    And I fill the special benefit "price" field with "200"
    And I fill the special benefit "description" field with "It's a description for special package 12"
    And I press "Save"
    Then I should be redirected on the special benefit listing page
    And I should see "Special Package 12"

  @javascript
  Scenario: I cancel the delete of special benefit "Special Package 12"
    Given I am logged in as an admin
    When I am on the special benefit listing page
    And I press "Delete" on the row containing "Special Package 12" and cancel popup
    Then I should see "Special Package 12"

  @javascript
  Scenario: I confirm the delete of special benefit "Special Package 12"
    Given I am logged in as an admin
    When I am on the special benefit listing page
    And I press "Delete" on the row containing "Special Package 12" and confirm popup
    Then I should not see "Special Package 12"
