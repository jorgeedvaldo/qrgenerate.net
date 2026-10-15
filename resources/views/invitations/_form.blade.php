{{-- Shared create/edit form.
     Expects: $isPt, $t (labels), $invitation (null on create), $type (create only). --}}
@php
    $inv = $invitation ?? null;

    // Current value for a field: old input wins, then the stored model, then a default.
    $val = function (string $key, $default = null) use ($inv) {
        $stored = $default;
        if ($inv) {
            $raw = $inv->{$key};
            $stored = $raw instanceof \Illuminate\Support\Carbon ? $raw->format('Y-m-d') : $raw;
            if ($stored === null) {
                $stored = $default;
            }
        }

        return old($key, $stored);
    };

    $bool = function (string $key, bool $default) use ($inv) {
        if (old() !== []) {
            return (bool) old($key, false);
        }

        return $inv ? (bool) $inv->{$key} : $default;
    };

    $time = function (string $raw = null) {
        return $raw ? substr($raw, 0, 5) : '';
    };

    $currentType = old('type', $inv?->type ?? ($type ?? 'wedding'));

    $events = old('events') ?? ($inv
        ? $inv->events->map(fn ($e) => [
            'kind' => $e->kind, 'title' => $e->title, 'venue_name' => $e->venue_name,
            'address' => $e->address, 'maps_url' => $e->maps_url,
            'event_date' => $e->event_date?->format('Y-m-d'),
            'event_time' => $e->event_time ? substr($e->event_time, 0, 5) : '',
            'notes' => $e->notes,
        ])->all()
        : [['kind' => 'ceremony', 'title' => $isPt ? 'Cerimónia' : 'Ceremony']]);

    $schedule = old('schedule') ?? ($inv
        ? $inv->scheduleItems->map(fn ($r) => [
            'time' => $r->time ? substr($r->time, 0, 5) : '',
            'title' => $r->title, 'description' => $r->description,
        ])->all()
        : [
            ['time' => '18:00', 'title' => $isPt ? 'Receção dos convidados' : 'Welcoming the guests'],
            ['time' => '20:00', 'title' => $isPt ? 'Jantar' : 'Dinner'],
        ]);

    $tips = old('tips') ?? ($inv ? ($inv->guest_tips ?: []) : [
        ['icon' => 'users', 'text' => $isPt ? 'A vossa presença é essencial' : 'Your presence means everything'],
        ['icon' => 'clock', 'text' => $isPt ? 'Por favor, sejam pontuais' : 'Please be on time'],
        ['icon' => 'dress', 'text' => $isPt ? 'Traje elegante' : 'Smart dress'],
        ['icon' => 'camera', 'text' => $isPt ? 'Registem o nosso dia' : 'Capture our day'],
    ]);

    $rides = old('rides') ?? ($inv ? ($inv->ride_links ?: []) : []);

    $gifts = old('gifts') ?? ($inv
        ? $inv->gifts->map(fn ($g) => [
            'name' => $g->name, 'description' => $g->description, 'price' => $g->price,
            'image_url' => $g->image_url, 'store_url' => $g->store_url,
        ])->all()
        : []);

    $photos = old('photos') ?? ($inv
        ? $inv->photos->map(fn ($p) => ['image_url' => $p->image_url, 'caption' => $p->caption])->all()
        : []);
@endphp

@if($errors->any())
    <div class="alert alert-danger" style="border-radius:10px;">
        <strong>{{ $t['errors'] }}</strong>
        <ul style="margin:8px 0 0;padding-left:20px;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

