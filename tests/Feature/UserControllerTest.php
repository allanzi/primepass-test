<?php

namespace Tests\Feature;

use App\Http\Controllers\UserController;
use App\User;
use Faker\Factory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    public function testIndex()
    {
        $method = $this->getController()->index();
        $response = $this->json('GET', '/api/user');

        $this->assertInstanceOf(JsonResponse::class, $method);
        $this->assertInstanceOf(Collection::class, $method->original['data']);
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data' => [
                         '*'=> [
                             'id' ,'name' ,'email' ,'email_verified_at' ,'created_at' ,'updated_at'
                         ]
                     ]
                 ]);
    }

    public function testShow()
    {
        $id = User::all()->last()->id;
        $method = $this->getController()->index();
        $response = $this->json('GET', "/api/user/{$id}");

        $this->assertInstanceOf(JsonResponse::class, $method);
        $this->assertInstanceOf(Collection::class, $method->original['data']);
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data' => [
                         'id' ,'name' ,'email' ,'email_verified_at' ,'created_at' ,'updated_at'
                     ]
                 ]);
    }

    public function testShowWhenNotFoundError()
    {
        $id = User::all()->last()->id+1;
        $response = $this->json('GET', "/api/user/{$id}");
        $response->assertStatus(404);
    }

    public function testUpdate()
    {
        $id = User::all()->last()->id;
        $response = $this->json('PUT', "/api/user/{$id}", ['name' => 'Badah Test']);

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data' => [
                         'id' ,'name' ,'email' ,'email_verified_at' ,'created_at' ,'updated_at'
                     ]
                 ]);
    }

    public function testUpdateWhenNotFoundError()
    {
        $id = User::all()->last()->id+1;
        $response = $this->json('PUT', "/api/user/{$id}", ['name' => 'Badah Test']);

        $response->assertStatus(404);
    }

    public function testUpdateWhenError()
    {
        $id = User::all()->last()->id;
        $response = $this->json('PUT', "/api/user/{$id}", ['name' => 'B']);

        $response->assertStatus(422);
    }

    public function testStore()
    {
        $faker = Factory::create();
        $body = [
            'name' => $faker->name,
            'email' => $faker->email,
            'password' =>  'test_badah',
            'password_confirmation' => 'test_badah',
        ];
        $response = $this->json('POST', '/api/user', $body);

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data' => [
                         'id' ,'name' ,'email' ,'created_at' ,'updated_at'
                     ]
                 ]);
    }

    public function testStoreWhenError()
    {
        $faker = Factory::create();
        $body = [
            'name' => $faker->name,
            'email' => $faker->email,
            'password' =>  'test_badah',
            'password_confirmation' => 'test',
        ];
        $response = $this->json('POST', '/api/user', $body);

        $response->assertStatus(422);
    }

    private function getController()
    {
        $model = (new User());
        return (new UserController($model));
    }
}
