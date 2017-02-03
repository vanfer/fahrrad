<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExampleTest extends TestCase
{
    /**
     * A test querying the central route.
     *
     * @return void
     */
    public function testCentralLoaded()
    {
        $this->visitRoute("central")
             ->see("Highscore")
             ->dontSee("Str5ecke");
    }
}
