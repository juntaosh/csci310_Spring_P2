# features/search.feature
Feature: homepage
	In order to see a word cloud
	As a website user
	I need to be able to search for a researcher's last name or keyword phrase,
	acess the page and perform additional features

	@javascript
	Scenario: Load word cloud at local host
	Given I am on homepage
	And I should see "WordCloud"
	And I should see "Search"
	Then I should not see "Download Word Cloud"

	@javascript
	Scenario: Word cloud loaded and should give feed back after search
	Given I am on homepage
	And I should see "WordCloud"
	And I fill in "???" for "artistSearch"
	And I press "Search"
	And I should see a "canvas" element
	Then I should see "Download Word Cloud"

	@javascript
	Scenario: Search is usable
	Given I am on homepage
	And I fill in "???" for "artistSearch"
	When I fill in "???" for "artistSearch"
	And I press "Search"
	Then I should see a "canvas" element

	@javascript
	Scenario: number of pages searched is configurable
	Given I am on homepage
	And I fill in "???" for "numberofpaper"
	And I press "Search"
	Then I should see "Word Cloud"
	When I press "Word"
	Then I should see a "list" element 
	And I should check size of "list"

