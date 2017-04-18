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

    /**
     * @When I press :arg1 in wordCloud
     */
    public function iPressInWordcloud($arg1)
    {
        $element = $this->getSession()->getPage()->find('xpath','students');
        $element->click();
    }

    /**
     * @Then I should see :arg1 before :arg2
     */
    public function iShouldSeeBefore($arg1, $arg2)
    {
        $this->assertSession()->pageTextContains($this->fixStepArgument($arg1));
        $this->assertSession()->pageTextContains($this->fixStepArgument($arg2));
    }

/**
     * @Then I press :arg1 title
     */
    public function iPressTitle($arg1)
    {
        $this->assertSession()->pageTextContains($this->fixStepArgument($arg1));
    }

    /**
     * @Then I wait until page loaded
     */
    public function iWaitUntilPageLoaded()
    {
        $this->getSession()->wait(25000);
    }


    /**
     * @Then I click the :arg1 element
     */
    public function iClickTheElement($arg1)
    {
        $page = $this->getSession()->getPage();
        $element = $page->find('css', $arg1);
        if(empty($element)){
            throw new Exception("No html found");
        }
        $element->click();
    }

        /**
     * @Given I should see a sempty bar
     */
    public function iShouldSeeASemptyBar()
    {
        $mybar = $this->getSession()->getPage()->find('css','#myBar');
        if(empty($mybar)){
            throw new Exception("cannot find mybar");
        }
        if($mybar->getValue() != '0'){
            throw new Exception("Value incorrect");
        }
    }

    /**
     * @Then I shuld see a full bar
     */
    public function iShuldSeeAFullBar()
    {
        $mybar = $this->getSession()->getPage()->find('css','#myBar');
        if(!$mybar){
            throw new Exception("cannot find mybar");
        }
        if($mybar->getValue() != '2'){
            throw new Exception("Value incorrect");
        }
    }
    /**
     * @Then I click an :arg1 on the canvas
     */
    public function iClickAnOnTheCanvas($arg1)
    {
        $myCanvas = $this->getSession()->getPage()->find('css','#form canvas');
        if(empty($myCanvas)){
            throw new Exception("Unable to locate canvas");
        }
        $myCanvas -> click();
    }
    /**
     * @Then I navigate to the new page
     */
    public function iNavigateToTheNewPage()
    {
        $web = '/list_page.html?word=security&papers=2';
        $this->visitPath($web);
    }

     /**
     * @Then I click on the first author
     */
    public function iClickOnTheFirstAuthor()
    {
        $author = $this->getSession() -> getPage()->find('named', array('link_or_button', 'Charlie Kaufman'));
        if(empty($author)){
            throw new Exception("author not found");
        }
        $author -> click();
    }

    public function iShouldSeeWordCloudSearchedWithThatAuthor()
    {
        $this->assertSession()->pageTextContains($this->fixStepArgument('wordcloud'));
    }

    /**
     * @Then I should see word cloud searched with that author
     */
    public function iShouldSeeWordCloudSearchedWithThatAuthor2()
    {
         $this->assertSession()->pageTextContains($this->fixStepArgument('wordcloud'));
    }
    /**
     * @Then I click on the first pdf
     */
    public function iClickOnTheFirstPdf()
    {
        $pdf = $this->getSession() -> getPage()->find('named', array('link_or_button', 'PDF'));
        if(empty($pdf)){
            throw new Exception("author not found");
        }

       // $profile = new FirefoxProfile();
       // $profile->setPreference("browser.download.dir","../../../Downloads");
       // $profile->setPreference("browser.helperApps.neverAsk.saveToDisk","application/pdf");
       // $profile->setPreference("pdfjs.disabled",true);
       // $profile->setPreference("browser.download.folderList",2);
       // $profile->setPreference("browser.download.panel.shown",false);

       // $capabilities = DesiredCapabilities.firefox();
       // $capabilities.setCapability(FirefoxDriver.PROFILE);


        $pdf -> click();
    }

    /**
     * @Then I click yes for download
     */
    public function iClickYesForDownload()
    {
        $page = $this->getSession()->getPage();
        $element = $page->find('named',array('link_or_button','OK'));
        if (empty($element)){
            throw new Exception("cannot click");
        }
        $element->click();
    }


    /**
     * @Then I should see pdf downloaded
     */
    public function iShouldSeePdfDownloaded()
    {
        $filename = "What's different about security in a public cloud-.pdf";
        if(!file_exists('../../../Downloads/' . $filename)){
            throw new Exception("pdf file not found");
        }   
    }

    /**
     * @Then I should see image downloaded
     */
    public function iShouldSeeImageDownloaded()
    {
        $filename = 'wordcloud.png';
        if(!file_exists('../../../Downloads/' . $filename)){
            throw new Exception("image file not found");
        }
    }

