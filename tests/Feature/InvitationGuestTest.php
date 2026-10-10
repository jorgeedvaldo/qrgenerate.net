<?php

namespace Tests\Feature;

use App\Models\Invitation;
use App\Models\InvitationGuest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InvitationGuestTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_guest_list_shows_a_personalised_link_per_guest(): void
    {
        $user = User::factory()->create();
        $invitation = Invitation::factory()->for($user)->create(['slug' => 'aurora-e-edvaldo']);
        $guest = InvitationGuest::factory()->for($invitation)->create([
            'name' => 'Tia Maria',
            'code' => 'tia-maria',
        ]);

        $this->actingAs($user)->get(route('invitations.guests', $invitation->slug))
            ->assertOk()
            ->assertSee('Tia Maria')
            ->assertSee($invitation->publicUrl($guest->code));
    }

    public function test_a_user_can_add_a_guest_and_gets_a_slug_code(): void
    {
        $user = User::factory()->create();
        $invitation = Invitation::factory()->for($user)->create();

        $this->actingAs($user)->post(route('invitations.guests.store', $invitation->slug), [
            'name'           => 'Família Silva',
            'group_label'    => 'Família da noiva',
            'email'          => 'silva@example.test',
            'max_companions' => 3,
        ])->assertSessionHas('status');

        $guest = $invitation->guests()->first();
        $this->assertSame('Família Silva', $guest->name);
        $this->assertSame('familia-silva', $guest->code);
        $this->assertSame(3, $guest->max_companions);
    }

    public function test_guests_with_the_same_name_get_different_codes(): void
    {
        $user = User::factory()->create();
        $invitation = Invitation::factory()->for($user)->create();

        $this->actingAs($user)->post(route('invitations.guests.store', $invitation->slug), ['name' => 'Tia Maria']);
        $this->actingAs($user)->post(route('invitations.guests.store', $invitation->slug), ['name' => 'Tia Maria']);

        $this->assertSame(
            ['tia-maria', 'tia-maria-2'],
            $invitation->guests()->orderBy('id')->pluck('code')->all()
        );
    }

    public function test_the_same_code_may_be_reused_on_a_different_invitation(): void
    {
        $user = User::factory()->create();
        $first = Invitation::factory()->for($user)->create();
        $second = Invitation::factory()->for($user)->create();

        $this->actingAs($user)->post(route('invitations.guests.store', $first->slug), ['name' => 'Tia Maria']);
        $this->actingAs($user)->post(route('invitations.guests.store', $second->slug), ['name' => 'Tia Maria']);

        $this->assertSame('tia-maria', $first->guests()->first()->code);
        $this->assertSame('tia-maria', $second->guests()->first()->code);
    }

    public function test_a_user_can_paste_a_whole_list_of_names(): void
    {
        $user = User::factory()->create();
        $invitation = Invitation::factory()->for($user)->create();

        $this->actingAs($user)->post(route('invitations.guests.bulk', $invitation->slug), [
            'names'       => "Família Silva\n\nTia Joana\r\nOnésimo e Edvaldo\n   \n",
            'group_label' => 'Família',
        ])->assertSessionHas('status');

        $guests = $invitation->guests()->get();
        $this->assertCount(3, $guests);
        $this->assertSame(['Família', 'Família', 'Família'], $guests->pluck('group_label')->all());
    }

    public function test_adding_a_guest_requires_a_name(): void
    {
        $user = User::factory()->create();
        $invitation = Invitation::factory()->for($user)->create();

        $this->actingAs($user)
            ->post(route('invitations.guests.store', $invitation->slug), ['name' => ''])
            ->assertSessionHasErrors('name');

        $this->assertSame(0, $invitation->guests()->count());
    }

    public function test_a_user_can_remove_a_guest(): void
    {
        $user = User::factory()->create();
        $invitation = Invitation::factory()->for($user)->create();
        $guest = InvitationGuest::factory()->for($invitation)->create();

        $this->actingAs($user)
            ->delete(route('invitations.guests.destroy', [$invitation->slug, $guest->id]))
            ->assertSessionHas('status');

        $this->assertDatabaseMissing('invitation_guests', ['id' => $guest->id]);
    }

    public function test_a_guest_of_another_invitation_cannot_be_removed(): void
    {
        $user = User::factory()->create();
        $invitation = Invitation::factory()->for($user)->create();
        $foreignGuest = InvitationGuest::factory()->create();

        $this->actingAs($user)
            ->delete(route('invitations.guests.destroy', [$invitation->slug, $foreignGuest->id]))
            ->assertNotFound();

        $this->assertDatabaseHas('invitation_guests', ['id' => $foreignGuest->id]);
    }

    public function test_removing_a_guest_keeps_their_reply(): void
    {
        $user = User::factory()->create();
        $invitation = Invitation::factory()->for($user)->create();
        $guest = InvitationGuest::factory()->for($invitation)->create();
        $rsvp = $invitation->rsvps()->create([
            'invitation_guest_id' => $guest->id,
            'name'                => 'Tia Maria',
            'attending'           => true,
        ]);

        $this->actingAs($user)->delete(route('invitations.guests.destroy', [$invitation->slug, $guest->id]));

        $this->assertDatabaseHas('invitation_rsvps', ['id' => $rsvp->id, 'invitation_guest_id' => null]);
    }
}
