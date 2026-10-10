{{-- Shared styling for the invitation dashboard screens. --}}
@push('styles')
<style>
    .dash { max-width: 900px; margin: 26px auto 60px; }
    .dash-head { display: flex; flex-wrap: wrap; gap: 12px; align-items: center; justify-content: space-between; margin-bottom: 22px; }
    .dash-head h1 { font-size: 26px; font-weight: 700; color: #5b287a; margin: 0; }
    .dash-head p { color: #6b7280; font-size: 14px; margin: 4px 0 0; }

    .panel-box {
        background: #fff; border: 1px solid #e9e2ef; border-radius: 12px;
        padding: 22px; margin-bottom: 18px; box-shadow: 0 1px 4px rgba(91,40,122,.06);
    }
    .panel-box > h2 {
        font-size: 15px; font-weight: 700; color: #5b287a; margin: 0 0 4px;
        text-transform: uppercase; letter-spacing: .06em;
    }
    .panel-box > .panel-hint { color: #6b7280; font-size: 13.5px; margin: 0 0 18px; }

    .step-badge {
        display: inline-block; background: #f3edf7; color: #5b287a; font-size: 11px;
        font-weight: 700; padding: 3px 9px; border-radius: 999px; letter-spacing: .08em; margin-bottom: 8px;
    }

    .dash .form-group { margin-bottom: 14px; }
    .dash label { font-weight: 600; font-size: 12.5px; color: #444; display: block; margin-bottom: 4px; }
    .dash .form-control {
        border-radius: 8px !important; border: 1.5px solid #ddd !important;
        font-size: 14px; box-shadow: none !important;
    }
    .dash .form-control:focus { border-color: #7b4397 !important; box-shadow: 0 0 0 3px rgba(123,67,151,.12) !important; }
    .dash .help-small { font-size: 12px; color: #9ca3af; margin: 4px 0 0; display: block; }
    .grid-2 { display: grid; gap: 14px; }
    .grid-3 { display: grid; gap: 14px; }
    @media (min-width: 640px) { .grid-2 { grid-template-columns: 1fr 1fr; } .grid-3 { grid-template-columns: repeat(3, 1fr); } }

    .btn-pill {
        display: inline-flex; align-items: center; gap: 7px; padding: 10px 18px;
        border-radius: 8px; font-size: 14px; font-weight: 600; text-decoration: none;
        cursor: pointer; border: 1.5px solid transparent; font-family: inherit;
    }
    .btn-main { background: linear-gradient(to bottom, #8a53a6, #6b3488); color: #fff !important; }
    .btn-main:hover { background: #5b287a; }
    .btn-outline { background: #fff; border-color: #d1bfe0; color: #5b287a !important; }
    .btn-outline:hover { background: #f8f5fa; }
    .btn-danger-soft { background: #fff; border-color: #fecaca; color: #b91c1c !important; }
    .btn-danger-soft:hover { background: #fef2f2; }

    .inv-card {
        background: #fff; border: 1px solid #e9e2ef; border-radius: 12px; padding: 18px;
        display: flex; flex-wrap: wrap; gap: 14px; align-items: center; margin-bottom: 14px;
    }
    .inv-thumb {
        width: 64px; height: 64px; border-radius: 10px; flex: 0 0 64px;
        display: flex; align-items: center; justify-content: center; font-size: 26px; color: #fff;
        background: linear-gradient(140deg, #8a53a6, #5b287a); object-fit: cover;
    }
    .inv-body { flex: 1 1 200px; min-width: 0; }
    .inv-body h3 { font-size: 18px; margin: 0 0 3px; font-weight: 700; color: #2d2a26; }
    .inv-meta { font-size: 13px; color: #6b7280; }
    .inv-stats { display: flex; gap: 16px; font-size: 13px; color: #4b5563; margin-top: 6px; }
    .inv-actions { display: flex; flex-wrap: wrap; gap: 8px; }
    .pill {
        display: inline-block; font-size: 11px; font-weight: 700; padding: 2px 9px;
        border-radius: 999px; background: #f3edf7; color: #5b287a; letter-spacing: .05em;
    }

    .repeater-item {
        border: 1.5px solid #ece5f3; border-radius: 10px; padding: 16px;
        margin-bottom: 12px; background: #fcfaFD; position: relative;
    }
    .repeater-item .remove-btn {
        position: absolute; top: 10px; right: 10px; background: #fff; border: 1px solid #fecaca;
        color: #b91c1c; border-radius: 6px; font-size: 12px; padding: 3px 9px; cursor: pointer;
    }
    .btn-add {
        background: #f3edf7; border: 1.5px dashed #c4a8d6; color: #5b287a; border-radius: 8px;
        padding: 10px 16px; font-size: 13.5px; font-weight: 600; cursor: pointer; width: 100%;
    }
    .btn-add:hover { background: #ece0f3; }

    .switch-row { display: flex; align-items: center; justify-content: space-between; gap: 14px; padding: 10px 0; border-bottom: 1px solid #f1eef5; }
    .switch-row:last-child { border-bottom: none; }
    .switch-row .switch-label { font-size: 14px; font-weight: 600; color: #374151; }
    .switch-row .switch-hint { font-size: 12.5px; color: #9ca3af; display: block; font-weight: 400; }
    .toggle { position: relative; display: inline-block; width: 44px; height: 24px; flex: 0 0 44px; }
    .toggle input { opacity: 0; width: 0; height: 0; }
    .toggle-slider { position: absolute; inset: 0; background: #cbd5e1; border-radius: 999px; transition: .2s; cursor: pointer; }
    .toggle-slider::before {
        content: ''; position: absolute; width: 18px; height: 18px; left: 3px; top: 3px;
        background: #fff; border-radius: 50%; transition: .2s;
    }
    .toggle input:checked + .toggle-slider { background: #7b4397; }
    .toggle input:checked + .toggle-slider::before { transform: translateX(20px); }

    .swatch-row { display: flex; gap: 16px; align-items: flex-end; flex-wrap: wrap; }
    .swatch-row input[type=color] { width: 54px; height: 38px; border: 1px solid #ccc; border-radius: 6px; cursor: pointer; padding: 2px; }
    .theme-preview { flex: 1 1 160px; min-width: 150px; height: 38px; border-radius: 8px; }

    .link-box {
        display: flex; gap: 8px; align-items: center; background: #f9fafb; border: 1px solid #e5e7eb;
        border-radius: 8px; padding: 9px 12px; font-size: 13px; word-break: break-all;
    }
    .link-box code { background: none; color: #374151; padding: 0; font-size: 13px; }

    .table-clean { width: 100%; border-collapse: collapse; font-size: 14px; }
    .table-clean th {
        text-align: left; font-size: 11.5px; text-transform: uppercase; letter-spacing: .07em;
        color: #6b7280; border-bottom: 2px solid #ece5f3; padding: 9px 10px;
    }
    .table-clean td { padding: 11px 10px; border-bottom: 1px solid #f1eef5; vertical-align: top; }
    .table-wrap { overflow-x: auto; }
    .badge-yes { background: #ecfdf5; color: #065f46; }
    .badge-no { background: #fef2f2; color: #991b1b; }

    .empty-state { text-align: center; padding: 48px 20px; color: #6b7280; }
    .empty-state .emoji { font-size: 44px; display: block; margin-bottom: 12px; }
    .empty-state h2 { font-size: 20px; color: #374151; margin: 0 0 8px; font-weight: 700; }
    .stat-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); gap: 12px; }
    .stat {
        background: #fff; border: 1px solid #e9e2ef; border-radius: 10px; padding: 14px; text-align: center;
    }
    .stat-num { font-size: 26px; font-weight: 700; color: #5b287a; line-height: 1; }
    .stat-lbl { font-size: 11.5px; text-transform: uppercase; letter-spacing: .07em; color: #6b7280; margin-top: 6px; }
</style>
@endpush
