<?php

namespace App\Http\Requests;

use App\Models\Invitation;
use App\Models\InvitationEvent;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InvitationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'type'              => ['required', Rule::in(Invitation::TYPES)],
            'template'          => ['nullable', Rule::in(Invitation::templates())],
            'font'              => ['nullable', Rule::in(Invitation::FONTS)],

            'partner_one_name'  => ['required', 'string', 'max:80'],
            'partner_two_name'  => ['nullable', 'string', 'max:80'],
            'partner_one_parents' => ['nullable', 'string', 'max:160'],
            'partner_two_parents' => ['nullable', 'string', 'max:160'],
            'display_title'     => ['nullable', 'string', 'max:120'],
            'tagline'           => ['nullable', 'string', 'max:160'],
            'story'             => ['nullable', 'string', 'max:3000'],
            'welcome_message'   => ['nullable', 'string', 'max:1000'],

            'event_date'        => ['required', 'date'],
            'event_time'        => ['nullable', 'date_format:H:i'],

            'cover_file'        => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:4096'],
            'cover_url'         => ['nullable', 'url', 'max:500'],
            'couple_photo_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:4096'],
            'couple_photo_url'  => ['nullable', 'url', 'max:500'],

            'primary_color'     => ['nullable', 'string', 'regex:/^#[0-9a-fA-F]{6}$/'],
            'accent_color'      => ['nullable', 'string', 'regex:/^#[0-9a-fA-F]{6}$/'],

            'dress_code'        => ['nullable', 'string', 'max:120'],
            'dress_code_notes'  => ['nullable', 'string', 'max:600'],
            'dress_colors'      => ['nullable', 'array', 'max:8'],
            'dress_colors.*'    => ['nullable', 'string', 'regex:/^#[0-9a-fA-F]{6}$/'],
            'hashtag'           => ['nullable', 'string', 'max:80'],
            'monogram'          => ['nullable', 'string', 'max:12'],
            'envelope_enabled'  => ['nullable', 'boolean'],
            'petals_enabled'    => ['nullable', 'boolean'],
            'mascot_enabled'    => ['nullable', 'boolean'],
            'music_url'         => ['nullable', 'url', 'max:500'],

            'gift_message'      => ['nullable', 'string', 'max:1000'],
            'pix_key'           => ['nullable', 'string', 'max:200'],
            'pix_name'          => ['nullable', 'string', 'max:120'],
            'bank_details'      => ['nullable', 'string', 'max:600'],

            'rsvp_enabled'      => ['nullable', 'boolean'],
            'rsvp_mode'         => ['nullable', Rule::in(Invitation::RSVP_MODES)],
            'song_request_enabled' => ['nullable', 'boolean'],
            'rsvp_deadline'     => ['nullable', 'date'],
            'allow_companions'  => ['nullable', 'boolean'],
            'max_companions'    => ['nullable', 'integer', 'min:0', 'max:20'],
            'guestbook_enabled' => ['nullable', 'boolean'],
            'countdown_enabled' => ['nullable', 'boolean'],

            'contact_phone'     => ['nullable', 'string', 'max:30'],
            'contact_whatsapp'  => ['nullable', 'string', 'max:30'],
            'contact_email'     => ['nullable', 'email', 'max:200'],

            // "Manual do bom convidado" tips
            'tips'              => ['nullable', 'array', 'max:12'],
            'tips.*.icon'       => ['nullable', Rule::in(Invitation::TIP_ICONS)],
            'tips.*.text'       => ['nullable', 'string', 'max:120'],

            // Ride-hailing deep links
            'rides'             => ['nullable', 'array', 'max:6'],
            'rides.*.label'     => ['nullable', 'string', 'max:40'],
            'rides.*.url'       => ['nullable', 'url', 'max:500'],

            // Programme timeline
            'schedule'              => ['nullable', 'array', 'max:20'],
            'schedule.*.time'       => ['nullable', 'date_format:H:i'],
            'schedule.*.title'      => ['nullable', 'string', 'max:120'],
            'schedule.*.description' => ['nullable', 'string', 'max:250'],

            // Ceremony / reception blocks
            'events'                 => ['nullable', 'array', 'max:6'],
            'events.*.kind'          => ['nullable', Rule::in(InvitationEvent::KINDS)],
            'events.*.title'         => ['required_with:events.*.venue_name,events.*.address', 'nullable', 'string', 'max:120'],
            'events.*.venue_name'    => ['nullable', 'string', 'max:160'],
            'events.*.address'       => ['nullable', 'string', 'max:250'],
            'events.*.maps_url'      => ['nullable', 'url', 'max:500'],
            'events.*.event_date'    => ['nullable', 'date'],
            'events.*.event_time'    => ['nullable', 'date_format:H:i'],
            'events.*.notes'         => ['nullable', 'string', 'max:500'],

            // Gift list
            'gifts'                  => ['nullable', 'array', 'max:60'],
            'gifts.*.name'           => ['nullable', 'string', 'max:150'],
            'gifts.*.description'    => ['nullable', 'string', 'max:400'],
            'gifts.*.price'          => ['nullable', 'numeric', 'min:0', 'max:9999999'],
            'gifts.*.image_url'      => ['nullable', 'url', 'max:500'],
            'gifts.*.store_url'      => ['nullable', 'url', 'max:500'],

            // Photo gallery
            'photos'                 => ['nullable', 'array', 'max:30'],
            'photos.*.image_url'     => ['nullable', 'url', 'max:500'],
            'photos.*.image_file'    => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:4096'],
            'photos.*.caption'       => ['nullable', 'string', 'max:160'],
        ];
    }

    protected function prepareForValidation(): void
    {
        // Browsers send "" for untouched time inputs; treat that as "no time set".
        $blanks = [];
        foreach (['event_time', 'rsvp_deadline', 'event_date'] as $key) {
            if ($this->input($key) === '') {
                $blanks[$key] = null;
            }
        }

        $schedule = $this->input('schedule');
        if (is_array($schedule)) {
            foreach ($schedule as $i => $row) {
                if (($row['time'] ?? null) === '') {
                    $schedule[$i]['time'] = null;
                }
            }
            $blanks['schedule'] = $schedule;
        }

        $events = $this->input('events');
        if (is_array($events)) {
            foreach ($events as $i => $event) {
                foreach (['event_time', 'event_date'] as $key) {
                    if (($event[$key] ?? null) === '') {
                        $events[$i][$key] = null;
                    }
                }
            }
            $blanks['events'] = $events;
        }

        if ($blanks) {
            $this->merge($blanks);
        }
    }

    public function messages(): array
    {
        if ($this->input('form_locale') === 'en') {
            return [
                'partner_one_name.required' => 'Please tell us the first name.',
                'event_date.required'       => 'Please choose the date of the celebration.',
            ];
        }

        return [
            'partner_one_name.required' => 'Indique o primeiro nome.',
            'event_date.required'       => 'Escolha a data da celebração.',
        ];
    }
}