{{-- ── 1. The celebration ──────────────────────────────────────────── --}}
<div class="panel-box">
    <span class="step-badge">{{ $t['step'] }} 1</span>
    <h2>{{ $t['s1'] }}</h2>
    <p class="panel-hint">{{ $t['s1_hint'] }}</p>

    <div class="form-group">
        <label>{{ $t['type'] }}</label>
        <div class="grid-2">
            @foreach(['wedding' => $t['wedding'], 'engagement' => $t['engage']] as $key => $label)
                <label class="switch-row" style="border:1.5px solid {{ $currentType === $key ? '#7b4397' : '#e5e7eb' }};border-radius:10px;padding:12px 14px;cursor:pointer;margin:0;">
                    <span class="switch-label" style="font-weight:600;">
                        {{ $key === 'wedding' ? '💍' : '💐' }} {{ $label }}
                    </span>
                    <input type="radio" name="type" value="{{ $key }}" @checked($currentType === $key)
                           style="width:auto;flex:0 0 auto;">
                </label>
            @endforeach
        </div>
    </div>

    <div class="grid-2">
        <div class="form-group">
            <label>{{ $t['name1'] }} *</label>
            <input type="text" name="partner_one_name" class="form-control" required maxlength="80"
                   placeholder="{{ $t['name1_ph'] }}" value="{{ $val('partner_one_name') }}">
        </div>
        <div class="form-group">
            <label>{{ $t['name2'] }}</label>
            <input type="text" name="partner_two_name" class="form-control" maxlength="80"
                   placeholder="{{ $t['name2_ph'] }}" value="{{ $val('partner_two_name') }}">
        </div>
    </div>

    <div class="grid-2">
        <div class="form-group">
            <label>{{ $t['parents1'] }}</label>
            <input type="text" name="partner_one_parents" class="form-control" maxlength="160"
                   placeholder="{{ $t['parents_ph'] }}" value="{{ $val('partner_one_parents') }}">
        </div>
        <div class="form-group">
            <label>{{ $t['parents2'] }}</label>
            <input type="text" name="partner_two_parents" class="form-control" maxlength="160"
                   placeholder="{{ $t['parents_ph'] }}" value="{{ $val('partner_two_parents') }}">
        </div>
    </div>
    <span class="help-small" style="margin:-8px 0 14px;display:block;">{{ $t['parents_hint'] }}</span>

    <div class="grid-2">
        <div class="form-group">
            <label>{{ $t['date'] }} *</label>
            <input type="date" name="event_date" class="form-control" required
                   value="{{ $val('event_date') }}">
        </div>
        <div class="form-group">
            <label>{{ $t['time'] }}</label>
            <input type="time" name="event_time" class="form-control"
                   value="{{ old('event_time', $time($inv?->event_time)) }}">
        </div>
    </div>

    <div class="form-group">
        <label>{{ $t['tagline'] }}</label>
        <input type="text" name="tagline" class="form-control" maxlength="160"
               placeholder="{{ $t['tagline_ph'] }}" value="{{ $val('tagline') }}">
    </div>

    <div class="form-group">
        <label>{{ $t['monogram'] }}</label>
        <input type="text" name="monogram" class="form-control" maxlength="12"
               placeholder="{{ $t['monogram_ph'] }}" value="{{ $val('monogram') }}">
        <span class="help-small">{{ $t['monogram_hint'] }}</span>
    </div>

    <div class="form-group">
        <label>{{ $t['display_title'] }}</label>
        <input type="text" name="display_title" class="form-control" maxlength="120"
               placeholder="{{ $t['display_title_ph'] }}" value="{{ $val('display_title') }}">
        <span class="help-small">{{ $t['display_title_hint'] }}</span>
    </div>
</div>

{{-- ── 2. Look and feel ────────────────────────────────────────────── --}}
<div class="panel-box">
    <span class="step-badge">{{ $t['step'] }} 2</span>
    <h2>{{ $t['s2'] }}</h2>
    <p class="panel-hint">{{ $t['s2_hint'] }}</p>

    <div class="grid-2">
        <div class="form-group" style="grid-column:1/-1;">
            <label>{{ $t['template'] }}</label>
            <div class="tpl-grid">
                @foreach(config('invitation_templates') as $key => $tpl)
                    <label class="tpl-card {{ $val('template', 'lilas') === $key ? 'on' : '' }}"
                           data-primary="{{ $tpl['primary'] }}" data-accent="{{ $tpl['accent'] }}"
                           data-font="{{ $tpl['font'] }}">
                        <input type="radio" name="template" value="{{ $key }}" @checked($val('template', 'lilas') === $key)>
                        <span class="tpl-swatch" style="background:linear-gradient(145deg,{{ $tpl['primary'] }},{{ $tpl['accent'] }});
                              box-shadow:inset 0 -14px 0 {{ $tpl['paper'] }};"></span>
                        <span class="tpl-name">{{ $tpl['label'][$isPt ? 'pt' : 'en'] }}</span>
                    </label>
                @endforeach
            </div>
            <span class="help-small">{{ $t['template_hint'] }}</span>
        </div>
        <div class="form-group">
            <label>{{ $t['font'] }}</label>
            <select name="font" id="font" class="form-control">
                @foreach($t['fonts'] as $key => $label)
                    <option value="{{ $key }}" @selected($val('font', 'cormorant') === $key)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group">
        <label>{{ $t['colors'] }}</label>
        <div class="swatch-row">
            <div>
                <label style="font-size:11.5px;color:#6b7280;">{{ $t['color1'] }}</label>
                <input type="color" id="primary_color" name="primary_color" value="{{ $val('primary_color', '#b08968') }}">
            </div>
            <div>
                <label style="font-size:11.5px;color:#6b7280;">{{ $t['color2'] }}</label>
                <input type="color" id="accent_color" name="accent_color" value="{{ $val('accent_color', '#7f5539') }}">
            </div>
            <div class="theme-preview" id="themePreview"></div>
        </div>
    </div>

    <div class="grid-2">
        <div class="form-group">
            <label>{{ $t['cover'] }}</label>
            <input type="file" name="cover_file" class="form-control" accept="image/jpeg,image/png,image/webp">
            <input type="url" name="cover_url" class="form-control" style="margin-top:8px;" maxlength="500"
                   placeholder="{{ $t['or_url'] }}" value="{{ $val('cover_url') }}">
            <span class="help-small">{{ $t['cover_hint'] }}</span>
        </div>
        <div class="form-group">
            <label>{{ $t['photo'] }}</label>
            <input type="file" name="couple_photo_file" class="form-control" accept="image/jpeg,image/png,image/webp">
            <input type="url" name="couple_photo_url" class="form-control" style="margin-top:8px;" maxlength="500"
                   placeholder="{{ $t['or_url'] }}" value="{{ $val('couple_photo_url') }}">
            <span class="help-small">{{ $t['photo_hint'] }}</span>
        </div>
    </div>

    <div style="margin-top:6px;">
        <div class="switch-row">
            <span class="switch-label">{{ $t['envelope_on'] }}<span class="switch-hint">{{ $t['envelope_on_hint'] }}</span></span>
            <label class="toggle">
                <input type="checkbox" name="envelope_enabled" value="1" @checked($bool('envelope_enabled', true))>
                <span class="toggle-slider"></span>
            </label>
        </div>
        <div class="switch-row">
            <span class="switch-label">{{ $t['petals_on'] }}<span class="switch-hint">{{ $t['petals_on_hint'] }}</span></span>
            <label class="toggle">
                <input type="checkbox" name="petals_enabled" value="1" @checked($bool('petals_enabled', true))>
                <span class="toggle-slider"></span>
            </label>
        </div>
        <div class="switch-row">
            <span class="switch-label">{{ $t['mascot_on'] }}<span class="switch-hint">{{ $t['mascot_on_hint'] }}</span></span>
            <label class="toggle">
                <input type="checkbox" name="mascot_enabled" value="1" @checked($bool('mascot_enabled', true))>
                <span class="toggle-slider"></span>
            </label>
        </div>
    </div>
