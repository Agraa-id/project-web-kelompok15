<?php

namespace Tests\Feature;

use App\Models\Program;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProgramCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_displays_saved_programs(): void
    {
        Program::create([
            'nama' => 'Servis rutin',
            'deskripsi' => 'Periksa rem dan ganti oli.',
        ]);

        $this->get('/')
            ->assertOk()
            ->assertSeeText('Program Prioritas')
            ->assertSeeText('Servis rutin');
    }

    public function test_program_can_be_created(): void
    {
        $this->post(route('programs.store'), [
            'nama' => 'Ganti oli',
            'deskripsi' => 'Ganti oli mesin setiap 2.000 km.',
        ])
            ->assertRedirect(route('programs.index'))
            ->assertSessionHas('status');

        $this->assertDatabaseHas('programs', [
            'nama' => 'Ganti oli',
            'deskripsi' => 'Ganti oli mesin setiap 2.000 km.',
        ]);
    }

    public function test_program_can_be_updated(): void
    {
        $program = Program::create([
            'nama' => 'Servis awal',
            'deskripsi' => 'Pemeriksaan awal.',
        ]);

        $this->put(route('programs.update', $program), [
            'nama' => 'Servis berkala',
            'deskripsi' => 'Periksa kondisi motor setiap bulan.',
        ])
            ->assertRedirect(route('programs.index'))
            ->assertSessionHas('status');

        $this->assertDatabaseHas('programs', [
            'id' => $program->id,
            'nama' => 'Servis berkala',
            'deskripsi' => 'Periksa kondisi motor setiap bulan.',
        ]);
    }

    public function test_program_can_be_deleted(): void
    {
        $program = Program::create([
            'nama' => 'Program sementara',
            'deskripsi' => 'Data yang akan dihapus.',
        ]);

        $this->delete(route('programs.destroy', $program))
            ->assertRedirect(route('programs.index'))
            ->assertSessionHas('status');

        $this->assertDatabaseMissing('programs', ['id' => $program->id]);
    }

    public function test_program_name_is_required(): void
    {
        $this->post(route('programs.store'), [
            'nama' => '',
            'deskripsi' => 'Deskripsi program.',
        ])->assertSessionHasErrors('nama');
    }
}
