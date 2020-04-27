<?php

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $role = ['Koordinator Produksi','Petugas Mekanik','Petugas Logistik','Kru Bus'];
        for ($i=0; $i < 4; $i++) {
	    	App\Models\Role::create([
	            'role' => $role[$i],
	            'created_at'=>date("Y-m-d H:i:s")
	        ]);
    	}
             $this->command->info("Role berhasil diinsert");
    }
}
