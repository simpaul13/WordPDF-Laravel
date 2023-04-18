<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ConvertControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_converts_word_file_to_pdf_and_returns_download()
    {
        $wordFile = new UploadedFile(
            storage_path('app/public/test.docx'),
            'test.docx',
            true
        );

        $response = $this->post('/convert', ['file' => $wordFile]);

        $response->assertStatus(302);

        $response = $this->get($response->headers->get('Location'));

        $response->assertStatus(200);

    }
}