</div>

{{-- ── 3. Words ────────────────────────────────────────────────────── --}}
<div class="panel-box">
    <span class="step-badge">{{ $t['step'] }} 3</span>
    <h2>{{ $t['s3'] }}</h2>
    <p class="panel-hint">{{ $t['s3_hint'] }}</p>

    <div class="form-group">
        <label>{{ $t['welcome'] }}</label>
        <textarea name="welcome_message" class="form-control" rows="2" maxlength="1000"
                  placeholder="{{ $t['welcome_ph'] }}">{{ $val('welcome_message') }}</textarea>
        <span class="help-small">{{ $t['welcome_hint'] }}</span>
    </div>

    <div class="form-group">
        <label>{{ $t['story'] }}</label>
        <textarea name="story" class="form-control" rows="5" maxlength="3000"
                  placeholder="{{ $t['story_ph'] }}">{{ $val('story') }}</textarea>
    </div>
</div>

{{-- ── 4. Where and when ───────────────────────────────────────────── --}}
<div class="panel-box">
    <span class="step-badge">{{ $t['step'] }} 4</span>
    <h2>{{ $t['s4'] }}</h2>
    <p class="panel-hint">{{ $t['s4_hint'] }}</p>

    <div id="eventsList">
        @foreach($events as $i => $event)
            <div class="repeater-item" data-repeater="events">
                <button type="button" class="remove-btn" onclick="removeItem(this)">{{ $t['remove'] }}</button>
                <div class="grid-2">
                    <div class="form-group">
                        <label>{{ $t['ev_kind'] }}</label>
                        <select name="events[{{ $i }}][kind]" class="form-control">
                            @foreach($t['kinds'] as $key => $label)
                                <option value="{{ $key }}" @selected(($event['kind'] ?? 'ceremony') === $key)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>{{ $t['ev_title'] }}</label>
                        <input type="text" name="events[{{ $i }}][title]" class="form-control" maxlength="120"
                               placeholder="{{ $t['ev_title_ph'] }}" value="{{ $event['title'] ?? '' }}">
                    </div>
                </div>
                <div class="form-group">
                    <label>{{ $t['ev_venue'] }}</label>
                    <input type="text" name="events[{{ $i }}][venue_name]" class="form-control" maxlength="160"
                           placeholder="{{ $t['ev_venue_ph'] }}" value="{{ $event['venue_name'] ?? '' }}">
                </div>
                <div class="form-group">
                    <label>{{ $t['ev_address'] }}</label>
                    <input type="text" name="events[{{ $i }}][address]" class="form-control" maxlength="250"
                           placeholder="{{ $t['ev_address_ph'] }}" value="{{ $event['address'] ?? '' }}">
                    <span class="help-small">{{ $t['ev_address_hint'] }}</span>
                </div>
                <div class="form-group">
                    <label>{{ $t['ev_maps'] }}</label>
                    <input type="url" name="events[{{ $i }}][maps_url]" class="form-control" maxlength="500"
                           placeholder="https://maps.google.com/..." value="{{ $event['maps_url'] ?? '' }}">
                </div>
                <div class="grid-2">
                    <div class="form-group">
                        <label>{{ $t['ev_date'] }}</label>
                        <input type="date" name="events[{{ $i }}][event_date]" class="form-control"
                               value="{{ $event['event_date'] ?? '' }}">
                    </div>
                    <div class="form-group">
                        <label>{{ $t['ev_time'] }}</label>
                        <input type="time" name="events[{{ $i }}][event_time]" class="form-control"
                               value="{{ $event['event_time'] ?? '' }}">
                    </div>
                </div>
                <div class="form-group">
                    <label>{{ $t['ev_notes'] }}</label>
                    <input type="text" name="events[{{ $i }}][notes]" class="form-control" maxlength="500"
                           placeholder="{{ $t['ev_notes_ph'] }}" value="{{ $event['notes'] ?? '' }}">
                </div>
            </div>
        @endforeach
    </div>
    <button type="button" class="btn-add" onclick="addEvent()">+ {{ $t['add_event'] }}</button>
