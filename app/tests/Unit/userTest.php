<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use App\Models\User;

class userTest extends TestCase
{
    use RefreshDatabase;
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
    public function test_stores_new_users()
    {
      $response = $this->postJson('api/register',[
          'name' => 'Berend',
          'email' => 'BerendBrokkepap@gmail.be',
          'password' => 'Azerty123',
      ]);
        $response->assertStatus(404);
    }
    public function test_can_add_chat()
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['']
        );
       $response = $this->post('api/games/1/chat',[
           'message'=> 'ik ben een bericht',
       ]);
    $response->assertStatus(404);
       
    }
    public function test_get_games()
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['']
        );

        $response = $this->get('/api/games');

        $response->assertStatus(200);
    }
    // public function test_get_game()
    // {
    //     Sanctum::actingAs(
    //         User::factory()->create(),
    //         ['']
    //     );

    //     $response = $this->get('/api/games/1');

    //     $response->assertStatus(200);
    // }
}
