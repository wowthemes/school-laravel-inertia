<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Attachment>
 */
class AttachmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $inner_path = date('Y').'/'.date('m');
        $image = $this->faker->image( public_path( 'uploads/'. $inner_path ), 400, 400, null, false);
        
        return [
            'name' => $this->faker->name(),
            'original_name' => $this->faker->name(),
            'mime' => 'image/jpeg',
            'extension' => 'jpg',
            'size' => 1000,
            'path' => $inner_path . '/' . $image,
            'user_id' => 1,
            'description' => null,
            'alt' => null,
            'disk' => 'uploads',
            'group' => null,
        ];
    }
}
