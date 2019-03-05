---
name: Feature Request
about: ideas for new features and improvements

---

## Description

add a full description of the wanted feature

## Scenarios
Scenarios have to be presented using the [Gherkin syntax](https://docs.cucumber.io/gherkin/). You can follow this example :

Feature : add new benefit 

Scenario: User select add a Benefit
    Given the user is connected with a role_admin
    When the user land on a add a Benefit form
    And user complete the form
    Then the Benefit has been added to the database
    And the user get a confirmation message