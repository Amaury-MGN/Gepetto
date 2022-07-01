<?php

use Illuminate\Database\Seeder;
use App\Models\User;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        for ($i = 0; $i < 10; $i++) {
            User::create([
                'role' => 1,
                'firstname' => $faker->firstname,
                'lastname' => $faker->lastname,
                'email' => $faker->unique()->safeEmail,
                'company' => $faker->company,
                'phoneNumber' => $faker->phoneNumber,
                'pseudonym' => $faker->unique()->name,
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => bcrypt('test'),
                'phoneNumber' => $faker->phoneNumber,
            ]);
        }
        User::create([
            'role'          => '1',
            'firstname'     => 'Admin',
            'lastname'      => 'Admin',
            'company'       => 'AdminCompany',
            'phoneNumber'   => 063255,
            'pseudonym'     => 'admin',
            'email'         => 'admin@admin.com',
            'password'      => bcrypt('admin'),
        ]);

        User::create([
            'role' => '2',
            'firstname'     => 'User',
            'lastname'      => 'User',
            'company'       => 'UserCompany',
            'phoneNumber'   => 063255,
            'pseudonym'     => 'user',
            'email'         => 'user@user.com',
            'password'      => bcrypt('user'),
        ]);

        User::create([
            'role' => '3',
            'firstname'     => 'Employee',
            'lastname'      => 'Employee',
            'company'       => 'EmployeeCompany',
            'phoneNumber'   => 063255,
            'pseudonym'     => 'employee',
            'email'         => 'employee@employee.com',
            'password'      => bcrypt('employee'),
        ]);
        User::create([
            'role' => '2',
            'firstname'     => 'Love',
            'lastname'      => 'Love',
            'company'       => 'LoveCompany',
            'phoneNumber'   => 063255,
            'pseudonym'     => 'love',
            'email'         => 'love@love.com',
            'password'      => bcrypt('love'),
        ]);
    }
}
