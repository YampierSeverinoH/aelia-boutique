<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SingleRecordPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_access_manage_about_page(): void
    {
        $this->seed();

        $user = User::where('email', 'admin@admin.com')->first();

        $response = $this->actingAs($user)->get('/admin/manage-about');

        $response->assertStatus(200);
    }

    public function test_admin_can_access_manage_company_page(): void
    {
        $this->seed();

        $user = User::where('email', 'admin@admin.com')->first();

        $response = $this->actingAs($user)->get('/admin/manage-company');

        $response->assertStatus(200);
    }
}
