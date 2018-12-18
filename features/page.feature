Feature: Page
  In order to test CRUD on page
  As an admin
  I need to be able to list all pages and fill forms

  Scenario: I add a page
    Given I am logged in as an admin
    When I am on the page creation page
    And I fill page file field with a simple "image" file test
    And I fill the page "title" field with "Page 4"
    And I fill the page "content" field with "It's a content for page 4"
    And I press "Save"
    Then I should be redirected on the page listing page
    And I should see "Page 4"


  Scenario: I fill a string in text file instead of a image when i add a page
    Given I am logged in as an admin
    When I am on the page creation page
    And I fill page file field with a simple "text" file test
    And I fill the page "title" field with "Page 5"
    And I fill the page "content" field with "It's a content for page 5"
    And I press "Save"
    Then I should see "This file is not a valid image."

  Scenario: I fill a huge image file when i add a page
    Given I am logged in as an admin
    When I am on the page creation page
    And I fill page file field with a huge "image" file test
    And I fill the page "title" field with "Page 5"
    And I fill the page "content" field with "It's a content for page 5"
    And I press "Save"
    Then I should see "The file is too large (9.49 MB). Allowed maximum size is 5 MB."

  Scenario: I don't fill all data needed when i add a page
    Given I am logged in as an admin
    When I am on the page creation page
    And I press "Save"
    Then I should see "This value should not be blank."

  Scenario: I fill a string in text file instead of a image when i edit page "Page 4"
    Given I am logged in as an admin
    When I am on the page listing page
    And I click "Edit" on the row containing "Page 4"
    And I fill the page "title" field with "Page 5"
    And I fill the page "content" field with "It's a content for page 5"
    And I fill page file field with a simple "text" file test
    And I press "Update"
    Then I should see "This file is not a valid image."

  Scenario: I fill a huge image file when i edit page "Page 4"
    Given I am logged in as an admin
    When I am on the page listing page
    And I click "Edit" on the row containing "Page 4"
    And I fill the page "title" field with "Page 5"
    And I fill the page "content" field with "It's a content for page 5"
    And I fill page file field with a huge "image" file test
    And I press "Update"
    Then I should see "The file is too large (9.49 MB). Allowed maximum size is 5 MB."

  Scenario: I don't fill all data needed when i edit a page "Page 4"
    Given I am logged in as an admin
    When I am on the page listing page
    And I click "Edit" on the row containing "Page 4"
    And I fill the page "title" field with ""
    And I fill the page "content" field with ""
    And I press "Update"
    Then I should see "This value should not be blank."

  Scenario: I edit the page "Page 4"
    Given I am logged in as an admin
    When I am on the page listing page
    And I click "Edit" on the row containing "Page 4"
    And I fill the page "title" field with "Page 5"
    And I fill the page "content" field with "It's a content for page 5"
    And I press "Update"
    Then I should be redirected on the page listing page
    And I should see "Page 5"

  @javascript
  Scenario: I cancel the delete of page "Page 5"
    Given I am logged in as an admin
    When I am on the page listing page
    And I press "Delete" on the row containing "Page 5" and cancel popup
    Then I should see "Page 5"

  @javascript
  Scenario: I confirm the delete of page "Page 5"
    Given I am logged in as an admin
    When I am on the page listing page
    And I press "Delete" on the row containing "Page 5" and confirm popup
    Then I should not see "Page 5"

