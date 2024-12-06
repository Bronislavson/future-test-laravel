<?php

namespace Tests\Unit;

use App\Models\Notebook;
use App\Models\NotebookPhoto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NotebookPhotoTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_it_belongs_to_notebook()
    {
        $notebook = Notebook::factory()->create();
        $photo = NotebookPhoto::create([
            'photo_path' => 'path/to/photo.jpg',
            'notebook_id' => $notebook->id,
        ]);

        $this->assertDatabaseHas('notebook_photos', [
            'photo_path' => 'path/to/photo.jpg',
            'notebook_id' => $notebook->id,
        ]);

        $this->assertEquals($notebook->id, $photo->notebook_id);
    }
}
