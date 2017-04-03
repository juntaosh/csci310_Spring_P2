# features/search.feature
Feature: homepage
	In order to see a word cloud
	As a website user
	I need to be able to search for a researcher's last name or keyword phrase,
	acess the page and perform additional features

	@javascript
	Scenario: Load word cloud at local host
	When I am on homepage
	And I should see "WordCloud"
	And I should see "Search"
	Then I should not see "Download Word Cloud"

	@javascript
	Scenario: Word cloud loaded and should give feed back after search
	When I am on homepage
	And I should see "WordCloud"
	And I fill in "???" for "searchWord"
	And I press "Search"
	And I should see a "canvas" element
	Then I should see "Download Word Cloud"

	@javascript
	Scenario: Search is usable
	When I am on homepage
	And I fill in "???" for "searchWord"
	When I fill in "???" for "searchWord"
	And I press "Search"
	Then I should see a "canvas" element

	@javascript
	Scenario: number of pages searched is configurable
	When I am on homepage
	And I fill in "charlie" for "searchWord"
	And I fill in "3" for "numberofpaper"
	And I press "Search"
	Then I should see "Word Cloud"
	Then I wait "20"
	When I press "students" in wordCloud
	Then I wait "15"
	Then I should see "39" 

