Feature: Speaker Selection
    In order to test CRUD on Speaker
    As an admin
    I need to be able to list all speaker and fill forms

  Scenario: I don't add an speaker and go back to home
    Given I am logged in as an admin
    When I am on the speaker creation page
    And I fill the speaker "name" field with "Gael"
    And I select "Mr" from "speaker[title]"
    And I fill the speaker "email" field with "gael@gmail.com"
    And I fill the speaker "biography" field with "Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression."
    And I attach the file "default_speaker.svg" to "speaker[photo]"
    And I select "0" from "speaker[isInterviewSent]"
    And I click "Back to list" link
    

  Scenario: I add an speaker
    Given I am logged in as an admin
    When I am on the speaker creation page
    And I fill the speaker "name" field with "Gael"
    And I select "Mr" from "speaker[title]"
    And I fill the speaker "email" field with "gael@gmail.com"
    And I fill the speaker "biography" field with "Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression."
    And I attach the file "default_speaker.svg" to "speaker[photo]"
    And I select "0" from "speaker[isInterviewSent]"
    And I press "Add speaker"


  Scenario: I add an speaker
    Given I am logged in as an admin
    When I am on the speaker creation page
    And I fill the speaker "name" field with "Mathieu"
    And I select "Mr" from "speaker[title]"
    And I fill the speaker "email" field with "mathieu@gmail.com"
    And I fill the speaker "biography" field with "Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression."
    And I select "0" from "speaker[isInterviewSent]"
    And I press "Add speaker"