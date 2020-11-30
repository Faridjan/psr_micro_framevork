<?php


use Phinx\Seed\AbstractSeed;

class PostSeeder extends AbstractSeed
{
    public function run(): void
    {
        $this->table('posts')->truncate();

        $faker = Faker\Factory::create();
        $data = [];

        for ($i = 0; $i < 50; $i++) {
            $data[] = [
                'title' => trim($faker->sentence, '.'),
                'data' => $faker->date('d-m-Y H:i:s'),
                'content' => $faker->text(500)
            ];
        }

        $this->insert('posts', $data);

    }
}
