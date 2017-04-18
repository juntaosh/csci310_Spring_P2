# features/agile2.feature
# Author Juntao Shen Yawen Cao CSCI310-C
Feature: Agile2:Searching features:
	In order to have a more pleasant view of the word cloud
	and albe to extract data from the search with this web
	As a website user
	I need to be able to export lists of papers as plain
	text or pdfs(10), access previous search on the current
	tab(11), generate new word cloud if select subset of 
	papers(12) and download highlighted PDFs(15).

	@javascript
	Scenario: searched results should be able to export as lists
	of plain text of pdfs (10)
	Given I am on homepage
	And I fill in "charlie" for "searchWord"
	And I fill in "2" for "numberofpaper"
	Then I press "Search"
	And I wait until page loaded
	Then I click an "secruity" on the canvas
	Given I navigate to the new page
	And I click the "Export List as txt" button
	And I wait "3"
	Then I should see "tableExport.txt" downloaded
	And I click the "Export List as pdf" button
	And I wait "3"
	Then I should see "tableExport.pdf" downloaded

	@javascript
	Scenario: searched results should be albe to see in the
	cloud page(11)
	Given I am on homepage
	And I fill in "charlie" for "searchWord"
	And I fill in "2" for "numberofpaper"
	Then I press "Search"
	And I wait until page loaded
	Then I click an "secruity" on the canvas
	Then I navigate to the new page
	Given I navigate to the cloud page
	And I wait "5"
	Then I should see "charlie" and "2"

	@javascript
	Scenario: generate new word cloud with selected papers(12)
	Given I am on homepage
	And I fill in "charlie" for "searchWord"
	And I fill in "2" for "numberofpaper"
	Then I press "Search"
	And I wait until page loaded
	Then I click an "secruity" on the canvas
	Then I navigate to the new page
	And I selet the first paper
	Then I wait "10"
	# Then I should see search results of "What's different about security in a public cloud?"

	@javascript
	Scenario: download highlighted pdf when abstract is pressed
	Given I am on homepage
	And I fill in "lifan" for "searchWord"
	And I fill in "2" for "numberofpaper"
	Then I press "Search"
	And I wait until page loaded
	Then I wait "3"
	Then I click an "product" on the canvas
	And I navigate to the new page with "product"
	Then I wait "3"
	And I click on the first title displayed
	Then I wait "3"
	Then I should see "xxx.pdf" downloaded