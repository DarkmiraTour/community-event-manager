Feature: Brochure
  Generate a semi-automatic brochure about my event
  that I can publish and share.

  Scenario: Trying to generate brochure PDF when being anonymous
    When I am on "/sponsorships/pdf"
    Then I should be on "/login/"
