<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Obat>
 */
class ObatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama_obat' => fake()->randomElement(['Paracetamol', 'Amoxicillin', 'Aspirin', 'Ibuprofen', 'Cefadroxil', 'Antasida', 'Cetirizine', 'Omeprazole', 'Salbutamol', 'Vitamin C']),
            'kemasan' => fake()->randomElement(['Strip', 'Botol', 'Tube', 'Kotak']),
            'harga' => fake()->numberBetween(5000, 150000),
            'expired' => fake()->dateTimeBetween('now', '+3 years')->format('Y-m-d'),
            'golongan_obat' => fake()->randomElement(['Bebas', 'Keras', 'Bebas Terbatas', 'Narkotika']),
            'distributor' => fake()->company(),
            'produsen_obat' => fake()->company(),
            'stok' => fake()->numberBetween(0, 100),
        ];
    }
}
