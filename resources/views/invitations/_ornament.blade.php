{{-- Decorative motif drawn in the page corners. Expects: $ornament (a key from
     config/invitation_templates). Everything is stroked/filled with the theme
     colours, so one drawing serves every palette. --}}
@php $o = $ornament ?? 'none'; @endphp

@if($o !== 'none')
<svg width="0" height="0" style="position:absolute" aria-hidden="true" focusable="false">
    <defs>
        @switch($o)
            @case('wisteria')
                {{-- Hanging lilac clusters --}}
                <symbol id="orn" viewBox="0 0 200 200">
                    <path d="M18 2C34 26 44 56 46 88" stroke="var(--orn-stem)" stroke-width="2" fill="none"/>
                    <path d="M52 6C62 30 64 58 58 84" stroke="var(--orn-stem)" stroke-width="1.6" fill="none"/>
                    @foreach([[22,18,9],[32,34,11],[18,44,8],[30,58,10],[40,76,9],[24,74,7],[58,22,10],[66,40,12],[56,56,9],[70,66,8],[48,96,8],[62,88,7]] as [$cx,$cy,$r])
                        <circle cx="{{ $cx }}" cy="{{ $cy }}" r="{{ $r }}" fill="var(--orn-bloom)" opacity=".85"/>
                        <circle cx="{{ $cx - 2 }}" cy="{{ $cy - 2 }}" r="{{ max(2, $r - 5) }}" fill="var(--orn-bloom-2)"/>
                    @endforeach
                    @foreach([[84,14,30,16],[90,46,34,18],[78,78,28,14]] as [$x,$y,$w,$h])
                        <ellipse cx="{{ $x }}" cy="{{ $y }}" rx="{{ $w }}" ry="{{ $h }}" fill="var(--orn-leaf)" opacity=".55" transform="rotate(32 {{ $x }} {{ $y }})"/>
                    @endforeach
                </symbol>
                @break

            @case('botanical')
                {{-- Ferns, small blooms and a butterfly --}}
                <symbol id="orn" viewBox="0 0 200 200">
                    <path d="M6 10C40 30 66 64 80 108" stroke="var(--orn-stem)" stroke-width="2" fill="none"/>
                    @for($i = 0; $i < 9; $i++)
                        <ellipse cx="{{ 14 + $i * 8 }}" cy="{{ 16 + $i * 11 }}" rx="13" ry="5.5"
                                 fill="var(--orn-leaf)" opacity=".7" transform="rotate({{ -34 + $i * 3 }} {{ 14 + $i * 8 }} {{ 16 + $i * 11 }})"/>
                        <ellipse cx="{{ 26 + $i * 8 }}" cy="{{ 10 + $i * 11 }}" rx="12" ry="5"
                                 fill="var(--orn-leaf-2)" opacity=".6" transform="rotate({{ 30 - $i * 3 }} {{ 26 + $i * 8 }} {{ 10 + $i * 11 }})"/>
                    @endfor
                    @foreach([[72,24,9],[88,52,8],[60,66,7]] as [$cx,$cy,$r])
                        <circle cx="{{ $cx }}" cy="{{ $cy }}" r="{{ $r }}" fill="var(--orn-bloom)" opacity=".9"/>
                        <circle cx="{{ $cx }}" cy="{{ $cy }}" r="{{ $r / 2.6 }}" fill="var(--orn-bloom-2)"/>
                    @endforeach
                    <g transform="translate(104 86) rotate(-18)" opacity=".85">
                        <path d="M0 0C-16-14-26-6-20 6C-15 15-4 10 0 0Z" fill="var(--orn-bloom)"/>
                        <path d="M0 0C16-14 26-6 20 6C15 15 4 10 0 0Z" fill="var(--orn-bloom-2)"/>
                        <path d="M0-3V9" stroke="var(--orn-stem)" stroke-width="1.6"/>
                    </g>
                </symbol>
                @break

            @case('roses')
                {{-- Blush roses with soft foliage --}}
                <symbol id="orn" viewBox="0 0 200 200">
                    <path d="M10 6C32 28 48 58 54 94" stroke="var(--orn-stem)" stroke-width="2" fill="none"/>
                    @foreach([[26,24,17],[58,48,20],[30,70,14],[64,88,12]] as [$cx,$cy,$r])
                        <circle cx="{{ $cx }}" cy="{{ $cy }}" r="{{ $r }}" fill="var(--orn-bloom)"/>
                        <circle cx="{{ $cx }}" cy="{{ $cy }}" r="{{ $r * .66 }}" fill="var(--orn-bloom-2)"/>
                        <circle cx="{{ $cx }}" cy="{{ $cy }}" r="{{ $r * .34 }}" fill="var(--orn-bloom)"/>
                        <path d="M{{ $cx - $r * .3 }} {{ $cy }}a{{ $r * .3 }} {{ $r * .3 }} 0 0 1 {{ $r * .6 }} 0"
                              stroke="var(--orn-stem)" stroke-width="1.4" fill="none" opacity=".5"/>
                    @endforeach
                    @foreach([[80,20,26],[86,62,-18],[46,100,40]] as [$x,$y,$rot])
                        <ellipse cx="{{ $x }}" cy="{{ $y }}" rx="20" ry="9" fill="var(--orn-leaf)" opacity=".6"
                                 transform="rotate({{ $rot }} {{ $x }} {{ $y }})"/>
                    @endforeach
                </symbol>
                @break

            @case('palm')
                {{-- Monstera and palm leaves --}}
                <symbol id="orn" viewBox="0 0 200 200">
                    <path d="M4 8C38 24 72 56 92 100" stroke="var(--orn-stem)" stroke-width="2.4" fill="none"/>
                    @for($i = 0; $i < 7; $i++)
                        <path d="M{{ 16 + $i * 11 }} {{ 14 + $i * 13 }}q24-16 40 2q-20 14-40-2Z"
                              fill="var(--orn-leaf)" opacity="{{ 0.75 - $i * 0.05 }}"
                              transform="rotate({{ -20 + $i * 6 }} {{ 16 + $i * 11 }} {{ 14 + $i * 13 }})"/>
                    @endfor
                    <path d="M96 30q34 4 36 40q-34 6-36-40Z" fill="var(--orn-leaf-2)" opacity=".7"/>
                    <path d="M100 38q18 10 26 30" stroke="var(--orn-stem)" stroke-width="1.5" fill="none" opacity=".6"/>
                </symbol>
                @break

            @case('sprig')
                {{-- Dried olive sprig --}}
                <symbol id="orn" viewBox="0 0 200 200">
                    <path d="M8 4C30 34 48 70 56 112" stroke="var(--orn-stem)" stroke-width="2" fill="none"/>
                    @for($i = 0; $i < 10; $i++)
                        <ellipse cx="{{ 12 + $i * 5.4 }}" cy="{{ 14 + $i * 11 }}" rx="11" ry="5"
                                 fill="var(--orn-leaf)" opacity="{{ 0.8 - $i * 0.04 }}"
                                 transform="rotate({{ -40 + $i * 2 }} {{ 12 + $i * 5.4 }} {{ 14 + $i * 11 }})"/>
                        <ellipse cx="{{ 28 + $i * 5.4 }}" cy="{{ 20 + $i * 11 }}" rx="10" ry="4.5"
                                 fill="var(--orn-leaf-2)" opacity="{{ 0.7 - $i * 0.04 }}"
                                 transform="rotate({{ 38 - $i * 2 }} {{ 28 + $i * 5.4 }} {{ 20 + $i * 11 }})"/>
                    @endfor
                </symbol>
                @break

            @case('bough')
                {{-- Eucalyptus bough --}}
                <symbol id="orn" viewBox="0 0 200 200">
                    <path d="M2 16C36 22 72 46 96 86" stroke="var(--orn-stem)" stroke-width="2.2" fill="none"/>
                    @for($i = 0; $i < 8; $i++)
                        <circle cx="{{ 14 + $i * 11 }}" cy="{{ 18 + $i * 9 }}" r="{{ 11 - $i * 0.5 }}"
                                fill="var(--orn-leaf)" opacity=".72"/>
                        <circle cx="{{ 22 + $i * 11 }}" cy="{{ 34 + $i * 9 }}" r="{{ 9 - $i * 0.4 }}"
                                fill="var(--orn-leaf-2)" opacity=".62"/>
                    @endfor
                </symbol>
                @break

            @case('wreath')
                {{-- Gold laurel quarter-wreath --}}
                <symbol id="orn" viewBox="0 0 200 200">
                    <path d="M118 8A110 110 0 0 0 8 118" stroke="var(--orn-stem)" stroke-width="2" fill="none"/>
                    @for($i = 0; $i < 11; $i++)
                        @php $a = deg2rad(8 + $i * 7.6); $cx = 8 + 110 * cos($a); $cy = 118 - 110 * sin($a); @endphp
                        <ellipse cx="{{ round($cx, 1) }}" cy="{{ round($cy, 1) }}" rx="13" ry="5"
                                 fill="var(--orn-leaf)" opacity=".78"
                                 transform="rotate({{ round(-rad2deg($a) + 90, 1) }} {{ round($cx, 1) }} {{ round($cy, 1) }})"/>
                    @endfor
                </symbol>
                @break

            @case('frame')
                {{-- Fine double rule with a corner flourish --}}
                <symbol id="orn" viewBox="0 0 200 200">
                    <path d="M4 180V12a8 8 0 0 1 8-8h168" stroke="var(--orn-stem)" stroke-width="1.6" fill="none"/>
                    <path d="M12 180V20a8 8 0 0 1 8-8h160" stroke="var(--orn-stem)" stroke-width="1" fill="none" opacity=".55"/>
                    <circle cx="12" cy="12" r="3.4" fill="var(--orn-bloom)"/>
                    <path d="M24 24q16 2 18 18q-16 2-18-18Z" fill="var(--orn-leaf)" opacity=".6"/>
                </symbol>
                @break
        @endswitch
    </defs>
</svg>

<div class="orn-layer" aria-hidden="true">
    <svg class="orn orn-tl" viewBox="0 0 200 200"><use href="#orn"/></svg>
    <svg class="orn orn-tr" viewBox="0 0 200 200"><use href="#orn"/></svg>
    <svg class="orn orn-bl" viewBox="0 0 200 200"><use href="#orn"/></svg>
    <svg class="orn orn-br" viewBox="0 0 200 200"><use href="#orn"/></svg>
</div>
@endif
