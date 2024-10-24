<?php

namespace Tests\Feature;

use App\Models\Todo;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TodoTest extends TestCase
{    #[Test]
    public function must_show_todo_list(): void
    {
        $response = $this->getJson(route('todos.index'));
        $response->assertStatus(200);
        $response->assertJsonCount(3);
        $response->assertJsonStructure([
            'data' => [
                0 => [
                    'id',
                    'name',
                    'created_at',
                    'updated_at',
                ]
            ],
        ]);
    }

    #[Test]
    public function must_create_todo(): void
    {
        $response = $this->postJson(route('todos.store'), [
            'name' => 'Test Todo',
        ]);
        $response->assertStatus(201);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'created_at',
                'updated_at',
            ],
        ]);
        $this->assertDatabaseHas('todos', [
            'name' => 'Test Todo',
        ]);
    }

    #[Test]
    public function must_update_todo(): void
    {
        $id = Todo::first()->id;
        $response = $this->postJson(route('todos.update', $id), [
            'name' => 'Updated Test Todo',
        ]);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'created_at',
                'updated_at',
            ],
        ]);
        $this->assertDatabaseHas('todos', [
            'id' => $id,
            'name' => 'Updated Test Todo',
        ]);
    }

    #[Test]
    public function must_delete_todo(): void
    {
        $id = Todo::first()->id;
        $response = $this->deleteJson(route('todos.delete', $id));
        $response->assertStatus(204);
        $this->assertDatabaseMissing('todos', [
            'id' => $id,
        ]);
    }
}
