<?php

namespace Database\Factories;

use App\Models\Invitation;
use App\Models\InvitationGuest;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<InvitationGuest>
 */
class InvitationGuestFactory extends Factory
{
    protected $model = InvitationGuest::class;

    public function definition(): array
    {
        $name = fake()->name();

        return [
            'invitation_id'  => Invitation::factory(),
            'name'           => $name,
            'code'           => Str::slug($name) . '-' . fake()->unique()->numberBetween(1, 99999),
            'max_companions' => 0,
        ];
    }
}
