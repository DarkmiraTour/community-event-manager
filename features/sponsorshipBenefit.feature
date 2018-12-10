Feature: Sponsorship Benefit
  In order to test CRUD on sponsorship benefits
  As an admin
  I need to be able to list all benefits and fill forms

  Background: I connect as admin
    Given I am on "login/"
    When I fill in "login[email]" with "admin@test.com"
    And I fill in "login[password]" with "adminpass"
    And I press "Sign in"

  Scenario: I add a sponsorship benefit
    Given I am on "sponsorship-benefit/create"
    When I fill in "sponsorship_benefit[label]" with "Benefit 14"
    And I press "Save"
    Then I should be on "sponsorship-benefit/"
    And I should see "Benefit 14"

  Scenario: I don't fill all data needed when i add a sponsorship benefit
    Given I am on "sponsorship-benefit/create"
    When I press "Save"
    Then I should see "This value should not be blank."

  Scenario: I don't fill all data needed when i edit a sponsorship benefit "Benefit 14"
    Given I am on "sponsorship-benefit/"
    And I click "Edit" on the row containing "Benefit 14"
    When I fill in "sponsorship_benefit[label]" with ""
    And I press "Update"
    Then I should see "This value should not be blank."

  Scenario: I edit the sponsorship benefit "Benefit 14"
    Given I am on "sponsorship-benefit/"
    And I click "Edit" on the row containing "Benefit 14"
    When I fill in "sponsorship_benefit[label]" with "Benefit 15"
    And I press "Update"
    Then I should be on "sponsorship-benefit/"
    And I should see "Benefit 15"

  @javascript
  Scenario: I cancel the delete of sponsorship benefit "Benefit 15"
    Given I am on "sponsorship-benefit/"
    When I press "Delete" on the row containing "Benefit 15" and cancel popup
    Then I should see "Benefit 15"

  @javascript
  Scenario: I confirm the delete of sponsorship benefit "Benefit 15"
    Given I am on "sponsorship-benefit/"
    When I press "Delete" on the row containing "Benefit 15" and confirm popup
    Then I should not see "Benefit 15"
