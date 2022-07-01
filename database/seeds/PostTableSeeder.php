<?php

use Illuminate\Database\Seeder;
use App\Models\Post;

class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Post::insert([
            'webPage'    => 'Home',
            'firstPost'  => "votre entreprise locale d'usinage de pièces en bois",
            'secondPost' => "Incenderat autem audaces usque ad insaniam homines ad haec, quae nefariis egere conatibus,
                            Luscus quidam curator urbis subito visus: eosque ut heiulans baiolorum praecentor ad expediendum quod
                            orsi sunt incitans vocibus crebris. qui haut longe postea ideo vivus exustus est.",
            'thirdPost'  => "Verum ad istam omnem orationem brevis est defensio. Nam quoad aetas M.
                            Caeli dare potuit isti suspicioni locum, fuit primum ipsius pudore, deinde etiam patris diligentia disciplinaque munita.
                            Qui ut huic virilem togam deditšnihil dicam hoc loco de me; tantum sit, quantum vos existimatis; hoc dicam,
                            hunc a patre continuo ad me esse deductum; nemo hunc M. Caelium in illo aetatis flore vidit nisi aut cum patre aut mecum aut in M.
                            Crassi castissima domo, cum artibus honestissimis erudiretur.",
            'fourthPost' => 'test 4',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Post::insert([

            'webPage'    => 'Workplace',
            'firstPost'  => "Test 2votre entreprise locale d'usinage de pièces en bois",
            'secondPost' => 'test 2',
            'thirdPost'  => 'test 3',
            'fourthPost' => 'test 4',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        Post::insert([

            'webPage'    => 'Skills',
            'firstPost'  => "Incenderat autem audaces usque ad insaniam homines ad haec, quae nefariis egere conatibus,
                            Luscus quidam curator urbis subito visus: eosque ut heiulans baiolorum praecentor ad expediendum quod
                            orsi sunt incitans vocibus crebris. qui haut longe postea ideo vivus exustus est.",
            'secondPost' => 'test 2',
            'thirdPost'  => 'test 3',
            'fourthPost' => 'test 4',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
    }
}
