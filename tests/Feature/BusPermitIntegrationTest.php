<?php

namespace Tests\Feature;

use App\Models\Bus;
use App\Models\BusPermit;
use App\Models\User;
use App\Models\Workshop;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Carbon\Carbon;
class BusPermitIntegrationTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_bus_permit_success()
    {
        $user = factory(User::class)->make([
            'id' => 4,
            'id_role'=>4
        ]);
            $workshop = new Workshop();
            $workshop->hull_code = 123;
            $workshop->user_id = $user->id;
            $workshop->order_date = Carbon::now()->toDateTimeString();
            $workshop->workshop_number = 1;
            $workshop->note = 'Ada kerusakan bus dibagian mesin';
            $workshop->work_type ='Mesin';
            $workshop->save();

        $response = $this->actingAs($user)->call('POST',route('buscheck.verify'),[
            'hull_code' => 123,
            'user_id' => $user->id,
            'workshopnumber' => 1,
            'note' => 'Tidak ada',
            'date' => Carbon::now()->toDateTimeString(),
        ]);

        $this->assertDatabaseHas('bus_permits',[
            'hull_code' => 123,
            'user_id' => $user->id,
            'workshop_number'=>1,
            'note' => 'Tidak ada',
            'date' => Carbon::now()->toDateTimeString(),
            ]); 

        

        $response->assertRedirect(route('permits.request'));
        $response->assertSessionHas(['status'=>'Berhasil menambah data kendaraan yang sudah selesai diperbaiki']);
        
    }
    public function test_bus_permit_failed()
    {
        $user = factory(User::class)->make([
            'id' => 4,
            'id_role'=>4
        ]);

        $response = $this->actingAs($user)
        ->post(route('buscheck.verify'),[
            'hull_code' => 123,
            'user_id' => $user->id,
            'note' => 'Ada rusak  nih',
            'date' => Carbon::now()
        ]);

        $response->assertRedirect(route('permits.request'));
        $response->assertSessionHasErrors('workshopnumber');
    }
}
