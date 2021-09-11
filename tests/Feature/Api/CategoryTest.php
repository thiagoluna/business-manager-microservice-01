<?php

declare(strict_types=1);

namespace Tests\Feature\Api;

use App\Models\Category;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    public function test_get_all_categories() : void
    {
        Category::factory()->count(6)->create();

        $response = $this->getJson('/api/v1/categories');

        $response->assertStatus(200);
        $response->assertJsonCount(6, 'data');
    }

    public function test_get_single_category_by_id()
    {
        $category = Category::factory()->create();

        $response = $this->getJson("/api/v1/categories/{$category->id}");
        $response->assertStatus(200);
    }

    public function test_error_get_single_category() : void
    {
        $response = $this->getJson('/api/v1/categories/fake-category');
        $response->assertStatus(500);
    }

    public function test_validations_store_category() : void
    {
        $response = $this->postJson("/api/v1/categories/", [
            'title'       => '',
            'description' => ''
        ]);

        $response->assertStatus(422);
    }

    public function test_store_category() : void
    {
        $response = $this->postJson("/api/v1/categories/", [
            'title'       => 'Title',
            'description' => 'Category'
        ]);

        $response->assertStatus(201);
    }

    public function test_error_id_not_int_update_category() : void
    {
        $data = [
            'title'       => 'Title',
            'description' => 'Description'
        ];

        $response = $this->putJson("/api/v1/categories/abc", $data);
        $response->assertStatus(500);
    }

    public function test_not_found_update_category() : void
    {
        $data = [
            'title'       => 'Title',
            'description' => 'Description'
        ];

        $response = $this->putJson("/api/v1/categories/171", $data);
        $response->assertStatus(404);
    }

    public function test_validation_update_category() : void
    {
        $category = Category::factory()->create();

        $data = [
            'title'       => '',
            'description' => ''
        ];

        $response = $this->putJson("/api/v1/categories/{$category->id}", $data);
        $response->assertStatus(422);
    }

    public function test_update_category() : void
    {
        $category = Category::factory()->create();

        $data = [
            'title'       => 'Title',
            'description' => 'Description'
        ];

        $response = $this->putJson("/api/v1/categories/{$category->id}", $data);
        $response->assertStatus(200);
    }

    public function test_delete_category() : void
    {
        $category = Category::factory()->create();

        $response = $this->deleteJson("/api/v1/categories/{$category->id}");
        $response->assertStatus(200);
    }

    public function test_error_id_not_int_delete_category() : void
    {
        $data = [
            'title'       => 'Title',
            'description' => 'Description'
        ];

        $response = $this->deleteJson("/api/v1/categories/abc", $data);
        $response->assertStatus(500);
    }
}
