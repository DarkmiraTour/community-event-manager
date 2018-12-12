Feature: Sponsorship Level Benefit
  In order to test table of sponsorship level benefits
  As an admin
  I need to be able to edit this table

  @javascript
  Scenario: I edit position of sponsorship level "Level 1" to the right
    Given I am logged in as an admin
    When I am on "sponsorship-level-benefit/edit"
    And I click on right arrow of element "Level 1"
    Then I should have "Level 1" at position 4

  @javascript
  Scenario: I edit position of sponsorship level "Level 1" to the left
    Given I am logged in as an admin
    When I am on "sponsorship-level-benefit/edit"
    And I click on left arrow of element "Level 1"
    Then I should have "Level 1" at position 3

  @javascript
  Scenario: I edit position of sponsorship benefit "Benefit 1" to the bottom
    Given I am logged in as an admin
    When I am on "sponsorship-level-benefit/edit"
    And I click on down arrow of element "Benefit 1"
    Then I should have "Benefit 1" at position 3

  @javascript
  Scenario: I edit position of sponsorship level "Benefit 1" to the top
    Given I am logged in as an admin
    When I am on "sponsorship-level-benefit/edit"
    And I click on up arrow of element "Benefit 1"
    Then I should have "Benefit 1" at position 2

  @javascript
  Scenario: I uncheck sponsorship benefit "Benefit 5" with the sponsorship level "Level 1"
    Given I am logged in as an admin
    When I am on "sponsorship-level-benefit/edit"
    And I uncheck element on line 6 and column 3
    Then I should have element on line 6 and column 3 unchecked
    And I should have element on line 6 and column 3 not filled

  @javascript
  Scenario: I check sponsorship benefit "Benefit 5" with the sponsorship level "Level 1"
    Given I am logged in as an admin
    When I am on "sponsorship-level-benefit/edit"
    And I check element on line 6 and column 3
    Then I should have element on line 6 and column 3 checked

  @javascript
  Scenario: I fill text with "test" for sponsorship benefit "Benefit 9" and sponsorship level "Level 1"
    Given I am logged in as an admin
    When I am on "sponsorship-level-benefit/edit"
    And I fill element on line 10 and column 3 with "test"
    And I click check on line 10 and column 3
    Then I should have element on line 10 and column 3 checked
    And I should have element on line 10 and column 3 filled with "test"

  @javascript
  Scenario: I remove text for sponsorship benefit "Benefit 9" and sponsorship level "Level 1"
    Given I am logged in as an admin
    When I am on "sponsorship-level-benefit/edit"
    And I fill element on line 10 and column 3 with ""
    And I click check on line 10 and column 3
    Then I should have element on line 10 and column 3 checked
    And I should have element on line 10 and column 3 not filled
