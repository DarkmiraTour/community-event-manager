Feature: Dashboard
  As an admin
  I should see some widget and metrics
  In order to have a summary of my event

  Scenario: I should not see dashboard if I am not logged in
    When I am on "/"
    Then I should see "Login"
    But I should not see "Dashboard"

  Scenario: Event schedule widget
    Given I am logged in as an admin
    When I am on "/"
    And I follow "Manage"
    Then I should see "Event schedule"
    And I should see "Edit schedules"

  Scenario: Sponsorships widget
    Given I am logged in as an admin
    When I am on "/"
    And I follow "Manage"
    Then I should see "Sponsorships"
    And I should see "4 levels"
    And I should see "Level 0"
    And I should see "9 benefits"
    And I should see "Manage levels"

  Scenario: Brochure widget
    Given I am logged in as an admin
    When I am on "/"
    And I follow "Manage"
    Then I should see "Brochure"
    And I should see "Generate PDF"
    And I should see "Edit pages"
