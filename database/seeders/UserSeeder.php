<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $users = [
      [
        'name' => 'Loïs',
        'email' => 'lois@morgates.com',
        'email_verified_at' => now(),
        'password' => bcrypt('notrelogiquevousdepasse'),
        'bio' => 'Salut c\'est Loïs!',
      ],
      [
        'name' => 'Alice',
        'email' => 'alice@morgates.com',
        'email_verified_at' => now(),
        'password' => bcrypt('notrelogiquevousdepasse'),
        'bio' => 'Hôte passionnée de locations.',
      ],
      [
        'name' => 'Kevin Jérémy',
        'email' => 'kj@morgates.com',
        'email_verified_at' => now(),
        'password' => bcrypt('notrelogiquevousdepasse'),
        'bio' => 'À la recherche de la location idéale.',
      ],
    ];

    foreach ($users as $userData) {
      User::create($userData);
    }
  }
}