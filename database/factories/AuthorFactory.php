<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Author;
use App\Models\Profile;
class AuthorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
        ];
    }
    
    public function configure()
    {
        return $this->afterCreating(function (Author $author){
            $profile = Profile::factory()->make();
            $author->profile()->save($profile);
        });
    }
}