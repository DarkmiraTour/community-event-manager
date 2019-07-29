Feature: Talk Selection
    In order to test CRUD on Talk
    As an admin
    I need to be able to list all task and fill forms

  Scenario: I add an talk
    Given I am logged in as an admin
    When I am on the talk creation page
    And I fill the talk "title" field with "My best Talk dependency injection"
    And I fill the talk "description" field with "In this talk i can speak the dependancy injection"
    And I select "Behat" from "talk[speaker]"
    And I press "Add talk"
    Then I should see "Talks"
    And I should see "My best Talk dependency injection"
