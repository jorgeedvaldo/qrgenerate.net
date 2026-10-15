<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\InvitationGuest;
use Illuminate\Http\Request;

class InvitationGuestController extends Controller
{
    /** The guest list, each with its own personalised link. */
    public function index(Request $request, string $slug)
    {
        $invitation = $this->ownedInvitation($request, $slug);

        return view('invitations.guests', [
            'invitation' => $invitation,
            'guests'     => $invitation->guests()->withCount('rsvps')->get(),
            'locale'     => $this->locale($request),
        ]);
    }

    public function store(Request $request, string $slug)
    {
        $invitation = $this->ownedInvitation($request, $slug);

        $data = $request->validate([
            'name'           => ['required', 'string', 'max:120'],
            'email'          => ['nullable', 'email', 'max:200'],
            'phone'          => ['nullable', 'string', 'max:30'],
            'group_label'    => ['nullable', 'string', 'max:60'],
            'max_companions' => ['nullable', 'integer', 'min:0', 'max:20'],
        ]);

        $invitation->guests()->create([
            'name'           => $data['name'],
            'code'           => InvitationGuest::generateCode($invitation->id, $data['name']),
            'email'          => $data['email'] ?? null,
            'phone'          => $data['phone'] ?? null,
            'group_label'    => $data['group_label'] ?? null,
            'max_companions' => $data['max_companions'] ?? 0,
        ]);

        return back()->with('status', $this->locale($request) === 'pt'
            ? 'Convidado adicionado.'
            : 'Guest added.');
    }

    /** Add several guests at once, one name per line. */
    public function storeBulk(Request $request, string $slug)
    {
        $invitation = $this->ownedInvitation($request, $slug);

        $data = $request->validate([
            'names'       => ['required', 'string', 'max:8000'],
            'group_label' => ['nullable', 'string', 'max:60'],
        ]);

        $added = 0;
        foreach (preg_split('/\r\n|\r|\n/', $data['names']) as $line) {
            $name = trim($line);
            if ($name === '' || mb_strlen($name) > 120) {
                continue;
            }

            $invitation->guests()->create([
                'name'        => $name,
                'code'        => InvitationGuest::generateCode($invitation->id, $name),
                'group_label' => $data['group_label'] ?? null,
            ]);
            $added++;
        }

        return back()->with('status', $this->locale($request) === 'pt'
            ? "{$added} convidado(s) adicionado(s)."
            : "{$added} guest(s) added.");
    }

    public function destroy(Request $request, string $slug, InvitationGuest $guest)
    {
        $invitation = $this->ownedInvitation($request, $slug);
        abort_unless($guest->invitation_id === $invitation->id, 404);

        $guest->delete();

        return back()->with('status', $this->locale($request) === 'pt'
            ? 'Convidado removido.'
            : 'Guest removed.');
    }

    // ── Helpers ─────────────────────────────────────────────────────────────

    private function locale(Request $request): string
    {
        return $request->user()?->locale === 'en' ? 'en' : 'pt';
    }

    private function ownedInvitation(Request $request, string $slug): Invitation
    {
        return Invitation::where('slug', $slug)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();
    }
}
