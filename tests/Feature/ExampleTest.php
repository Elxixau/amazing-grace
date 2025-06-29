<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;
use App\Models\TicketGroup;

class BookingTest extends TestCase
{
    use RefreshDatabase;
    use WithoutMiddleware; // Jika belum ingin tes autentikasi

    /** @test */
    public function halaman_booking_bisa_diakses()
    {
        $response = $this->get(route('create'));
        $response->assertStatus(200);
        $response->assertSee('Pesan Tiket'); // asumsi ada teks ini di halaman
    }

    /** @test */
    public function dapat_memesan_tiket_dengan_data_valid()
    {
        $group = TicketGroup::factory()->create([
            'quota' => 5,
        ]);

        $response = $this->post(route('tiket.store'), [
            'name' => 'Indra',
            'email' => 'indra@example.com',
            'seat_count' => 2,
            'seat_group' => $group->group_code,
        ]);

        $response->assertRedirect(route('create')); // atau ke mana pun diarahkan
        $this->assertDatabaseHas('tickets', [
            'email' => 'indra@example.com',
            'seat_count' => 2,
        ]);
    }

    /** @test */
    public function gagal_memesan_jika_kuota_tidak_cukup()
    {
        $group = TicketGroup::factory()->create([
            'quota' => 1,
        ]);

        $response = $this->from(route('create'))->post(route('tiket.store'), [
            'name' => 'Budi',
            'email' => 'budi@example.com',
            'seat_count' => 3,
            'seat_group' => $group->group_code,
        ]);

        $response->assertRedirect(route('create'));
        $response->assertSessionHasErrors(['seat_group']);
    }
}
