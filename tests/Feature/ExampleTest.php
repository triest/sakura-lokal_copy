<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testPostCityTest(){
        //Route::post('/city/agree', 'GirlsController@agreeCity')->name('agreeCity');
        $response=$this->get('/');
        $response->assertStatus(200);
    }
}
