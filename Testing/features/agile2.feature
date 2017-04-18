# features/agile2.feature
# Author Juntao Shen CSCI310-C
Feature: Agile2:Searching features:
	In order to have a more pleasant view of the word cloud
	and albe to extract data from the search with this web
	As a website user
	I need to be able to extract image(13), pdfs(6), see the
	generation rate(11), get the bibtex(8), start new search
	with the conference number on the word cloud(15) and 
	professors names(14).

	# @javascript
	# Scenario: searched word shall be highlighted in the abstract
	# Given I am on homepage
	# And I fill in "lifan" for "searchWord"
	# And I fill in "2" for "numberofpaper"
	# Then I press "Search"
	# And I wait until page loaded
	# Then I wait "3"
	# Then I click an "product" on the canvas
	# And I navigate to the new page with "product"
	# Then I wait "3"
	# And I click on the first title displayed
	# Then I wait "3"
	# Then I should see "product" highlighted


	# @javascript
	# Scenario: download image after wordCloud appeared (13)
	# Given I am on homepage
	# And I fill in "charlie" for "searchWord"
	# And I fill in "2" for "numberofpaper"
	# Then I press "Search"
	# And I wait until page loaded
	# Then I click the ".downloadBtn" element
	# Then I wait "10"
	# Then I should see image downloaded

	# @javascript
	# Scenario: download pdf from the wordcloud (6)
	# Given I am on homepage
	# And I fill in "charlie" for "searchWord"
	# And I fill in "2" for "numberofpaper"
	# Then I press "Search"
	# And I wait until page loaded
	# Then I click an "secruity" on the canvas
	# And I navigate to the new page
	# And I click on the first pdf
	# Then I wait "10"
	# Then I should see pdf downloaded

	# @javascript
	# Scenario: status bar show progess of the generation (11)
	# Given I am on homepage
	# And I fill in "charlie" for "searchWord"
	# And I fill in "2" for "numberofpaper"
	# And I should see a sempty bar
	# Then I press "Search"
	# And I wait until page loaded
	# Then I shuld see a full bar

	# @javascript
	# Scenario: check the bibtex based on the word cloud search results(8)
	# Given I am on homepage
	# And I fill in "charlie" for "searchWord"
	# And I fill in "2" for "numberofpaper"
	# Then I press "Search"
	# And I wait until page loaded
	# Then I click an "secruity" on the canvas
	# Given I navigate to the new page
	# And I wait "3"
	# And I click on the title displayed
	# And I wait "3"
	# Then I click on the bibtex
	# Then I should see the bitex displayed of that title

	# @javascript
	# Scenario: check the conferece search based on the word cloud search results(15)
	# Given I am on homepage
	# And I fill in "charlie" for "searchWord"
	# And I fill in "2" for "numberofpaper"
	# Then I press "Search"
	# And I wait until page loaded
	# Then I click an "secruity" on the canvas
	# Given I navigate to the new page
	# And I click on the conference title
	# And I wait "10"
	# Then I should see titles of the articles in that conference

	# @javascript
	# Scenario: click author will pop another independent search(14)
	# Given I am on homepage
	# And I fill in "charlie" for "searchWord"
	# And I fill in "2" for "numberofpaper"
	# Then I press "Search"
	# And I wait until page loaded
	# Then I click an "secruity" on the canvas
	# And I navigate to the new page
	# And I click on the first author
	# Then I wait until page loaded
	# Then I should see word cloud searched with that author

	@javascript
	Scenario: word cloud could be generated by any key words
	Given I am on homepage
	And I fill in "java" for "searchWord"
	And I fill in "3" for "numberofpaper"
	Then I press "Search"
	And I wait until page loaded
	Then I should see wordcloud and can interact with it
	Then I wait "10"