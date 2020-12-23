<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\UserRoles;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Storage;

class UserTest extends TestCase
{
    use DatabaseTransactions;

    public function test_login()
    {
        $loginData = [
            'username' => 'test',
            'password' => '12345',
        ];

        $response = $this->json('POST','/api/user/login', $loginData, ['Accept' => 'application/json']);

        $response
            ->assertStatus(200)
            ->assertJsonStructure(['token', 'type']);
    }

    public function test_register()
    {
        $loginData = [
            'username' => 'test',
            'password' => '12345',
            'first_name' => 'test',
            'last_name' => 'test',
        ];

        $response = $this->json('POST', '/api/user/register', $loginData, ['Accept' => 'application/json']);

        $response
            ->assertStatus(200)
            ->assertJsonStructure(['token', 'type']);
    }

}
