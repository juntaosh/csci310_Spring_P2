<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\MinkContext;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends MinkContext implements Context
{
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }
    /**
     * @When I wait :arg1
     */
    public function iWait($arg1)
    {
        sleep($arg1);
    }


    /**
     * @Then I should see background :arg1
     */
    public function iShouldSeeBackground($arg1)
    {
        return $this->getSession()->getPage()->find('css','background-color') === 'rgb(128,128,128)';
    }

    /**
     * @Then I should see text :arg1
     */
    public function iShouldSeeText($arg1)
    {
        return $this->getSession()->getPage()->find('css','click_buttons') === 'rgb(0,0,0)';
    }

    /**
     * @When I select Search bar
     */
    public function iSelectSearchBar()
    {
        $field = $this->fixStepArgument("artistSearch");
        $value = $this->fixStepArgument(" ");
        $this->getSession()->getPage()->fillField($field, $value);
    }

    /**
     * @Then I should see purple border around the bar
     */
    public function iShouldSeePurpleBorderAroundTheBar()
    {
        return $this->getSession()->getPage()->find('css','input.outline-color') === 'rgb(128,0,128)';
    }

    /**
     * @Then I should check size of :arg1
     */
    public function iShouldCheckSizeOf($arg1)
    {
        $table = $this->getPage()->find('css', '.main-content table');
        $row = $table->findall('css', 'tbody tr');
        return count($row) < $arg1;
    }

    // public function iAmOnAListPage2()
    // {
    //     throw new PendingException();
    // }
    /**
     * @Given I am on a list_page
     */
    public function iAmOnAListPage()
    {
        throw new PendingException();
    }

    /**
     * @Given I am on homePage
     */
    public function iAmOnHomepage2()
    {
        throw new PendingException();
    }

    /**
     * @Then I should see a link :arg1
     */
    public function iShouldSeeALink($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Then I should see column :arg1
     */
    public function iShouldSeeColumn($arg1)
    {
        throw new PendingException();
    }

}
