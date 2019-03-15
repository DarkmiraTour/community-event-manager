Feature: Interview Question
  In order to test CRUD on interview questions
  As an admin
  I need to be able to list all interview questions and fill forms

  Scenario: I add a interview question
    Given I am logged in as an admin
    When I am on the interview question creation page
    And I fill the interview question "question" field with "Is this a real question?"
    And I press "Add"
    Then I should be redirected on the interview question listing page
    And I should see "Is this a real question?"

  Scenario: I don't fill all data needed when i add a interview question
    Given I am logged in as an admin
    When I am on the interview question creation page
    And I press "Add"
    Then I should see "This value should not be blank."

  Scenario: I don't fill all data needed when i edit a interview question "Is this a real question?"
    Given I am logged in as an admin
    When I am on the interview question listing page
    And I click "Edit" on the row containing "Is this a real question?"
    And I fill the interview question "question" field with ""
    And I press "Save"
    Then I should see "This value should not be blank."

  Scenario: I edit the interview question "Is this a real question?"
    Given I am logged in as an admin
    When I am on the interview question listing page
    And I click "Edit" on the row containing "Is this a real question?"
    And I fill the interview question "question" field with "Is this a real interesting question?"
    And I press "Save"
    Then I should be redirected on the interview question listing page
    And I should see "Is this a real interesting question?"

  Scenario: I cancel the delete of interview question "Is this a real interesting question?"
    Given I am logged in as an admin
    When I am on the interview question listing page
    And I click "Delete" on the row containing "Is this a real interesting question?"
    And I should see "Do you wish to confirm \"Is this a real interesting question?\" interview question deletion?"
    And I click "Back to list" link
    Then I should be redirected on the interview question listing page
    And I should see "Is this a real interesting question?"

  Scenario: I confirm the delete of interview question "Is this a real interesting question?"
    Given I am logged in as an admin
    When I am on the interview question listing page
    And I click "Delete" on the row containing "Is this a real interesting question?"
    And I should see "Do you wish to confirm \"Is this a real interesting question?\" interview question deletion?"
    And I press "Delete"
    Then I should be redirected on the interview question listing page
    And I should not see "Is this a real interesting question?"
