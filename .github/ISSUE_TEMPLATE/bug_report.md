---
name: Bug Report
about: Report errors and problems

---


## Current Behavior

Add description to the current behavior you observed 

### How to reproduce scenario

Scenarios have to be presented using the [Gherkin syntax](https://docs.cucumber.io/gherkin/). 
You can follow this example :

Bug Report : No confirmation message when creating a Benefit 

Scenario: User select add a Benefit
    Given the user is connected with a role_admin
    When the user land on a add a Benefit form
    And user complete the form
    Then the Benefit has been added to the database

## Expected behavior

Add description of the expected behavior that will fix the issue

### Expected Scenario

Scenarios have to be presented using the [Gherkin syntax](https://docs.cucumber.io/gherkin/). 
You can follow this example :

Bug Report : No confirmation message when creating a Benefit 

Scenario: User select add a Benefit
    Given the user is connected with a role_admin
    When the user land on a add a Benefit form
    And user fill the form
    Then the Benefit has been added to the database
    And the user get a confirmation message
    
### Possible solutions

Describe general solution, documentations and/or source code that could help fix this issue 
