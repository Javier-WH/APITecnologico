<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected $baseUrl = '/api/v1';
    const defaultAdmin = "defaultAdmin";
    const defaultUser = "defaultUser";
    const defaultGuest = "defaultGuest";
    const defaultPassword = "123456789";



}
