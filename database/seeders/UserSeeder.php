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
            'name' => 'Test User',
            'email' => 'test@example.com',
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
    }
}
