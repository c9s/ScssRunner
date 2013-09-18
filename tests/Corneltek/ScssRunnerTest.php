<?php

class ScssRunnerTest extends PHPUnit_Framework_TestCase
{
    public function testScssRunnerUpdate()
    {
        $templateDir = 'design';
        $scss = new \Corneltek\ScssRunner\ScssRunner;
        $scss->addTarget("$templateDir/s/scss", "$templateDir/s/css");
        $scss->addTarget("$templateDir/s/css/lib");
        $scss->enableCompass();
        ok($scss);
        // $scss->update(true);
    }
}

