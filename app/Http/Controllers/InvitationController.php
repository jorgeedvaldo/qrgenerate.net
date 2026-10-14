<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvitationRequest;
use App\Models\Invitation;
use App\Support\HandlesImageUploads;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\StreamedResponse;

class InvitationController extends Controller
{
    use HandlesImageUploads;

    // ── Landing pages (SEO) ─────────────────────────────────────────────────

    public function landingEn()
    {
        $baseUrl = config('qrgenerate.url');

        return view('invitations.landing', [
            'pageLocale' => 'en',
            'locale'     => 'en',
            'seo' => [
                'title'       => 'Free Wedding & Engagement Invitation Generator – Online Invite with QR Code | QRGenerate',
                'description' => 'Create a beautiful online wedding or engagement invitation in minutes. Personalised guest links, RSVP, countdown, gift list, photo gallery and a QR code. Free.',
                'keywords'    => 'wedding invitation generator, online wedding invitation, digital wedding invite, engagement invitation, rsvp online, wedding website free, invitation qr code',
                'canonical'   => "{$baseUrl}/wedding-invitation-generator",
                'og_title'    => 'Free Online Wedding & Engagement Invitation Generator',
                'og_description' => 'Build your wedding or engagement invitation page with RSVP, countdown and gift list. Free, no design skills needed.',
                'hreflang'    => [
                    'en'        => "{$baseUrl}/wedding-invitation-generator",
                    'pt'        => "{$baseUrl}/pt/convite-de-casamento-online",
                    'x-default' => "{$baseUrl}/wedding-invitation-generator",
                ],
            ],
        ]);
    }

    public function landingPt()
    {
        $baseUrl = config('qrgenerate.url');

        return view('invitations.landing', [
            'pageLocale' => 'pt',
            'locale'     => 'pt',
            'seo' => [
                'title'       => 'Convite de Casamento e Noivado Online Grátis – Convite Virtual com QR Code | QRGenerate',
                'description' => 'Crie um convite de casamento ou noivado online em minutos. Link personalizado por convidado, confirmação de presença, contagem regressiva, lista de presentes e QR Code. Grátis.',
                'keywords'    => 'convite de casamento online, convite virtual casamento, convite de noivado, convite digital, confirmar presença online, site de casamento grátis, convite com qr code',
                'canonical'   => "{$baseUrl}/pt/convite-de-casamento-online",
                'og_title'    => 'Convite de Casamento e Noivado Online Grátis',
                'og_description' => 'Monte o convite virtual do seu casamento ou noivado com RSVP, contagem regressiva e lista de presentes. Grátis.',
                'hreflang'    => [
                    'pt'        => "{$baseUrl}/pt/convite-de-casamento-online",
                    'en'        => "{$baseUrl}/wedding-invitation-generator",
                    'x-default' => "{$baseUrl}/wedding-invitation-generator",
                ],
            ],
        ]);
    }

    // ── Owner dashboard ─────────────────────────────────────────────────────

    public function index(Request $request)
    {
        $invitations = $request->user()->invitations()
            ->withCount([
                'rsvps as confirmed_rsvps' => fn ($q) => $q->where('attending', true),
                'guests',
            ])
            // Companions are counted too, so the card shows people, not replies.
            ->withSum(
                ['rsvps as confirmed_companions' => fn ($q) => $q->where('attending', true)],
                'companions'
            )
            ->get();

        return view('invitations.index', [
            'invitations' => $invitations,
            'locale'      => $this->locale($request),
        ]);
    }

    public function create(Request $request)
    {
        return view('invitations.create', [
            'locale'     => $this->locale($request),
            'pageLocale' => $this->locale($request),
            'type'       => $request->query('type') === 'engagement' ? 'engagement' : 'wedding',
        ]);
    }