</div>

{{-- ── Programme of the evening ────────────────────────────────────── --}}
<div class="panel-box">
    <span class="step-badge">{{ $t['step'] }} 5</span>
    <h2>{{ $t['s4b'] }}</h2>
    <p class="panel-hint">{{ $t['s4b_hint'] }}</p>

    <div id="scheduleList">
        @foreach($schedule as $i => $row)
            <div class="repeater-item" data-repeater="schedule">
                <button type="button" class="remove-btn" onclick="removeItem(this)">{{ $t['remove'] }}</button>
                <div class="grid-2">
                    <div class="form-group">
                        <label>{{ $t['sched_time'] }}</label>
                        <input type="time" name="schedule[{{ $i }}][time]" class="form-control" value="{{ $row['time'] ?? '' }}">
                    </div>
                    <div class="form-group">
                        <label>{{ $t['sched_title'] }}</label>
                        <input type="text" name="schedule[{{ $i }}][title]" class="form-control" maxlength="120"
                               placeholder="{{ $t['sched_title_ph'] }}" value="{{ $row['title'] ?? '' }}">
                    </div>
                </div>
                <div class="form-group">
                    <label>{{ $t['sched_desc'] }}</label>
                    <input type="text" name="schedule[{{ $i }}][description]" class="form-control" maxlength="250"
                           placeholder="{{ $t['sched_desc_ph'] }}" value="{{ $row['description'] ?? '' }}">
                </div>
            </div>
        @endforeach
    </div>
    <button type="button" class="btn-add" onclick="addSchedule()">+ {{ $t['add_sched'] }}</button>
</div>

{{-- ── 5. Dress code, hashtag, music ───────────────────────────────── --}}
<div class="panel-box">
    <span class="step-badge">{{ $t['step'] }} 6</span>
    <h2>{{ $t['s5'] }}</h2>
    <p class="panel-hint">{{ $t['s5_hint'] }}</p>

    <div class="grid-2">
        <div class="form-group">
            <label>{{ $t['dress'] }}</label>
            <input type="text" name="dress_code" class="form-control" maxlength="120"
                   placeholder="{{ $t['dress_ph'] }}" value="{{ $val('dress_code') }}">
        </div>
        <div class="form-group">
            <label>{{ $t['hashtag'] }}</label>
            <input type="text" name="hashtag" class="form-control" maxlength="80"
                   placeholder="{{ $t['hashtag_ph'] }}" value="{{ $val('hashtag') }}">
        </div>
    </div>
    <div class="form-group">
        <label>{{ $t['dress_colors'] }}</label>
        <div class="swatch-pickers">
            @php $dressColors = old('dress_colors') ?? ($inv?->dress_code_colors ?? []); @endphp
            @for($i = 0; $i < 5; $i++)
                <input type="color" name="dress_colors[{{ $i }}]" value="{{ $dressColors[$i] ?? '#000000' }}">
            @endfor
        </div>
        <span class="help-small">{{ $t['dress_colors_hint'] }}</span>
    </div>

    <div class="form-group">
        <label>{{ $t['dress_notes'] }}</label>
        <textarea name="dress_code_notes" class="form-control" rows="2" maxlength="600"
                  placeholder="{{ $t['dress_notes_ph'] }}">{{ $val('dress_code_notes') }}</textarea>
    </div>
    <div class="form-group">
        <label>{{ $t['music'] }}</label>
        <input type="url" name="music_url" class="form-control" maxlength="500"
               placeholder="https://.../musica.mp3" value="{{ $val('music_url') }}">
        <span class="help-small">{{ $t['music_hint'] }}</span>
    </div>

    <h2 style="margin-top:22px;">{{ $t['tips'] }}</h2>
    <p class="panel-hint">{{ $t['tips_hint'] }}</p>
    <div id="tipsList">
        @foreach($tips as $i => $tip)
            <div class="repeater-item" data-repeater="tips">
                <button type="button" class="remove-btn" onclick="removeItem(this)">{{ $t['remove'] }}</button>
                <div class="grid-2">
                    <div class="form-group">
                        <label>{{ $t['tip_icon'] }}</label>
                        <select name="tips[{{ $i }}][icon]" class="form-control">
                            @foreach($t['tip_icons'] as $key => $label)
                                <option value="{{ $key }}" @selected(($tip['icon'] ?? 'sparkle') === $key)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>{{ $t['tip_text'] }}</label>
                        <input type="text" name="tips[{{ $i }}][text]" class="form-control" maxlength="120"
                               placeholder="{{ $t['tip_text_ph'] }}" value="{{ $tip['text'] ?? '' }}">
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <button type="button" class="btn-add" onclick="addTip()">+ {{ $t['add_tip'] }}</button>

    <h2 style="margin-top:22px;">{{ $t['rides'] }}</h2>
    <p class="panel-hint">{{ $t['rides_hint'] }}</p>
    <div id="ridesList">
        @foreach($rides as $i => $ride)
            <div class="repeater-item" data-repeater="rides">
                <button type="button" class="remove-btn" onclick="removeItem(this)">{{ $t['remove'] }}</button>
                <div class="grid-2">
                    <div class="form-group">
                        <label>{{ $t['ride_label'] }}</label>
                        <input type="text" name="rides[{{ $i }}][label]" class="form-control" maxlength="40"
                               placeholder="{{ $t['ride_label_ph'] }}" value="{{ $ride['label'] ?? '' }}">
                    </div>
                    <div class="form-group">
                        <label>{{ $t['ride_url'] }}</label>
                        <input type="url" name="rides[{{ $i }}][url]" class="form-control" maxlength="500"
                               placeholder="https://..." value="{{ $ride['url'] ?? '' }}">
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <button type="button" class="btn-add" onclick="addRide()">+ {{ $t['add_ride'] }}</button>
</div>

