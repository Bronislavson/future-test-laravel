<?php

namespace Tests\Unit;

use App\Models\Notebook;
use App\Models\NotebookPhoto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NotebookTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_it_has_fillable_attributes()
    {
        $data = [
            'full_name' => 'John Doe',
            'company' => 'Acme Corp',
            'email' => 'john@example.com',
            'phone' => '123456789',
            'date_of_birth' => '2000-01-01',
        ];

        $notebook = Notebook::create($data);

        $this->assertDatabaseHas('notebooks', $data);
        $this->assertEquals('John Doe', $notebook->full_name);
    }

    /** @test */
    public function test_notebook_has_many_photos()
    {
        $notebook = Notebook::factory()->create();
        NotebookPhoto::factory()->count(3)->create(['notebook_id' => $notebook->id]);

        $this->assertCount(3, $notebook->images);
        $this->assertInstanceOf(NotebookPhoto::class, $notebook->images->first());
    }
}
