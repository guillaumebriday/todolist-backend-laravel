<?php

namespace Tests;

use App\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Return an user with the anakin state
     * @return User
     */
    protected function anakin($overrides = [])
    {
        return factory(User::class)->states('anakin')->create($overrides);
    }
}
