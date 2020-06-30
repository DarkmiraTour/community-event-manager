Feature: Organisation
  As an admin
  I can import a csv file

  Scenario: I can import organisations CSV file
    Given I am logged in as an admin
    When I am on the organisation import page
    And I attach the file "organisation.csv" to "organisation_csv_upload_form_name"
    And I press "Import"
    And I should be redirected on the organisation listing page
    And I click "next" link
    Then I should see "Test Behat"

  Scenario: I'm trying to import a file with a wrong format
    Given I am logged in as an admin
    When I am on the organisation import page
    And I attach the file "test.jpg" to "organisation_csv_upload_form_name"
    And I press "Import"
    Then I should see "Please upload a valid csv"

  Scenario: I confirm the delete of organisation "Test Behat"
    Given I am logged in as an admin
    When I am on the page listing organisations
    And I click "next" link
    And I click "Delete" on the row containing "Test Behat"
    And I should see "Do you wish to confirm \"Test Behat\" organization deletion?"
    And I press "Delete"
    And I should be redirected on the organisation listing page
    And I should not see a "next" element
    Then I should not see "Test Behat"
