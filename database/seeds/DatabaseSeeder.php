<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        \App\Admin::create([
            'name' => 'Ferry Stephanus Suwita',
            'username' => 'admin',
            'password' => bcrypt('rahasiaUjian2019')
        ]);
        \App\TahunAkademik::create([
            'tahun_akademik' => '2018/2019 Genap',
            'status' => 1
        ]);
        \App\Kelas::create([
            'nama_kelas' => 'PEC-10',
            'id_tahun_akademik' => 1,
        ]);
        \App\Kelas::create([
            'nama_kelas' => 'PEC-12 (KRY)',
            'id_tahun_akademik' => 1,
        ]);
        \App\Kelas::create([
            'nama_kelas' => 'PEC-11',
            'id_tahun_akademik' => 1,
        ]);
    }
}
