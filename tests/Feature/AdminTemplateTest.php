<?php

namespace Tests\Feature;

use App\Models\ReportTemplate;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminTemplateTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private User $operator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'username' => 'admin_test',
            'role_id' => 'ADMIN',
            'bidang_id' => 'JMBIN',
            'nama_satker' => 'JAMBIN PUSAT',
        ]);

        $this->operator = User::factory()->create([
            'username' => 'operator_test',
            'role_id' => 'OPR',
            'bidang_id' => 'REN',
            'nama_satker' => 'Biro Perencanaan',
        ]);
    }

    public function test_admin_can_access_template_management_page(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/template');
        $response->assertOk();
    }

    public function test_non_admin_cannot_access_template_management_page(): void
    {
        $response = $this->actingAs($this->operator)->get('/admin/template');
        $response->assertForbidden();
    }

    public function test_admin_can_download_default_master_template(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/template-download-default');
        $response->assertOk();
        $this->assertTrue(
            str_contains($response->headers->get('content-disposition') ?? '', 'Template_Master_LKjIP_JAMBIN.docx')
        );
    }

    public function test_admin_can_upload_and_activate_template(): void
    {
        Storage::fake('local');

        $file = UploadedFile::fake()->create('custom_template.docx', 100, 'application/vnd.openxmlformats-officedocument.wordprocessingml.document');

        $response = $this->actingAs($this->admin)->post('/admin/template/upload', [
            'name' => 'Template Khusus TW I',
            'file' => $file,
            'description' => 'Template kustom untuk pengujian',
        ]);

        $response->assertRedirect('/admin/template');

        $this->assertDatabaseHas('report_templates', [
            'name' => 'Template Khusus TW I',
            'file_name' => 'custom_template.docx',
            'is_active' => true,
            'uploaded_by' => 'admin_test',
        ]);

        $template = ReportTemplate::where('name', 'Template Khusus TW I')->first();
        $this->assertNotNull($template);
        Storage::disk('local')->assertExists($template->file_path);
    }

    public function test_admin_can_reset_to_default_template(): void
    {
        ReportTemplate::create([
            'name' => 'Template Lama',
            'file_path' => 'templates/old.docx',
            'file_name' => 'old.docx',
            'is_active' => true,
            'uploaded_by' => $this->admin->username,
        ]);

        $this->assertDatabaseHas('report_templates', ['name' => 'Template Lama', 'is_active' => true]);

        $response = $this->actingAs($this->admin)->post('/admin/template/reset-default');
        $response->assertRedirect('/admin/template');

        $this->assertDatabaseHas('report_templates', ['name' => 'Template Lama', 'is_active' => false]);
        $this->assertNull(ReportTemplate::getActiveTemplate());
    }
}
