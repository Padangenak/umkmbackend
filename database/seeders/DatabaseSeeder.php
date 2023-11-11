<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Product;
use App\Models\Variant_attachment;
use App\Models\User_attachment;
use App\Models\Product_attachment;
use App\Models\Variant;
use App\Models\Category;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $user = User::create([
            'name'=>'Rizky',
            'role_id'=>1,
            'active'=>'On',
            'store'=>'Rizky Store',
            'address'=>'Cipoho',
            'phone_number'=>'0895331299363',
            'username'=>'adminrizky',
            'password'=> Hash::make('testing123'),
        ]);
        User_attachment::create([
            'path'=>'/images/',
            'type'=>'.png',
            'filename'=>'gQzPXK9nz10EzzhWK8cUtjrjMQzS5wuWFMgyZyfE.png',
            'user_id'=>$user->id
        ]);
        role::create([
            'id'=>1,
            'role'=>'admin',
        ]);
        role::create([
            'id'=>2,
            'role'=>'trader',
        ]);
        Category::create([
            'category'=>'Fashion',
        ]);
        Category::create([
            'category'=>'Makanan',
        ]);
        Category::create([
            'category'=>'Busana',
        ]);
    }
}