{{-- ── 6. Gallery ──────────────────────────────────────────────────── --}}
<div class="panel-box">
    <span class="step-badge">{{ $t['step'] }} 7</span>
    <h2>{{ $t['s6'] }}</h2>
    <p class="panel-hint">{{ $t['s6_hint'] }}</p>

    <div id="photosList">
        @foreach($photos as $i => $photo)
            <div class="repeater-item" data-repeater="photos">
                <button type="button" class="remove-btn" onclick="removeItem(this)">{{ $t['remove'] }}</button>
                <div class="form-group">
                    <label>{{ $t['ph_file'] }}</label>
                    <input type="file" name="photos[{{ $i }}][image_file]" class="form-control" accept="image/jpeg,image/png,image/webp">
                    <input type="url" name="photos[{{ $i }}][image_url]" class="form-control" style="margin-top:8px;"
                           maxlength="500" placeholder="{{ $t['or_url'] }}" value="{{ $photo['image_url'] ?? '' }}">
                </div>
                <div class="form-group">
                    <label>{{ $t['ph_caption'] }}</label>
                    <input type="text" name="photos[{{ $i }}][caption]" class="form-control" maxlength="160"
                           value="{{ $photo['caption'] ?? '' }}">
                </div>
            </div>
        @endforeach
    </div>
    <button type="button" class="btn-add" onclick="addPhoto()">+ {{ $t['add_photo'] }}</button>
</div>

