Feature: Sponsorship Benefit
  In order to test CRUD on sponsorship benefits
  As a user
  I need to be able to list all benefits and fill forms

  Scenario: I add a sponsorship benefit
    Given I am on "sponsorship-benefit/create"
    When I fill in "sponsorship_benefit[label]" with "Benefit 1"
    And I press "Save"
    Then I should be on "sponsorship-benefit/"
    And I should see "Benefit 1"

  Scenario: I don't fill all data needed when i add a sponsorship benefit
    Given I am on "sponsorship-benefit/create"
    When I press "Save"
    Then I should see "This value should not be blank."

  Scenario: I don't fill all data needed when i edit a sponsorship benefit "Benefit 1"
    Given I am on "sponsorship-benefit/"
    And I click "Edit" on the row containing "Benefit 1"
    When I fill in "sponsorship_benefit[label]" with ""
    And I press "Update"
    Then I should see "This value should not be blank."

  Scenario: I edit the sponsorship benefit "Benefit 1"
    Given I am on "sponsorship-benefit/"
    And I click "Edit" on the row containing "Benefit 1"
    When I fill in "sponsorship_benefit[label]" with "Benefit 10"
    And I press "Update"
    Then I should be on "sponsorship-benefit/"
    And I should see "Benefit 10"

  @javascript
  Scenario: I cancel the delete of sponsorship benefit "Benefit 10"
    Given I am on "sponsorship-benefit/"
    When I press "Delete" on the row containing "Benefit 10" and cancel popup
    Then I should see "Benefit 10"

  @javascript
  Scenario: I confirm the delete of sponsorship benefit "Benefit 10"
    Given I am on "sponsorship-benefit/"
    When I press "Delete" on the row containing "Benefit 10" and confirm popup
    Then I should not see "Benefit 10"
