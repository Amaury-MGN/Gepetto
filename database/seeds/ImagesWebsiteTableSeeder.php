<?php

use Illuminate\Database\Seeder;
use App\Models\ImagesWebsite;

class ImagesWebsiteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ImagesWebsite::create([
            'webPage'     => 'Home',
            'firstImage'  => 'https://www.industrialempathy.com/img/remote/ZiClJf-640w.avif',
            'secondImage' => 'null',
            'thirdImage'  => 'null',
            'fourthImage' => 'null',

        ]);
        ImagesWebsite::create([
            'webPage'     => 'Workplace',
            'firstImage'  => 'https://bdomagazine.files.wordpress.com/2019/10/lelivredimage.jpg',
            'secondImage' => 'null',
            'thirdImage'  => 'null',
            'fourthImage' => 'null',
        ]);
        ImagesWebsite::create([
            'webPage'     => 'skills',
            'firstImage'  => 'https://bdomagazine.files.wordpress.com/2019/10/lelivredimage.jpg',
            'secondImage' => 'null',
            'thirdImage'  => 'null',
            'fourthImage' => 'null',
        ]);
    }
}