/**
     * @Given I click on the title displayed
     */
    public function iClickOnTheTitleDisplayed()
    {
        $title = "What's different about security in a public cloud?";
        $page = $this->getSession()->getPage();
        $element = $page->find('named',array('content',$title));
        if (empty($element)){
            throw new Exception("cannot click");
        }
        $element->click();
    }

    /**
     * @Then I click on the bibtex
     */
    public function iClickOnTheBibtex()
    {
        $bibtex = 'Bibtex';
        $page = $this->getSession()->getPage();
        $element = $page->find('named',array('link_or_button',$bibtex));
        if (empty($element)){
            throw new Exception("cannot click");
        }
        $element->click();
    }

    /**
     * @Then I should see the bitex displayed of that title
     */
    public function iShouldSeeTheBitexDisplayedOfThatTitle()
    {
        $publisher = 'ACM';
        $this->assertSession()->pageTextContains($this->fixStepArgument($publisher));
    }

    /**
     * @Given I click on the conference title
     */
    public function iClickOnTheConferenceTitle()
    {
        $conference = 'Computer and Communications Security';
        $page = $this->getSession()->getPage();
        $element = $page->find('named',array('link_or_button',$conference));
        if (empty($element)){
            throw new Exception("cannot click");
        }
        $element->click();
    }

    /**
     * @Then I should see titles of the articles in that conference
     */
    public function iShouldSeeTitlesOfTheArticlesInThatConference()
    {
        $other_articles = 'Clouds and their discontents';
        $this->assertSession()->pageTextContains($this->fixStepArgument($other_articles));
    }

    /**
     * @Then I should see wordcloud and can interact with it
     */
    public function iShouldSeeWordcloudAndCanInteractWithIt()
    {
        $myCanvas = $this->getSession()->getPage()->find('css','#form canvas');
        if(empty($myCanvas)){
            throw new Exception("Unable to locate canvas");
        }
        $myCanvas -> click();
    }

    /**
     * @Then I navigate to the new page with :arg1
     */
    public function iNavigateToTheNewPageWith($arg1)
    {
        $web = '/list_page.html?word=product&papers=2';
        $this->visitPath($web);
    }

    /**
     * @Then I should see :arg1 highlighted
     */
    public function iShouldSeeHighlighted($arg1)
    {
        $page = $this->getSession()->getPage();
        $element = $page->find('named', array('content', $arg1));
        if(empty($element)){
            $error = arg1 + 'not found';
            throw new Exception($error );
        }
        $attributes = $element->getHtml();
        if(!$attributes =='gold'){
            throw Exception("color incorrect");
        }
    }

    /**
     * @Then I click on the first title displayed
     */
    public function iClickOnTheFirstTitleDisplayed()
    {
        $title = "Retrieval of Relevant Opinion Sentences for New Products";
        $page = $this->getSession()->getPage();
        $element = $page->find('named',array('content',$title));
        if (empty($element)){
            throw new Exception("cannot click");
        }
        $element->click();
    }

    /**
     * @Given I click the :arg1 button
     */
    public function iClickTheButton($arg1)
    {
        $button = $this->getSession()->getPage()->find('named',array('link_or_button',$arg1));
        if(empty($button)){
            throw new Exception("button not found Exception");
        }
        $button->click();
    }

    /**
     * @Then I should see :arg1 downloaded
     */
    public function iShouldSeeDownloaded($arg1)
    {
        $filename = $arg1;
        if(!file_exists('../../../Downloads/' . $filename)){
            throw new Exception("downloaded file not found");
        } 
    }

    /**
     * @Given I navigate to the cloud page
     */
    public function iNavigateToTheCloudPage()
    {
        $web = '/';
        $this->visitPath($web);
    }

    /**
     * @Then I should see :arg1 and :arg2
     */
    public function iShouldSeeAnd($arg1, $arg2)
    {
        //still need implementations
        throw new PendingException();
    }

    /**
     * @Given I selet the first paper
     */
    public function iSeletTheFirstPaper()
    {
        //need to ask Lifan define its names for testing
        $selections = $this->getSession()->getPage()->find('named',array('checkbox',''));
        if(empty($selections)){
            throw new Exception("select space not found on this page");
        }
        $selections->check();
    }

    /**
     * @Then I should see search results of :arg1
     */
    public function iShouldSeeSearchResultsOf($arg1)
    {
        //still need implementations
        throw new PendingException();
    }

}