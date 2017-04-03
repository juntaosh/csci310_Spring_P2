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
	And I press "Search"
	And I should see a "canvas" element
	When I press "word"
	Then I am on a list_page
	And I should see a "list" element

	@javascript
	Scenario: Page ranked by frequency in paper
	When I am on homepage
	And I fill in "charlie" for "searchWord"
	And I press "Search"
	When I press "word"
	Then I am on a list_page
	And I should see a "table" element
	

	@javascript
	Scenario: Show title author conference frequency and download links
	When I am on homepage
	And I fill in "charlie" for "searchWord"
	And I press "Search"
	When I press "word"
	Then I am on a list_page
	And I should see a "table" element
	And I should see a link "???"
	And I should see "Frequency"

	@javascript
	Scenario: Click on the column header for any of the four should allow sorting
	When I am on homepage
	And I fill in "charlie" for "searchWord"
	And I press "Search"
	When I press "word"
	Then I am on a list_page
	And I should see a "table" element
	When I press "Title"
	Then I should see column "Title"
	When I press "Author"
	Then I should see column "Author"
	When I press "Frequency"
	Then I should see column "Frequency"
	When I press "Conference"
	Then I should see column "Conference"

	