Feature: Sponsorship Benefit
  In order to test CRUD on sponsorship benefits
  As an admin
  I need to be able to list all benefits and fill forms

  Scenario: I add a sponsorship benefit
    Given I am logged in as an admin
    When I am on the sponsorship benefit creation page
    And I fill the sponsorship benefit "label" field with "Benefit 11"
    And I press "Add"
    Then I should be redirected on the sponsorship benefit listing page
    And I should see "Benefit 11"

  Scenario: I don't fill all data needed when i add a sponsorship benefit
    Given I am logged in as an admin
    When I am on the sponsorship benefit creation page
    And I press "Add"
    Then I should see "This value should not be blank."

  Scenario: I don't fill all data needed when i edit a sponsorship benefit "Benefit 11"
    Given I am logged in as an admin
    When I am on the sponsorship benefit listing page
    And I click "Edit" on the row containing "Benefit 11"
    And I fill the sponsorship benefit "label" field with ""
    And I press "Save"
    Then I should see "This value should not be blank."

  Scenario: I edit the sponsorship benefit "Benefit 11"
    Given I am logged in as an admin
    When I am on the sponsorship benefit listing page
    And I click "Edit" on the row containing "Benefit 11"
    And I fill the sponsorship benefit "label" field with "Benefit 12"
    And I press "Save"
    Then I should be redirected on the sponsorship benefit listing page
    And I should see "Benefit 12"

  @javascript
  Scenario: I cancel the delete of sponsorship benefit "Benefit 12"
    Given I am logged in as an admin
    When I am on the sponsorship benefit listing page
    And I press "Delete" on the row containing "Benefit 12" and cancel popup
    Then I should see "Benefit 12"

  @javascript
  Scenario: I confirm the delete of sponsorship benefit "Benefit 12"
    Given I am logged in as an admin
    When I am on the sponsorship benefit listing page
    And I press "Delete" on the row containing "Benefit 12" and confirm popup
    Then I should not see "Benefit 12"
