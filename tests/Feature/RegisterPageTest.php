<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterPageTest extends TestCase
{
    /** @test */
    public function the_register_page_loads_successfully()
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
        $response->assertSee('Register'); // adjust this if your page has Register word
    }
}
