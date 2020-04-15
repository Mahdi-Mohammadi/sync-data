<?php

namespace Tests\Feature;

use App\Models\Outbox;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\JsonResponse;
use Tests\TestCase;

class UserRegisterTest extends TestCase
{

    use DatabaseMigrations;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testNewUserRegistration()
    {
        $this->withoutExceptionHandling();
        $response = $this->post(route('users.store'), [
            'email'    => 'example@gmail.com',
            'name'     => 'Ali Kalan',
            'password' => '847598759384'
        ]);

        $response->assertStatus(JsonResponse::HTTP_CREATED);

        $response->assertJson([
            'data' => [
                'email' => 'example@gmail.com',
                'name'  => 'Ali Kalan'
            ]
        ]);

        $outbox = Outbox::where([
            'published' => false,
            'payload->entity' => User::class,
            'payload->name' => 'Ali Kalan',
            'payload->email' => 'example@gmail.com'
        ])->exists();

        $this->assertTrue($outbox);

    }

    public function testValidation()
    {
        $user = factory(User::class)->create();

        $response = $this->post(route('users.store'), [
            'email'    => $user->email,
            'name'     => 'Ali Kalan',
            'password' => '847598759384'
        ]);

        $response->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonStructure(['errors' => ['email']]);
    }

}
