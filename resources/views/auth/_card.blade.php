{{-- Shared shell for the account pages: a centred card with the Google button.
     Expects: $locale, $heading, $subheading, plus a "body" slot via @slot. --}}
@push('styles')
<style>
    .auth-wrap { max-width: 440px; margin: 40px auto 60px; }
    .auth-card {
        background: #fff; border-radius: 12px; padding: 32px 28px;
        box-shadow: 0 4px 24px rgba(91,40,122,.12); border-top: 4px solid #7b4397;
    }
    .auth-card h1 { font-size: 24px; font-weight: 700; color: #5b287a; margin: 0 0 6px; }
    .auth-card .auth-sub { color: #6b7280; font-size: 14px; margin-bottom: 24px; }
    .auth-card .form-group { margin-bottom: 16px; }
    .auth-card label { font-weight: 600; font-size: 13px; color: #444; display: block; margin-bottom: 5px; }
    .auth-card .form-control {
        border-radius: 8px !important; border: 1.5px solid #ddd !important;
        height: 42px; font-size: 14px; box-shadow: none !important;
    }
    .auth-card .form-control:focus { border-color: #7b4397 !important; box-shadow: 0 0 0 3px rgba(123,67,151,.12) !important; }
    .btn-block-lg {
        display: block; width: 100%; padding: 11px; border-radius: 8px;
        font-weight: 600; font-size: 15px; border: none; cursor: pointer;
    }
    .btn-primary-auth { background: linear-gradient(to bottom, #8a53a6, #6b3488); color: #fff; }
    .btn-primary-auth:hover { background: #5b287a; color: #fff; }
    .btn-google {
        display: flex; align-items: center; justify-content: center; gap: 10px;
        width: 100%; padding: 10px; border-radius: 8px; background: #fff;
        border: 1.5px solid #dadce0; color: #3c4043 !important; font-weight: 600;
        font-size: 15px; text-decoration: none; transition: background .15s, box-shadow .15s;
    }
    .btn-google:hover { background: #f8f9fa; box-shadow: 0 1px 3px rgba(60,64,67,.2); text-decoration: none; }
    .auth-divider { display: flex; align-items: center; gap: 12px; margin: 22px 0; color: #9ca3af; font-size: 12px; text-transform: uppercase; }
    .auth-divider::before, .auth-divider::after { content: ''; flex: 1; height: 1px; background: #e5e7eb; }
    .auth-foot { text-align: center; margin-top: 20px; font-size: 14px; color: #6b7280; }
    .auth-foot a { color: #7b4397; font-weight: 600; }
    .auth-alert { border-radius: 8px; font-size: 14px; padding: 12px 14px; margin-bottom: 18px; }
    .auth-legal { font-size: 12px; color: #9ca3af; text-align: center; margin-top: 16px; line-height: 1.5; }
</style>
@endpush
