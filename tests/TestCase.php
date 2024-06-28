<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected $baseUrl = '/api/v1';
    protected $defaultAdmin = "defaultAdmin";
    protected $defaultUser = "defaultUser";
    protected $defaultPassword = "123456789";
}
