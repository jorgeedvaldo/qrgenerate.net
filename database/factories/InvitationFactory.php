<?php

namespace Database\Factories;

use App\Models\Invitation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Invitation>
 */
class InvitationFactory extends Factory
{
    protected $model = Invitation::class;

    public function definition(): array
    {
        $one = fake()->firstName();
        $two = fake()->firstName();

        return [
            'user_id'          => User::factory(),
            'slug'             => Str::slug("{$one}-e-{$two}-" . fake()->unique()->numberBetween(1, 99999)),
            'type'             => 'wedding',
            'template'         => 'classic',
            'partner_one_name' => $one,
            'partner_two_name' => $two,
            'event_date'       => now()->addMonths(6)->toDateString(),
            'event_time'       => '15:30',
            'primary_color'    => '#b08968',
            'accent_color'     => '#7f5539',
            'font'             => 'cormorant',
            'rsvp_enabled'     => true,
            'allow_companions' => true,
            'max_companions'   => 2,
            'guestbook_enabled' => true,
            'countdown_enabled' => true,
            'is_active'        => true,
        ];
    }

    public function engagement(): static
    {
        return $this->state(fn () => ['type' => 'engagement']);
    }

    public function past(): static
    {
        return $this->state(fn () => ['event_date' => now()->subMonth()->toDateString()]);
    }

    public function hidden(): static
    {
        return $this->state(fn () => ['is_active' => false]);
    }
}
