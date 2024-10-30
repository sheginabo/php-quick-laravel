<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DailySentenceControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_daily_sentence_default()
    {
        $response = $this->get('/api/daily-sentence');
        $response->assertStatus(200);
        $response->assertJson([
            'result' => 'success',
        ]);
        $response->assertJsonStructure([
            'result',
            'message',
        ]);
        $this->assertIsString($response->json('message'));
    }

    public function test_get_daily_sentence_metaphorsum()
    {
        $response = $this->get('/api/daily-sentence/metaphorsum');
        $response->assertStatus(200);
        $response->assertJson([
            'result' => 'success',
        ]);
        $response->assertJsonStructure([
            'result',
            'message',
        ]);
        $this->assertIsString($response->json('message'));
    }

    public function test_get_daily_sentence_itsthisforthat()
    {
        $response = $this->get('/api/daily-sentence/itsthisforthat');
        $response->assertStatus(200);
        $response->assertJson([
            'result' => 'success',
        ]);
        $response->assertJsonStructure([
            'result',
            'message',
        ]);
        $this->assertIsString($response->json('message'));
    }

    public function test_get_daily_sentence_wrong_type()
    {
        $response = $this->get('/api/daily-sentence/wrong_type');
        $response->assertStatus(500);
        $response->assertJson([
            'result' => 'failed',
        ]);
        $response->assertJsonStructure([
            'result',
            'message',
        ]);
        $this->assertIsString($response->json('message'));
    }
}
