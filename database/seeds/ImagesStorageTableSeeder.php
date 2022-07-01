<?php

use Illuminate\Database\Seeder;
use App\Models\ImagesStorage;

class ImagesStorageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ImagesStorage::create([
            'imageName'     => 'Paysage',
            'url'  => 'https://www.industrialempathy.com/img/remote/ZiClJf-640w.avif',
        ]);
        ImagesStorage::create([
            'imageName'      => 'Vacances',
            'url'  => 'https://bdomagazine.files.wordpress.com/2019/10/lelivredimage.jpg',
        ]);
    }
}
