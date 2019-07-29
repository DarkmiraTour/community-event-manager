Feature: Slot management

  @javascript
  Scenario: I should be able to add a keynote on a schedule
    Given I am logged in as an admin
    And I follow "Select"
    And I am on "/schedule/"
    And I should see "Configure Schedule"

    # Add day
    And I follow "Add day"
    And I wait until I see "New day"
    And I press "Save new day"
    And I wait until I dont see "New day"
    And I should see "Configure Schedule"

    # Add space
    And I follow "Add space"
    And I wait until I see "New space"
    And I fill in "space[name]" with "Behat room"
    And I press "Save new space"
    And I wait until I dont see "New space"

    # Add slot
    When I click "Add Slot" link
    And I wait until I see "Add new slot"
    And I select "Behat room" from "slot[space]"
    And I select "Keynote" from "slot[type]"
    And I fill in "slot[title]" with "Testing with Behat"
    And I select "10" from "slot[start][hour]"
    And I select "12" from "slot[end][hour]"
    And I press "Save new slot"
    Then I wait until I see "10:00 - 12:00"
    And I should see "Configure Schedule"
    And I should see "Testing with Behat"
