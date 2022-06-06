<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class userTester extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    /**
     * Registers a new user.
     *
     * @return void
     */
    public function test_it_stores_new_users()
    {
      $response = $this->post('/register',[
          'name' => 'Berend',
          'email' => 'BerendBrokkepap@gmail.be',
          'password' => 'Azerty123',
          'password_confirmation' => 'Azerty123',
      ]);
        $response->assertStatus(201)->assertJson(["message" => "The user: Berend has been created."]);
    }
    public function test_it_can_add_chat()
    {
       $response = $this->post('/games/1/chat',[
           'message'=> 'ik ben een bericht',
       ]);
    $response->assertStatus(201)->assertJson([ "message" => "The chat message: ik ben een bericht has been created"]);
       
    }
    public function test_database()
    {
       $this->assertDatabaseHas('users',[
           'name' => 'Berend'
       ]);
        $this->assertDatabaseHas('chats', [
            'message' => 'ik ben een bericht'
        ]);
    }
}
