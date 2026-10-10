<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\InvitationGift;
use App\Models\InvitationGuest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PublicInvitationController extends Controller
{
    /** The public invitation page, optionally personalised with ?c=. */
    public function show(Request $request, string $slug)
    {
        $invitation = Invitation::with(['events', 'gifts', 'photos', 'messages'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        [$guest, $guestName] = $this->resolveGuest($invitation, $request->query('c'));

        if ($guest && ! $guest->opened_at) {
            $guest->forceFill(['opened_at' => now()])->save();
        }

        Invitation::whereKey($invitation->id)->increment('view_count');

        return view('invitations.show', [
            'invitation' => $invitation,
            'guest'      => $guest,
            'guestName'  => $guestName,
        ]);
    }

    /** Confirm (or decline) attendance. */
    public function rsvp(Request $request, string $slug)
    {
        $invitation = Invitation::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        if (! $invitation->rsvpOpen()) {
            return back()->withErrors([
                'rsvp' => 'As confirmações de presença estão encerradas.',
            ])->withInput();
        }

        $maxCompanions = $invitation->allow_companions ? $invitation->max_companions : 0;

        $data = $request->validate([
            'name'            => ['required', 'string', 'max:120'],
            'email'           => ['nullable', 'email', 'max:200'],
            'phone'           => ['nullable', 'string', 'max:30'],
            'attending'       => ['required', 'in:0,1'],
            'companions'      => ['nullable', 'integer', 'min:0', "max:{$maxCompanions}"],
            'companion_names' => ['nullable', 'string', 'max:500'],
            'message'         => ['nullable', 'string', 'max:800'],
            'guest_code'      => ['nullable', 'string', 'max:32'],
            'guest_name'      => ['nullable', 'string', 'max:120'],
        ]);

        $attending = $data['attending'] === '1';

        [$guest] = $this->resolveGuest($invitation, $data['guest_code'] ?? null);

        $invitation->rsvps()->create([
            'invitation_guest_id' => $guest?->id,
            'name'                => $data['name'],
            'email'               => $data['email'] ?? null,
            'phone'               => $data['phone'] ?? null,
            'attending'           => $attending,
            'companions'          => $attending ? (int) ($data['companions'] ?? 0) : 0,
            'companion_names'     => $attending ? ($data['companion_names'] ?? null) : null,
            'message'             => $data['message'] ?? null,
            'ip_hash'             => $this->ipHash($request),
        ]);

        return redirect()
            ->to($invitation->publicUrl($guest?->code ?? ($data['guest_name'] ?? null)) . '#rsvp')
            ->with('rsvp_done', $attending ? 'yes' : 'no');
    }

    /** Leave a note in the guestbook. */
    public function message(Request $request, string $slug)
    {
        $invitation = Invitation::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        abort_unless($invitation->guestbook_enabled, 404);

        $data = $request->validate([
            'name'    => ['required', 'string', 'max:120'],
            'message' => ['required', 'string', 'max:600'],
        ]);

        $invitation->messages()->create([
            'name'    => $data['name'],
            'message' => $data['message'],
            'ip_hash' => $this->ipHash($request),
        ]);

        return redirect()->to($invitation->publicUrl() . '#recados')
            ->with('message_done', true);
    }

    /** Mark a gift as taken so two guests don't bring the same thing. */
    public function reserveGift(Request $request, string $slug, InvitationGift $gift)
    {
        $invitation = Invitation::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        abort_unless($gift->invitation_id === $invitation->id, 404);

        $data = $request->validate([
            'reserved_by' => ['required', 'string', 'max:120'],
        ]);

        if ($gift->is_reserved) {
            return redirect()->to($invitation->publicUrl() . '#presentes')
                ->withErrors(['gift' => 'Este presente já foi reservado por outro convidado.']);
        }

        $gift->update([
            'is_reserved' => true,
            'reserved_by' => $data['reserved_by'],
            'reserved_at' => now(),
        ]);

        return redirect()->to($invitation->publicUrl() . '#presentes')
            ->with('gift_done', $gift->name);
    }

    // ── Helpers ─────────────────────────────────────────────────────────────

    /**
     * Read the ?c= value. It is either a registered guest code or, as on a
     * hand-written link, simply the guest's name.
     *
     * @return array{0: ?InvitationGuest, 1: ?string}
     */
    private function resolveGuest(Invitation $invitation, ?string $value): array
    {
        $value = is_string($value) ? trim($value) : '';
        if ($value === '') {
            return [null, null];
        }

        $guest = InvitationGuest::where('invitation_id', $invitation->id)
            ->where('code', $value)
            ->first();

        if ($guest) {
            return [$guest, $guest->name];
        }

        // Free-text name: strip anything that is not a name.
        $name = Str::limit(preg_replace('/[^\p{L}\p{M}\s\'&.\-]/u', '', $value), 80, '');
        $name = trim(preg_replace('/\s+/', ' ', $name));

        return [null, $name !== '' ? $name : null];
    }

    /** A salted hash so repeat submissions can be spotted without storing IPs. */
    private function ipHash(Request $request): string
    {
        return hash_hmac('sha256', (string) $request->ip(), (string) config('app.key'));
    }
}