    public function store(InvitationRequest $request)
    {
        $data = $request->validated();

        $slug = Invitation::generateUniqueSlug(
            $data['partner_one_name'],
            $data['partner_two_name'] ?? null
        );

        $invitation = Auth::user()->invitations()->create(
            $this->attributes($request, $data, $slug) + ['slug' => $slug]
        );

        $this->syncEvents($invitation, $data['events'] ?? []);
        $this->syncSchedule($invitation, $data['schedule'] ?? []);
        $this->syncGifts($invitation, $data['gifts'] ?? []);
        $this->syncPhotos($invitation, $data['photos'] ?? [], $request);

        return redirect()->route('invitations.share', $invitation->slug);
    }

    public function edit(Request $request, string $slug)
    {
        $invitation = $this->ownedInvitation($request, $slug, withRelations: true);

        return view('invitations.edit', [
            'invitation' => $invitation,
            'locale'     => $this->locale($request),
            'pageLocale' => $this->locale($request),
        ]);
    }

    public function update(InvitationRequest $request, string $slug)
    {
        $invitation = $this->ownedInvitation($request, $slug);
        $data = $request->validated();

        $invitation->update($this->attributes($request, $data, $invitation->slug, $invitation));

        $this->syncEvents($invitation, $data['events'] ?? []);
        $this->syncSchedule($invitation, $data['schedule'] ?? []);
        $this->syncGifts($invitation, $data['gifts'] ?? []);
        $this->syncPhotos($invitation, $data['photos'] ?? [], $request);

        return redirect()->route('invitations.edit', $invitation->slug)
            ->with('status', $this->locale($request) === 'pt'
                ? 'Convite actualizado com sucesso.'
                : 'Invitation updated successfully.');
    }

    public function destroy(Request $request, string $slug)
    {
        $invitation = $this->ownedInvitation($request, $slug, withRelations: true);

        $this->deleteUploadedImage($invitation->cover_url);
        $this->deleteUploadedImage($invitation->couple_photo_url);
        foreach ($invitation->photos as $photo) {
            $this->deleteUploadedImage($photo->image_url);
        }

        $invitation->delete();

        return redirect()->route('invitations.index')
            ->with('status', $this->locale($request) === 'pt'
                ? 'Convite eliminado.'
                : 'Invitation deleted.');
    }

    // ── Share (links + QR code) ─────────────────────────────────────────────

    public function share(Request $request, string $slug)
    {
        $invitation = $this->ownedInvitation($request, $slug);

        return view('invitations.share', [
            'invitation' => $invitation,
            'locale'     => $this->locale($request),
        ]);
    }

    // ── RSVP list ───────────────────────────────────────────────────────────

    public function rsvps(Request $request, string $slug)
    {
        $invitation = $this->ownedInvitation($request, $slug);

        return view('invitations.rsvps', [
            'invitation' => $invitation,
            'rsvps'      => $invitation->rsvps()->with('guest')->get(),
            'locale'     => $this->locale($request),
        ]);
    }

