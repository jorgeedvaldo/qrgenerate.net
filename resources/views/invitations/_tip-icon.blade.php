{{-- One inline icon for a guest tip. Expects: $icon (a key from Invitation::TIP_ICONS). --}}
@switch($icon)
    @case('users')
        <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
        @break
    @case('clock')
        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/></svg>
        @break
    @case('mail')
        <svg viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/></svg>
        @break
    @case('dress')
        <svg viewBox="0 0 24 24"><path d="M9 3h6l1 4-3 2 4 12H7l4-12-3-2 1-4Z"/></svg>
        @break
    @case('camera')
        <svg viewBox="0 0 24 24"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2Z"/><circle cx="12" cy="13" r="4"/></svg>
        @break
    @case('music')
        <svg viewBox="0 0 24 24"><path d="M9 18V5l12-2v13"/><circle cx="6" cy="18" r="3"/><circle cx="18" cy="16" r="3"/></svg>
        @break
    @case('heart')
        <svg viewBox="0 0 24 24"><path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.7l-1-1.1a5.5 5.5 0 0 0-7.8 7.8l1 1L12 21l7.8-7.8 1-1a5.5 5.5 0 0 0 0-7.8Z"/></svg>
        @break
    @case('gift')
        <svg viewBox="0 0 24 24"><rect x="3" y="8" width="18" height="13" rx="2"/><path d="M12 8v13M3 12h18M7.5 8a2.5 2.5 0 1 1 0-5C10 3 12 8 12 8s2-5 4.5-5a2.5 2.5 0 1 1 0 5"/></svg>
        @break
    @case('no-kids')
        <svg viewBox="0 0 24 24"><circle cx="12" cy="8" r="3.5"/><path d="M6 21v-2a6 6 0 0 1 12 0v2"/><path d="M3 3l18 18"/></svg>
        @break
    @default
        <svg viewBox="0 0 24 24"><path d="m12 3 1.5 4.5L18 9l-4.5 1.5L12 15l-1.5-4.5L6 9l4.5-1.5L12 3Z"/><path d="M19 15l.7 2.3L22 18l-2.3.7L19 21l-.7-2.3L16 18l2.3-.7L19 15Z"/></svg>
@endswitch
