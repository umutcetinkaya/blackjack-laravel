<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StartGameTest extends TestCase
{
    /** @test */
    public function it_has_start_game_command()
    {
        $this->assertTrue(class_exists(\App\Console\Commands\StartGame::class));
    }

    /** @test */
    public function it_can_start_games()
    {
        $this->artisan('start:game')
            ->expectsOutput('FINISH GAME')
            ->assertExitCode(0);
    }

}
