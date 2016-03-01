<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
//        // create random users
//        $user = factory(App\User::class, 3)->create();

        // create date application
        $dateApp = factory(App\DateApplication::class, 10)->create();

        // assertion test
        $this->assertTrue(true);
    }

}
