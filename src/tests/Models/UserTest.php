<?php

namespace Tests\Models;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use PDOException;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_createGetAndDelete()
    {
        $oldUser = User::where('name', 'testuser')->first();
        $oldUser?->delete();

        // CREATE USER
        $user = new User();
        $user->name = 'testuser';
        $user->email = 'emaildoesntexist@testlaravel2022.com';
        $user->password = Hash::make('secret');
        $this->assertTrue($user->save());

        // CREATE SAME USER AGAIN
        $user2 = new User();
        $user2->name = 'testuser2';
        $user2->email = 'emaildoesntexist@testlaravel2022.com';
        $user2->password = Hash::make('secret');
        try {
            $user2->save();
            $this->fail();
        } catch (PDOException $e) {
            $this->assertTrue(true);
        }

        // GET CREATED USER
        $getuser = User::where('name', 'testuser')->first();
        $this->assertEquals('testuser', $getuser->name);

        // DELTE USER
        $getuser->delete();

        // TRY TO GET DELETED USER AGAIN
        $deletedUser = User::where('name', 'testuser')->first();
        $this->assertNull($deletedUser);
    }
}
