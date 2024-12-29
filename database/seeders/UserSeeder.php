<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run()
    {
       
        DB::table('users')->insert([
            'name' => 'Ahmet Yılmaz',
            'email' => 'ahmet.yilmaz@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'), 
            'remember_token' => Str::random(10),
        ]);

        DB::table('users')->insert([
            'name' => 'Mehmet Demir',
            'email' => 'mehmet.demir@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),
            'remember_token' => Str::random(10),
        ]);

        DB::table('users')->insert([
            'name' => 'Ayşe Kaya',
            'email' => 'ayse.kaya@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),
            'remember_token' => Str::random(10),
        ]);


        /*     
            
        // Rastgele Türkçe isimli kullanıcı eklemek için
        $names = ['Emre', 'Zeynep', 'Okan', 'Seda', 'Murat', 'Büşra', 'Cem', 'Elif', 'Veli', 'Nisan'];
        foreach ($names as $name) {
            DB::table('users')->insert([
                'name' => $name . ' Yılmaz', // Türkçe isimler
                'email' => strtolower($name) . '@example.com', // E-posta adresini küçük harflerle oluşturuyoruz
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'remember_token' => Str::random(10),
            ]);
        } */
    }
}
