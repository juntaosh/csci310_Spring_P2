# features/cloud.feature
Feature: Word CLoud Page page
	In order to see a word cloud
	As a website user
	I need to be able to use several features after the word cloud has
	been generated

	@javascript
	Scenario: Access previous searches
	Given I am on a homepage
	And I fill in "???" for "paperSearch"
	And I press "Search"
	And I should see a "canvas" element
	When I press "word"
	Then I should see "list" element
	