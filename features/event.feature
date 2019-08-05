Feature: Event Selection
  In order to test CRUD on Event
  As an admin
  I need to be able to list all events and fill forms

  Scenario: I don't add an event and go back to home
    Given I am logged in as an admin
    When I am on the event creation page
    And I fill the event "name" field with "DarkmiraTour 2021"
    And I fill the event "description" field with "For the PHP community In Brazil"
    And I fill the event "address" "name" address field with "Fortaleza"
    And I fill the event "address" "streetAddress" address field with "6-7 Fortaleza"
    And I fill the event "address" "streetAddressComplementary" address field with ""
    And I fill the event "address" "postalCode" address field with "1234"
    And I fill the event "address" "city" address field with "Brazil-city"
    And I fill the event "startAt" field with "2021-02-01"
    And I fill the event "endAt" field with "2021-02-04"
    And I click "Back to home" link
    Then I should be redirected on the event listing page
    And I should see "Events management"
    And I should not see "DarkmiraTour 2021"

  Scenario: I add an event
    Given I am logged in as an admin
    When I am on the event creation page
    And I fill the event "name" field with "DarkmiraTour 2020"
    And I fill the event "description" field with "For the PHP community In Brazil"
    And I fill the event "address" "name" address field with "Fortaleza"
    And I fill the event "address" "streetAddress" address field with "6-7 Fortaleza"
    And I fill the event "address" "streetAddressComplementary" address field with ""
    And I fill the event "address" "postalCode" address field with "1234"
    And I fill the event "address" "city" address field with "Brazil-city"
    And I fill the event "startAt" field with "2020-02-01"
    And I fill the event "endAt" field with "2020-02-04"
    And I press "Create Event"
    Then I should be redirected on the event listing page
    And I should see "Events management"
    And I should see "DarkmiraTour 2020"

  Scenario: I select the event "DarkmiraTour 2020"
    Given I am logged in as an admin
    When I am on the event listing page
    And I click "Manage" on the card containing "DarkmiraTour 2020"
    Then I should see "DarkmiraTour 2020"
    And I should see "Dashboard"

  Scenario: I unselect the event "DarkmiraTour 2020" after selecting it
    Given I am logged in as an admin
    When I am on the event listing page
    And I click "Manage" on the card containing "DarkmiraTour 2020"
    And I click "DarkmiraTour 2020" link
    And I should see "Leave and go back to events"
    And I click "Leave and go back to events" link
    And I should see "Events management"
    And I should see "DarkmiraTour 2020"

  Scenario: I don't fill all data needed when I add an event
    Given I am logged in as an admin
    When I am on the event creation page
    And I press "Create Event"
    Then I should see "This value should not be blank."

  Scenario: I fill a passed date on the event creation page
    Given I am logged in as an admin
    When I am on the event creation page
    And I fill the event "name" field with "DarkmiraTour 2021"
    And I fill the event "description" field with "For the PHP community In Brazil"
    And I fill the event "address" "name" address field with "Fortaleza"
    And I fill the event "address" "streetAddress" address field with "6-7 Fortaleza"
    And I fill the event "address" "streetAddressComplementary" address field with ""
    And I fill the event "address" "postalCode" address field with "1234"
    And I fill the event "address" "city" address field with "Brazil-city"
    And I fill the event "startAt" field with "2014-01-01"
    And I fill the event "endAt" field with "2014-01-04"
    And I press "Create Event"
    Then I should see "The date \"Jan 01 2014\" cannot be set in the past."

  Scenario: I fill a start date more recent than the end date on the event creation page
    Given I am logged in as an admin
    When I am on the event creation page
    And I fill the event "name" field with "DarkmiraTour 2021"
    And I fill the event "description" field with "For the PHP community In Brazil"
    And I fill the event "address" "name" address field with "Fortaleza"
    And I fill the event "address" "streetAddress" address field with "6-7 Fortaleza"
    And I fill the event "address" "streetAddressComplementary" address field with ""
    And I fill the event "address" "postalCode" address field with "1234"
    And I fill the event "address" "city" address field with "Brazil-city"
    And I fill the event "startAt" field with "2020-01-10"
    And I fill the event "endAt" field with "2020-01-01"
    And I press "Create Event"
    Then I should see "Start date \"Jan 10 2020\" cannot be higher than end date \"Jan 01 2020\""

  Scenario: I don't fill all data needed when i edit a event "DarkmiraTour 2020"
    Given I am logged in as an admin
    When I am on the event listing page
    And I click "Edit" on the card containing "DarkmiraTour 2020"
    And I fill the event "name" field with ""
    And I press "Save changes"
    Then I should see "This value should not be blank."

  Scenario: I edit the event "DarkmiraTour 2020"
    Given I am logged in as an admin
    When I am on the event listing page
    And I click "Edit" on the card containing "DarkmiraTour 2020"
    And I fill the event "name" field with "Darkmira-Tour 2020"
    And I press "Save changes"
    Then I should see "Darkmira-Tour 2020"
    And I should see "Event"

  Scenario: I cancel the delete of event "Darkmira-Tour 2020"
    Given I am logged in as an admin
    When I am on the event listing page
    And I click "Delete" on the card containing "Darkmira-Tour 2020"
    And I should see "Do you wish to confirm \"Darkmira-Tour 2020\" event deletion?"
    And I click "Back to list" link
    Then I should be redirected on the event listing page
    And I should see "Darkmira-Tour 2020"

  Scenario: I confirm the delete of event "Darkmira-Tour 2020"
    Given I am logged in as an admin
    When I am on the event listing page
    And I click "Delete" on the card containing "Darkmira-Tour 2020"
    And I should see "Do you wish to confirm \"Darkmira-Tour 2020\" event deletion?"
    And I press "Delete"
    Then I should be redirected on the event listing page
    And I should not see "Darkmira-Tour 2020"
