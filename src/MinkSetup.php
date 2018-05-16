<?php

namespace weitzman\DrupalTestTraits;

trait MinkSetup
{
    protected $minkBaseUrl;

  /**
   * @var \Behat\Mink\Session
   */
    protected $minkSession;

  /**
   *
   * Setup a Mink session. Call this from your setUp() method.
   *
   */
    public function setupMinkSession()
    {
        $this->minkBaseUrl = getenv('DTT_BASE_URL') ?: 'http://localhost:8000';

        $driver = new \Behat\Mink\Driver\GoutteDriver();
        $this->minkSession= new \Behat\Mink\Session($driver);
        $this->minkSession->start();

      // Create the artifacts directory if necessary (not functional yet).
        $output_dir = getenv('DTT_OUTPUT_DIR');
        if ($output_dir && !is_dir($output_dir)) {
            mkdir($output_dir, 0777, true);
        }
    }

  /**
   * Stop session. Call this from your tearDown() method.
   */
    public function tearDownMinkSession()
    {
        $this->getSession()->stop();
    }

    public function getSession()
    {
        return $this->minkSession;
    }

    public function getCurrentPage()
    {
        return $this->minkSession->getPage();
    }

    public function getCurrentPageContent()
    {
        return $this->getCurrentPage()->getContent();
    }

    public function visit($url)
    {
        if (!parse_url($url, PHP_URL_SCHEME)) {
            $url = $this->minkBaseUrl . $url;
        }
        $this->minkSession->visit($url);
    }
}