{{-- ── 7. Gifts ────────────────────────────────────────────────────── --}}
<div class="panel-box">
    <span class="step-badge">{{ $t['step'] }} 8</span>
    <h2>{{ $t['s7'] }}</h2>
    <p class="panel-hint">{{ $t['s7_hint'] }}</p>

    <div class="form-group">
        <label>{{ $t['gift_msg'] }}</label>
        <textarea name="gift_message" class="form-control" rows="2" maxlength="1000"
                  placeholder="{{ $t['gift_msg_ph'] }}">{{ $val('gift_message') }}</textarea>
    </div>

    <div class="grid-2">
        <div class="form-group">
            <label>{{ $t['pix'] }}</label>
            <input type="text" name="pix_key" class="form-control" maxlength="200"
                   placeholder="{{ $t['pix_ph'] }}" value="{{ $val('pix_key') }}">
        </div>
        <div class="form-group">
            <label>{{ $t['pix_name'] }}</label>
            <input type="text" name="pix_name" class="form-control" maxlength="120" value="{{ $val('pix_name') }}">
        </div>
    </div>

    <div class="form-group">
        <label>{{ $t['bank'] }}</label>
        <textarea name="bank_details" class="form-control" rows="3" maxlength="600"
                  placeholder="{{ $t['bank_ph'] }}">{{ $val('bank_details') }}</textarea>
    </div>

    <div id="giftsList">
        @foreach($gifts as $i => $gift)
            <div class="repeater-item" data-repeater="gifts">
                <button type="button" class="remove-btn" onclick="removeItem(this)">{{ $t['remove'] }}</button>
                <div class="grid-2">
                    <div class="form-group">
                        <label>{{ $t['gi_name'] }}</label>
                        <input type="text" name="gifts[{{ $i }}][name]" class="form-control" maxlength="150"
                               placeholder="{{ $t['gi_name_ph'] }}" value="{{ $gift['name'] ?? '' }}">
                    </div>
                    <div class="form-group">
                        <label>{{ $t['gi_price'] }}</label>
                        <input type="number" name="gifts[{{ $i }}][price]" class="form-control" step="0.01" min="0"
                               placeholder="0.00" value="{{ $gift['price'] ?? '' }}">
                    </div>
                </div>
                <div class="form-group">
                    <label>{{ $t['gi_desc'] }}</label>
                    <input type="text" name="gifts[{{ $i }}][description]" class="form-control" maxlength="400"
                           value="{{ $gift['description'] ?? '' }}">
                </div>
                <div class="grid-2">
                    <div class="form-group">
                        <label>{{ $t['gi_image'] }}</label>
                        <input type="url" name="gifts[{{ $i }}][image_url]" class="form-control" maxlength="500"
                               placeholder="https://..." value="{{ $gift['image_url'] ?? '' }}">
                    </div>
                    <div class="form-group">
                        <label>{{ $t['gi_store'] }}</label>
                        <input type="url" name="gifts[{{ $i }}][store_url]" class="form-control" maxlength="500"
                               placeholder="https://..." value="{{ $gift['store_url'] ?? '' }}">
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <button type="button" class="btn-add" onclick="addGift()">+ {{ $t['add_gift'] }}</button>
</div>

{{-- ── 8. RSVP and contact ─────────────────────────────────────────── --}}
<div class="panel-box">
    <span class="step-badge">{{ $t['step'] }} 9</span>
    <h2>{{ $t['s8'] }}</h2>
    <p class="panel-hint">{{ $t['s8_hint'] }}</p>

    <div class="switch-row">
        <span class="switch-label">{{ $t['rsvp_on'] }}<span class="switch-hint">{{ $t['rsvp_on_hint'] }}</span></span>
        <label class="toggle">
            <input type="checkbox" name="rsvp_enabled" value="1" @checked($bool('rsvp_enabled', true))>
            <span class="toggle-slider"></span>
        </label>
    </div>
    <div class="form-group" style="margin-bottom:16px;">
        <label>{{ $t['rsvp_mode'] }}</label>
        <select name="rsvp_mode" class="form-control">
            @foreach($t['rsvp_modes'] as $key => $label)
                <option value="{{ $key }}" @selected($val('rsvp_mode', 'site') === $key)>{{ $label }}</option>
            @endforeach
        </select>
        <span class="help-small">{{ $t['rsvp_mode_hint'] }}</span>
    </div>

    <div class="switch-row">
        <span class="switch-label">{{ $t['song_on'] }}<span class="switch-hint">{{ $t['song_on_hint'] }}</span></span>
        <label class="toggle">
            <input type="checkbox" name="song_request_enabled" value="1" @checked($bool('song_request_enabled', true))>
            <span class="toggle-slider"></span>
        </label>
    </div>
    <div class="switch-row">
        <span class="switch-label">{{ $t['comp_on'] }}<span class="switch-hint">{{ $t['comp_on_hint'] }}</span></span>
        <label class="toggle">
            <input type="checkbox" name="allow_companions" value="1" @checked($bool('allow_companions', true))>
            <span class="toggle-slider"></span>
        </label>
    </div>
    <div class="switch-row">
        <span class="switch-label">{{ $t['gb_on'] }}<span class="switch-hint">{{ $t['gb_on_hint'] }}</span></span>
        <label class="toggle">
            <input type="checkbox" name="guestbook_enabled" value="1" @checked($bool('guestbook_enabled', true))>
            <span class="toggle-slider"></span>
        </label>
    </div>
    <div class="switch-row">
        <span class="switch-label">{{ $t['cd_on'] }}<span class="switch-hint">{{ $t['cd_on_hint'] }}</span></span>
        <label class="toggle">
            <input type="checkbox" name="countdown_enabled" value="1" @checked($bool('countdown_enabled', true))>
            <span class="toggle-slider"></span>
        </label>
    </div>

    <div class="grid-2" style="margin-top:16px;">
        <div class="form-group">
            <label>{{ $t['deadline'] }}</label>
            <input type="date" name="rsvp_deadline" class="form-control" value="{{ $val('rsvp_deadline') }}">
        </div>
        <div class="form-group">
            <label>{{ $t['max_comp'] }}</label>
            <input type="number" name="max_companions" class="form-control" min="0" max="20"
                   value="{{ $val('max_companions', 2) }}">
        </div>
    </div>

    <div class="grid-3">
        <div class="form-group">
            <label>{{ $t['wa'] }}</label>
            <input type="text" name="contact_whatsapp" class="form-control" maxlength="30"
                   placeholder="244923000000" value="{{ $val('contact_whatsapp') }}">
        </div>
        <div class="form-group">
            <label>{{ $t['phone'] }}</label>
            <input type="text" name="contact_phone" class="form-control" maxlength="30" value="{{ $val('contact_phone') }}">
        </div>
        <div class="form-group">
            <label>{{ $t['email'] }}</label>
            <input type="email" name="contact_email" class="form-control" maxlength="200" value="{{ $val('contact_email') }}">
        </div>
    </div>