    public function rsvpsCsv(Request $request, string $slug): StreamedResponse
    {
        $invitation = $this->ownedInvitation($request, $slug);
        $rsvps = $invitation->rsvps()->with('guest')->get();

        return response()->streamDownload(function () use ($rsvps) {
            $out = fopen('php://output', 'w');
            // BOM so Excel opens accented names correctly.
            fwrite($out, "\xEF\xBB\xBF");
            fputcsv($out, ['Nome', 'E-mail', 'Telefone', 'Presença', 'Acompanhantes', 'Nomes dos acompanhantes', 'Música para o DJ', 'Recado', 'Data']);

            foreach ($rsvps as $rsvp) {
                fputcsv($out, [
                    $rsvp->name,
                    $rsvp->email,
                    $rsvp->phone,
                    $rsvp->attending ? 'Sim' : 'Não',
                    $rsvp->companions,
                    $rsvp->companion_names,
                    $rsvp->song_request,
                    $rsvp->message,
                    $rsvp->created_at->format('d/m/Y H:i'),
                ]);
            }

            fclose($out);
        }, "confirmacoes-{$invitation->slug}.csv", [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    // ── Helpers ─────────────────────────────────────────────────────────────

    private function locale(Request $request): string
    {
        return $request->user()?->locale === 'en' ? 'en' : 'pt';
    }

    private function ownedInvitation(Request $request, string $slug, bool $withRelations = false): Invitation
    {
        $query = Invitation::where('slug', $slug)
            ->where('user_id', $request->user()->id);

        if ($withRelations) {
            $query->with(['events', 'scheduleItems', 'gifts', 'photos']);
        }

        return $query->firstOrFail();
    }

    /** Map validated input onto the model's columns. */
    private function attributes(
        Request $request,
        array $data,
        string $slug,
        ?Invitation $existing = null
    ): array {
        $directory = "invitations/{$slug}";

        return [
            'type'              => $data['type'],
            'template'          => $data['template'] ?? 'lilas',
            'font'              => $data['font'] ?? 'cormorant',
            'partner_one_name'  => $data['partner_one_name'],
            'partner_two_name'  => $data['partner_two_name'] ?? null,
            'partner_one_parents' => $data['partner_one_parents'] ?? null,
            'partner_two_parents' => $data['partner_two_parents'] ?? null,
            'display_title'     => $data['display_title'] ?? null,
            'tagline'           => $data['tagline'] ?? null,
            'story'             => $data['story'] ?? null,
            'welcome_message'   => $data['welcome_message'] ?? null,
            'event_date'        => $data['event_date'],
            'event_time'        => $data['event_time'] ?? null,
            'cover_url'         => $this->resolveImageUrl($request, 'cover_file', 'cover_url', $directory, $existing?->cover_url),
            'couple_photo_url'  => $this->resolveImageUrl($request, 'couple_photo_file', 'couple_photo_url', $directory, $existing?->couple_photo_url),
            'primary_color'     => $data['primary_color'] ?? '#b08968',
            'accent_color'      => $data['accent_color'] ?? '#7f5539',
            'dress_code'        => $data['dress_code'] ?? null,
            'dress_code_notes'  => $data['dress_code_notes'] ?? null,
            'dress_code_colors' => array_values(array_filter($data['dress_colors'] ?? [])) ?: null,
            'hashtag'           => $data['hashtag'] ?? null,
            'monogram'          => $data['monogram'] ?? null,
            'envelope_enabled'  => $request->boolean('envelope_enabled'),
            'petals_enabled'    => $request->boolean('petals_enabled'),
            'mascot_enabled'    => $request->boolean('mascot_enabled'),
            'guest_tips'        => $this->cleanTips($data['tips'] ?? []),
            'ride_links'        => $this->cleanRides($data['rides'] ?? []),
            'music_url'         => $data['music_url'] ?? null,
            'gift_message'      => $data['gift_message'] ?? null,
            'pix_key'           => $data['pix_key'] ?? null,
            'pix_name'          => $data['pix_name'] ?? null,
            'bank_details'      => $data['bank_details'] ?? null,
            'rsvp_enabled'      => $request->boolean('rsvp_enabled'),
            'rsvp_mode'         => $data['rsvp_mode'] ?? 'site',
            'song_request_enabled' => $request->boolean('song_request_enabled'),
            'rsvp_deadline'     => $data['rsvp_deadline'] ?? null,
            'allow_companions'  => $request->boolean('allow_companions'),
            'max_companions'    => $data['max_companions'] ?? 2,
            'guestbook_enabled' => $request->boolean('guestbook_enabled'),
            'countdown_enabled' => $request->boolean('countdown_enabled'),
            'contact_phone'     => $data['contact_phone'] ?? null,
            'contact_whatsapp'  => $data['contact_whatsapp'] ?? null,
            'contact_email'     => $data['contact_email'] ?? null,
        ];
    }

    private function syncEvents(Invitation $invitation, array $events): void
    {
        $invitation->events()->delete();

        $order = 0;
        foreach ($events as $event) {
            if (blank($event['title'] ?? null)) {
                continue;
            }

            $invitation->events()->create([
                'kind'       => $event['kind'] ?? 'ceremony',
                'title'      => $event['title'],
                'venue_name' => $event['venue_name'] ?? null,
                'address'    => $event['address'] ?? null,
                'maps_url'   => $event['maps_url'] ?? null,
                'event_date' => $event['event_date'] ?? null,
                'event_time' => $event['event_time'] ?? null,
                'notes'      => $event['notes'] ?? null,
                'sort_order' => $order++,
            ]);
        }
    }

    private function syncSchedule(Invitation $invitation, array $rows): void
    {
        $invitation->scheduleItems()->delete();

        $order = 0;
        foreach ($rows as $row) {
            if (blank($row['title'] ?? null)) {
                continue;
            }

            $invitation->scheduleItems()->create([
                'time'        => $row['time'] ?? null,
                'title'       => $row['title'],
                'description' => $row['description'] ?? null,
                'sort_order'  => $order++,
            ]);
        }
    }

    /** Drop blank rows so an empty repeater stores null rather than [[]]. */
    private function cleanTips(array $tips): ?array
    {
        $clean = [];
        foreach ($tips as $tip) {
            if (filled($tip['text'] ?? null)) {
                $clean[] = [
                    'icon' => $tip['icon'] ?? 'sparkle',
                    'text' => $tip['text'],
                ];
            }
        }

        return $clean ?: null;
    }

    private function cleanRides(array $rides): ?array
    {
        $clean = [];
        foreach ($rides as $ride) {
            if (filled($ride['label'] ?? null) && filled($ride['url'] ?? null)) {
                $clean[] = ['label' => $ride['label'], 'url' => $ride['url']];
            }
        }

        return $clean ?: null;
    }

    private function syncGifts(Invitation $invitation, array $gifts): void
    {
        // Reservations live on the gift row, so keep them when the owner edits the list.
        $reserved = $invitation->gifts()
            ->where('is_reserved', true)
            ->get()
            ->keyBy(fn ($gift) => mb_strtolower(trim($gift->name)));

        $invitation->gifts()->delete();

        $order = 0;
        foreach ($gifts as $gift) {
            if (blank($gift['name'] ?? null)) {
                continue;
            }

            $previous = $reserved->get(mb_strtolower(trim($gift['name'])));

            $invitation->gifts()->create([
                'name'        => $gift['name'],
                'description' => $gift['description'] ?? null,
                'image_url'   => $gift['image_url'] ?? null,
                'price'       => ($gift['price'] ?? '') !== '' ? $gift['price'] : null,
                'store_url'   => $gift['store_url'] ?? null,
                'is_reserved' => (bool) $previous?->is_reserved,
                'reserved_by' => $previous?->reserved_by,
                'reserved_at' => $previous?->reserved_at,
                'sort_order'  => $order++,
            ]);
        }
    }

    private function syncPhotos(Invitation $invitation, array $photos, Request $request): void
    {
        $existing = $invitation->photos()->get();
        $kept = [];

        $order = 0;
        foreach ($photos as $index => $photo) {
            $url = $photo['image_url'] ?? null;

            $file = $request->file("photos.{$index}.image_file");
            if ($file && $file->isValid()) {
                $url = '/storage/' . $file->store("invitations/{$invitation->slug}/gallery", 'public');
            }

            if (blank($url)) {
                continue;
            }

            $kept[] = $url;
            $invitation->photos()->updateOrCreate(
                ['image_url' => $url],
                ['caption' => $photo['caption'] ?? null, 'sort_order' => $order++]
            );
        }

        // Drop rows the owner removed, and their files.
        foreach ($existing as $photo) {
            if (! in_array($photo->image_url, $kept, true)) {
                $this->deleteUploadedImage($photo->image_url);
                $photo->delete();
            }
        }
    }
}
