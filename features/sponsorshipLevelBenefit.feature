Feature: Sponsorship Level Benefit
  In order to test table of sponsorship level benefits
  As an admin
  I need to be able to edit this table

  Background: I connect as admin
    Given I am on "login/"
    When I fill in "login[email]" with "admin@test.com"
    And I fill in "login[password]" with "adminpass"
    And I press "Sign in"

  @javascript
  Scenario: I edit position of sponsorship level "Level 1" to the right
    Given I am on "sponsorship-level-benefit/edit"
    When I click on right arrow of element "Level 1"
    Then I should have "Level 1" at position 4

  @javascript
  Scenario: I edit position of sponsorship level "Level 1" to the left
    Given I am on "sponsorship-level-benefit/edit"
    When I click on left arrow of element "Level 1"
    Then I should have "Level 1" at position 3

  @javascript
  Scenario: I edit position of sponsorship benefit "Benefit 1" to the bottom
    Given I am on "sponsorship-level-benefit/edit"
    When I click on down arrow of element "Benefit 1"
    Then I should have "Benefit 1" at position 3

  @javascript
  Scenario: I edit position of sponsorship level "Benefit 1" to the top
    Given I am on "sponsorship-level-benefit/edit"
    When I click on up arrow of element "Benefit 1"
    Then I should have "Benefit 1" at position 2

  @javascript
  Scenario: I uncheck sponsorship benefit "Benefit 9" with the sponsorship level "Level 1"
    Given I am on "sponsorship-level-benefit/edit"
    When I uncheck element on line 10 and column 3
    Then I should have element on line 10 and column 3 unchecked
    And I should have element on line 10 and column 3 not filled

  @javascript
  Scenario: I check sponsorship benefit "Benefit 9" with the sponsorship level "Level 1"
    Given I am on "sponsorship-level-benefit/edit"
    When I check element on line 10 and column 3
    Then I should have element on line 10 and column 3 checked

  @javascript
  Scenario: I fill text with "test" for sponsorship benefit "Benefit 10" and sponsorship level "Level 1"
    Given I am on "sponsorship-level-benefit/edit"
    When I fill element on line 11 and column 3 with "test"
    And I click check on line 11 and column 3
    Then I should have element on line 11 and column 3 checked
    And I should have element on line 11 and column 3 filled with "test"

  @javascript
  Scenario: I remove text for sponsorship benefit "Benefit 10" and sponsorship level "Level 1"
    Given I am on "sponsorship-level-benefit/edit"
    When I fill element on line 11 and column 3 with ""
    And I click check on line 11 and column 3
    Then I should have element on line 11 and column 3 checked
    And I should have element on line 11 and column 3 not filled
