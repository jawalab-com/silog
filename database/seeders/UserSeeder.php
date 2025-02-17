<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        User::truncate();
        Team::truncate();
        \DB::table('team_user')->truncate();
        // User::factory(10)->withPersonalTeam()->create();
        // \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $owner = User::factory()->withPersonalTeam()->create([
            'name' => 'Owner',
            'email' => 'owner@example.com',
        ]);

        $team = $owner->ownedTeams()->first();
        $roles = ['pengaju', 'kepala-divisi-logistik', 'admin-gudang', 'purchasing', 'pejabat-teknis', 'pimpinan', 'keuangan'];
        foreach ($roles as $role) {
            $user = User::factory()->create([
                'name' => ucfirst($role).' User',
                'email' => $role.'@example.com',
            ]);
            $user->teams()->attach($team, ['role' => $role]);
            $user->switchTeam($team);
        }

        $userData = [
            [
                'name' => 'Divisi Anggaran/Akuntansi/Pengelolaan Aset',
                'division' => 'Divisi Anggaran/Akuntansi/Pengelolaan Aset',
                'department' => 'keuangan',
                'role' => 'keuangan',
                'email' => 'financesquad@solotechnopark.id',
            ],
            [
                'name' => 'Divisi Riset dan Inkubator',
                'division' => 'Divisi Riset dan Inkubator',
                'department' => 'umum',
                'role' => 'pengaju',
                'email' => 'risnibistek@solotechnopark.id',
            ],
            [
                'name' => 'Divisi Welding Produksi',
                'division' => 'Divisi Welding Produksi',
                'department' => 'umum',
                'role' => 'pengaju',
                'email' => 'weldpro@solotechnopark.id',
            ],
            [
                'name' => 'Divisi Welding Edukasi',
                'division' => 'Divisi Welding Edukasi',
                'department' => 'umum',
                'role' => 'pengaju',
                'email' => 'weldingedukasi@solotechnopark.id',
            ],
            [
                'name' => 'Divisi Diklat',
                'division' => 'Divisi Diklat',
                'department' => 'umum',
                'role' => 'pengaju',
                'email' => 'diklat@solotechnopark.id',
            ],
            [
                'name' => 'Divisi Produksi dan Pemasaran',
                'division' => 'Divisi Produksi dan Pemasaran',
                'department' => 'umum',
                'role' => 'pengaju',
                'email' => 'solomanufaktur@solotechnopark.id',
            ],
            [
                'name' => 'Divisi Sentra Fasilitas HAKI',
                'division' => 'Divisi Sentra Fasilitas HAKI',
                'department' => 'umum',
                'role' => 'pengaju',
                'email' => 'hakicenter@solotechnopark.id',
            ],
            [
                'name' => 'Divisi Administrasi dan Kepegawaian',
                'division' => 'Divisi Administrasi dan Kepegawaian',
                'department' => 'pelayanan',
                'role' => 'pengaju',
                'email' => 'humanresources@solotechnopark.id',
            ],
            [
                'name' => 'Divisi Logistik',
                'division' => 'Divisi Logistik',
                'department' => 'pelayanan',
                'role' => 'kepala-divisi-logistik',
                'email' => 'logistiknya@solotechnopark.id',
            ],
            [
                'name' => 'Purchasing',
                'division' => 'Divisi Logistik',
                'department' => 'pelayanan',
                'role' => 'purchasing',
                'email' => 'logistiknya2@solotechnopark.id',
            ],
            [
                'name' => 'Divisi Information Technology',
                'division' => 'Divisi Information Technology',
                'department' => 'pelayanan',
                'role' => 'pengaju',
                'email' => 'it@solotechnopark.id',
            ],
            [
                'name' => 'Divisi Pemberdayaan Kawasan',
                'division' => 'Divisi Pemberdayaan Kawasan',
                'department' => 'pelayanan',
                'role' => 'pengaju',
                'email' => 'kawasan@solotechnopark.id',
            ],
            [
                'name' => 'Divisi Public Relation',
                'division' => 'Divisi Public Relation',
                'department' => 'pelayanan',
                'role' => 'pengaju',
                'email' => 'publicrelations@solotechnopark.id',
            ],
            [
                'name' => 'Divisi Kerjasama dan Hukum',
                'division' => 'Divisi Kerjasama dan Hukum',
                'department' => 'umum',
                'role' => 'pengaju',
                'email' => 'partnershiplegal@solotechnopark.id',
            ],
            [
                'name' => 'OGSCI',
                'division' => 'OGSCI',
                'department' => 'keuangan',
                'role' => 'pengaju',
                'email' => 'ogsci@solotechnopark.id',
            ],
            [
                'name' => 'Divisi Keuangan (Khusus Pengajuan)',
                'division' => 'Divisi Keuangan',
                'department' => 'keuangan',
                'role' => 'pengaju',
                'email' => 'sementara1@gmail.com',
            ],
            [
                'name' => 'Admin Gudang',
                'division' => 'Admin Gudang',
                'department' => 'pelayanan',
                'role' => 'admin-gudang',
                'email' => 'sementara2@gmail.com',
            ],
            [
                'name' => 'Yudith Cahyantoro N S',
                'division' => 'Pimpinan',
                'department' => 'pimpinan',
                'role' => 'pimpinan',
                'email' => 'yudithcahyantoro@solotechnopark.id',
            ],
            [
                'name' => 'Wahyu Hermawan',
                'division' => 'Divisi Keuangan',
                'department' => 'keuangan',
                'role' => 'pejabat-teknis',
                'email' => 'wahyuhermawan@solotechnopark.id',
            ],
            [
                'name' => 'Untung Priyohantono',
                'division' => 'Divisi Pelayanan',
                'department' => 'pelayanan',
                'role' => 'pejabat-teknis',
                'email' => 'untungpriyohantono@solotechnopark.id',
            ],
            [
                'name' => 'Susilo Budi Arianto',
                'division' => 'Divisi Umum',
                'department' => 'umum',
                'role' => 'pejabat-teknis',
                'email' => 'susilobudiarianto@solotechnopark.id',
            ],
        ];

        foreach ($userData as $data) {
            $user = User::factory()->create([
                'name' => $data['name'],
                'email' => $data['email'],
                'division' => $data['division'],
                'department' => $data['department'],
            ]);
            $user->teams()->attach($team, ['role' => $data['role']]);
            $user->switchTeam($team);
        }
    }
}
