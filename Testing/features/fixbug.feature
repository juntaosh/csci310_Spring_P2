# features/fixbug.feature
# Author Juntao Shen CSCI310-C
Feature: Agile2:Searching features:
	In order to have a more reliable software,
	we need to fix bugs that has been tested
	in the previous sprint.


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
	# And pressing "Author" will not sort as intended

	@javascript
	Scenario: searched word shall be highlighted in the abstract
	Given I am on homepage
	And I fill in "lifan" for "searchWord"
	And I fill in "2" for "numberofpaper"
	Then I press "Search"
	And I wait until page loaded
	Then I wait "3"
	Then I click an "product" on the canvas
	And I navigate to the new page with "product"
	Then I wait "3"
	And I click on the conference unknown
	And I wait "5"
	Then I should see tile as conference title meaning default