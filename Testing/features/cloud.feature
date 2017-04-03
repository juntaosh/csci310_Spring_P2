# features/cloud.feature
Feature: list_Page
	In order to see a word cloud
	As a website user
	I need to be able to use several features after the word cloud has
	been generated

	@javascript
	Scenario: Access previous searches
	When I am on homepage
	And I fill in "charlie" for "searchWord"
	And I fill in "3" for "numberofpaper"
	And I press "Search"
	Then I should see "Word Cloud"
	Then I wait "20"
	When I press "students" in wordCloud
	Then I wait "15"
	Then I should see "39" 

	@javascript
	Scenario: Page ranked by frequency in paper
	Scenario: Access previous searches
	When I am on homepage
	And I fill in "charlie" for "searchWord"
	And I fill in "3" for "numberofpaper"
	And I press "Search"
	Then I should see "Word Cloud"
	Then I wait "20"
	When I press "students" in wordCloud
	Then I wait "15"
	Then I should see "39" before "77"
	

	@javascript
	Scenario: Show title author conference frequency and download links
	When I am on homepage
	And I fill in "charlie" for "searchWord"
	And I fill in "3" for "numberofpaper"
	And I press "Search"
	Then I should see "Word Cloud"
	Then I wait "20"
	When I press "students" in wordCloud
	Then I wait "15"
	Then I should see "Download Link"
	Then I should see "PDF"


	@javascript
	Scenario: Click on the column header for any of the four should allow sorting
	When I am on homepage
	And I fill in "charlie" for "searchWord"
	And I fill in "3" for "numberofpaper"
	And I press "Search"
	Then I should see "Word Cloud"
	Then I wait "20"
	When I press "students" in wordCloud
	Then I wait "15"
	And I press "Frequency" title
	Then I should see "77" before "39"

	