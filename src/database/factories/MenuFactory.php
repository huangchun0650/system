<?php

namespace Database\Factories;

use YFDev\System\App\Models\Menu;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Menu>
 */
class MenuFactory extends Factory
{
    protected $model = Menu::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'sort_order' => $this->faker->numberBetween(1, 100),
            'name'       => $this->faker->word(),
            'code'       => $this->faker->unique()->slug(2),
            'parent_id'  => NULL,
        ];
    }
}
