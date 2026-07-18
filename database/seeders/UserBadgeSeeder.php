<?php

namespace Database\Seeders;

use App\Models\Badge;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserBadgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $badges = [
            [
                'name'=>'Penduduk Baru',
                'icon'=>'🌱',
                'discount'=>2.5
            ],
            [
                'name'=>'Anak Kampung',
                'icon'=>'🏡',
                'discount'=>5
            ],
            [
                'name'=>'Orang Lama',
                'icon'=>'⭐',
                'discount'=>7.5
            ],
            [
                'name'=>'Ketua Kampung',
                'icon'=>'👑',
                'discount'=>10
            ],
        ];

        foreach($badges as $badge){
            Badge::updateOrCreate(
                ['name' => $badge['name']],
                $badge
            );
        }

        $user = User::find(2);

        if ($user) {
            $badge = Badge::where('name','Orang Lama')->first();

            if ($badge) {
                $user->badges()->syncWithoutDetaching([$badge->id]);
            }
        }
    }
}
