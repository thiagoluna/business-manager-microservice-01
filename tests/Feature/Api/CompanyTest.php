<?php

declare(strict_types=1);

namespace Tests\Feature\Api;

use App\Models\Category;
use App\Models\Company;
use Tests\TestCase;

class CompanyTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->category = Category::factory()->create();
        $this->categoryData = [
            'title'       => 'Title',
            'description' => 'Description'
        ];

        $this->company = Company::factory()->create();
        $this->companyData = [
            "name"        => "PROhhGTI",
            "category_id" => $this->category->id,
            "email"       => "emahhhil@email.com",
            "phone"       => "987556-5432",
            "whatsapp"    => "235545-6789",
            "image"       => "imageggg",
            "data"        => "2021/09/30"
        ];
    }

    public function test_get_all_companies() : void
    {
        $response = $this->getJson('/api/v1/companies');

        $response->assertStatus(200);
        $response->assertJsonCount(1, 'data');
    }

    public function test_get_single_company_by_uuid()
    {
        $response = $this->getJson("/api/v1/companies/{$this->company->uuid}");
        $response->assertStatus(200);
    }

    public function test_not_found_single_company() : void
    {
        $response = $this->getJson('/api/v1/companies/fake-company');
        $response->assertStatus(404);
    }

    public function test_validations_store_company() : void
    {
        $response = $this->postJson("/api/v1/companies/", [
            "name"        => "",
            "email"       => "",
            "phone"       => "",
            "whatsapp"    => ""
        ]);

        $response->assertStatus(422);
    }

    public function test_store_company() : void
    {
        $response = $this->postJson("/api/v1/companies/", $this->companyData);

        $response->assertStatus(201);
    }

    public function test_error_id_not_int_update_company() : void
    {
        $response = $this->putJson("/api/v1/companies/abc", $this->companyData);
        $response->assertStatus(404);
    }

    public function test_not_found_update_company() : void
    {
        $response = $this->putJson("/api/v1/companies/171", $this->companyData);
        $response->assertStatus(404);
    }

    public function test_validation_update_company() : void
    {
        $company = Company::factory()->create();

        $this->companyData = [
            "name"        => "",
            "email"       => "",
            "phone"       => "",
            "whatsapp"    => ""
        ];

        $response = $this->putJson("/api/v1/companies/{$company->id}", $this->companyData);
        $response->assertStatus(422);
    }

    public function test_update_company() : void
    {
        $companyData = [
            "name"        => "Updated",
            "category_id" => $this->category->id,
            "email"       => "Updated@email.com",
            "phone"       => "77777-7777",
            "whatsapp"    => "88888-8888",
            "image"       => "Updated",
            "data"        => "2001/01/01"
        ];

        $response = $this->putJson("/api/v1/companies/{$this->company->uuid}", $companyData);
        $response->assertStatus(200);
    }

    public function test_delete_company() : void
    {
        $response = $this->deleteJson("/api/v1/companies/{$this->company->uuid}");
        $response->assertStatus(200);
    }

    public function test_error_id_not_int_delete_company() : void
    {
        $response = $this->deleteJson("/api/v1/companies/abc");
        $response->assertStatus(404);
    }
}