</div>

{{-- ── Repeater templates + small helpers ──────────────────────────── --}}
<template id="tpl-events">
    <div class="repeater-item" data-repeater="events">
        <button type="button" class="remove-btn" onclick="removeItem(this)">{{ $t['remove'] }}</button>
        <div class="grid-2">
            <div class="form-group">
                <label>{{ $t['ev_kind'] }}</label>
                <select name="events[__I__][kind]" class="form-control">
                    @foreach($t['kinds'] as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>{{ $t['ev_title'] }}</label>
                <input type="text" name="events[__I__][title]" class="form-control" maxlength="120" placeholder="{{ $t['ev_title_ph'] }}">
            </div>
        </div>
        <div class="form-group">
            <label>{{ $t['ev_venue'] }}</label>
            <input type="text" name="events[__I__][venue_name]" class="form-control" maxlength="160" placeholder="{{ $t['ev_venue_ph'] }}">
        </div>
        <div class="form-group">
            <label>{{ $t['ev_address'] }}</label>
            <input type="text" name="events[__I__][address]" class="form-control" maxlength="250" placeholder="{{ $t['ev_address_ph'] }}">
        </div>
        <div class="form-group">
            <label>{{ $t['ev_maps'] }}</label>
            <input type="url" name="events[__I__][maps_url]" class="form-control" maxlength="500" placeholder="https://maps.google.com/...">
        </div>
        <div class="grid-2">
            <div class="form-group">
                <label>{{ $t['ev_date'] }}</label>
                <input type="date" name="events[__I__][event_date]" class="form-control">
            </div>
            <div class="form-group">
                <label>{{ $t['ev_time'] }}</label>
                <input type="time" name="events[__I__][event_time]" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label>{{ $t['ev_notes'] }}</label>
            <input type="text" name="events[__I__][notes]" class="form-control" maxlength="500" placeholder="{{ $t['ev_notes_ph'] }}">
        </div>
    </div>
</template>

<template id="tpl-photos">
    <div class="repeater-item" data-repeater="photos">
        <button type="button" class="remove-btn" onclick="removeItem(this)">{{ $t['remove'] }}</button>
        <div class="form-group">
            <label>{{ $t['ph_file'] }}</label>
            <input type="file" name="photos[__I__][image_file]" class="form-control" accept="image/jpeg,image/png,image/webp">
            <input type="url" name="photos[__I__][image_url]" class="form-control" style="margin-top:8px;" maxlength="500" placeholder="{{ $t['or_url'] }}">
        </div>
        <div class="form-group">
            <label>{{ $t['ph_caption'] }}</label>
            <input type="text" name="photos[__I__][caption]" class="form-control" maxlength="160">
        </div>
    </div>
</template>

<template id="tpl-gifts">
    <div class="repeater-item" data-repeater="gifts">
        <button type="button" class="remove-btn" onclick="removeItem(this)">{{ $t['remove'] }}</button>
        <div class="grid-2">
            <div class="form-group">
                <label>{{ $t['gi_name'] }}</label>
                <input type="text" name="gifts[__I__][name]" class="form-control" maxlength="150" placeholder="{{ $t['gi_name_ph'] }}">
            </div>
            <div class="form-group">
                <label>{{ $t['gi_price'] }}</label>
                <input type="number" name="gifts[__I__][price]" class="form-control" step="0.01" min="0" placeholder="0.00">
            </div>
        </div>
        <div class="form-group">
            <label>{{ $t['gi_desc'] }}</label>
            <input type="text" name="gifts[__I__][description]" class="form-control" maxlength="400">
        </div>
        <div class="grid-2">
            <div class="form-group">
                <label>{{ $t['gi_image'] }}</label>
                <input type="url" name="gifts[__I__][image_url]" class="form-control" maxlength="500" placeholder="https://...">
            </div>
            <div class="form-group">
                <label>{{ $t['gi_store'] }}</label>
                <input type="url" name="gifts[__I__][store_url]" class="form-control" maxlength="500" placeholder="https://...">
            </div>
        </div>
    </div>
</template>

<template id="tpl-schedule">
    <div class="repeater-item" data-repeater="schedule">
        <button type="button" class="remove-btn" onclick="removeItem(this)">{{ $t['remove'] }}</button>
        <div class="grid-2">
            <div class="form-group">
                <label>{{ $t['sched_time'] }}</label>
                <input type="time" name="schedule[__I__][time]" class="form-control">
            </div>
            <div class="form-group">
                <label>{{ $t['sched_title'] }}</label>
                <input type="text" name="schedule[__I__][title]" class="form-control" maxlength="120" placeholder="{{ $t['sched_title_ph'] }}">
            </div>
        </div>
        <div class="form-group">
            <label>{{ $t['sched_desc'] }}</label>
            <input type="text" name="schedule[__I__][description]" class="form-control" maxlength="250" placeholder="{{ $t['sched_desc_ph'] }}">
        </div>
    </div>
</template>

<template id="tpl-tips">
    <div class="repeater-item" data-repeater="tips">
        <button type="button" class="remove-btn" onclick="removeItem(this)">{{ $t['remove'] }}</button>
        <div class="grid-2">
            <div class="form-group">
                <label>{{ $t['tip_icon'] }}</label>
                <select name="tips[__I__][icon]" class="form-control">
                    @foreach($t['tip_icons'] as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>{{ $t['tip_text'] }}</label>
                <input type="text" name="tips[__I__][text]" class="form-control" maxlength="120" placeholder="{{ $t['tip_text_ph'] }}">
            </div>
        </div>
    </div>
</template>

<template id="tpl-rides">
    <div class="repeater-item" data-repeater="rides">
        <button type="button" class="remove-btn" onclick="removeItem(this)">{{ $t['remove'] }}</button>
        <div class="grid-2">
            <div class="form-group">
                <label>{{ $t['ride_label'] }}</label>
                <input type="text" name="rides[__I__][label]" class="form-control" maxlength="40" placeholder="{{ $t['ride_label_ph'] }}">
            </div>
            <div class="form-group">
                <label>{{ $t['ride_url'] }}</label>
                <input type="url" name="rides[__I__][url]" class="form-control" maxlength="500" placeholder="https://...">
            </div>
        </div>
    </div>
</template>

{{-- Repeater + theme preview behaviour --}}
@push('scripts')
<script>
var counters = {
    events:   {{ count($events ?? []) }},
    schedule: {{ count($schedule ?? []) }},
    tips:     {{ count($tips ?? []) }},
    rides:    {{ count($rides ?? []) }},
    gifts:    {{ count($gifts ?? []) }},
    photos:   {{ count($photos ?? []) }}
};

function addFrom(name, listId) {
    var tpl = document.getElementById('tpl-' + name);
    var html = tpl.innerHTML.replace(/__I__/g, counters[name]);
    var holder = document.createElement('div');
    holder.innerHTML = html.trim();
    document.getElementById(listId).appendChild(holder.firstElementChild);
    counters[name]++;
}

function addEvent()    { addFrom('events', 'eventsList'); }
function addSchedule() { addFrom('schedule', 'scheduleList'); }
function addTip()      { addFrom('tips', 'tipsList'); }
function addRide()     { addFrom('rides', 'ridesList'); }
function addGift()  { addFrom('gifts', 'giftsList'); }
function addPhoto() { addFrom('photos', 'photosList'); }

// Indexes are never reused, so gaps are fine: Laravel re-keys the array.
function removeItem(button) {
    button.closest('.repeater-item').remove();
}

// Choosing a template highlights it and loads its suggested colours and typeface.
(function () {
    var cards = document.querySelectorAll('.tpl-card');
    if (!cards.length) return;

    cards.forEach(function (card) {
        card.addEventListener('click', function () {
            cards.forEach(function (c) { c.classList.remove('on'); });
            card.classList.add('on');

            var primary = document.getElementById('primary_color');
            var accent = document.getElementById('accent_color');
            if (primary && accent) {
                primary.value = card.dataset.primary;
                accent.value = card.dataset.accent;
                primary.dispatchEvent(new Event('input'));
            }

            var font = document.getElementById('font');
            if (font && card.dataset.font) font.value = card.dataset.font;
        });
    });
})();

// Live swatch of the two chosen colours.
(function () {
    var primary = document.getElementById('primary_color');
    var accent = document.getElementById('accent_color');
    var preview = document.getElementById('themePreview');
    if (!primary || !accent || !preview) return;

    function paint() {
        preview.style.background = 'linear-gradient(135deg, ' + primary.value + ', ' + accent.value + ')';
    }

    primary.addEventListener('input', paint);
    accent.addEventListener('input', paint);
    paint();
})();

// Highlight the selected celebration type.
document.querySelectorAll('input[name="type"]').forEach(function (radio) {
    radio.addEventListener('change', function () {
        document.querySelectorAll('input[name="type"]').forEach(function (other) {
            other.closest('label').style.borderColor = other.checked ? '#7b4397' : '#e5e7eb';
        });
    });
});
</script>
@endpush
