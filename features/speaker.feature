Feature: Speaker Selection
    In order to test CRUD on Speaker
    As an admin
    I need to be able to list all speakers and fill forms

  Scenario: I don't add a speaker and go back to home
    Given I am logged in as an admin
    When I am on the speaker creation page
    And I fill the speaker "name" field with "Gael"
    And I select "Mr" from "speaker[title]"
    And I fill the speaker "email" field with "site@test.com"
    And I fill the speaker "biography" field with "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin quis lacus pellentesque, ullamcorper odio nec, maximus augue."
    And I attach the file "default_speaker.svg" to "speaker[photo]"
    And I select "0" from "speaker[isInterviewSent]"
    And I click "Back to list" link
    
  Scenario: I add a speaker
    Given I am logged in as an admin
    When I am on the speaker creation page
    And I fill the speaker "name" field with "Yohan"
    And I select "Mr" from "speaker[title]"
    And I fill the speaker "email" field with "site@test.com"
    And I fill the speaker "biography" field with "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin quis lacus pellentesque, ullamcorper odio nec, maximus augue."
    And I attach the file "/images/test.jpg" to "speaker[photo]"
    And I select "0" from "speaker[isInterviewSent]"
    And I press "Add speaker"
    Then I should be redirected on the speaker listing page
    And I should see "Yohan"
    And I should see "site@test.com"
    When I click "Show" on the row containing "Yohan"
    And I should see "Speaker"
    And I should see "Yohan"


  Scenario: I add a speaker without specifying a photo
    Given I am logged in as an admin
    When I am on the speaker creation page
    And I fill the speaker "name" field with "Mathieu"
    And I select "Mr" from "speaker[title]"
    And I fill the speaker "email" field with "site@test.com"
    And I fill the speaker "biography" field with "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin quis lacus pellentesque, ullamcorper odio nec, maximus augue."
    And I select "0" from "speaker[isInterviewSent]"
    And I press "Add speaker"
    Then I should be redirected on the speaker listing page
    And I should see "Mathieu"
    And I should see "site@test.com"
    When I click "Show" on the row containing "Mathieu"
    And I should see "Speaker"
    And I should see "Mathieu"
    Then the "Content" HTML field should contain "images/default_speaker.svg"
    And I should see img "Tartine"
    When I request "POST images/default_speaker.svg"
    Then the response status code should be 201
    