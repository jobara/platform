@if(session('status') === 'email-verified')
    <x-alert type="success" :title="__('auth.verification_completed')">
        <p>{{ __('auth.verification_completed_message') }}</p>
    </x-alert>
@endif

@if(session('status') === 'verification-link-sent')
<x-alert type="success" :title="__('auth.verification_sent_title')">
    <p>{{ __('auth.verification_sent') }}</p>
</x-alert>
@endif

@auth
@unless(Auth::user()->hasVerifiedEmail())
    <x-alert type="info" :title="__('auth.verification_required')">
        <p>{{ __('auth.updated_verification_sent') }}</p>
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <div>
                <x-button>
                    {{ __('auth.resend_verification_email') }}
                </x-button>
            </div>
        </form>
    </x-alert>
@endunless
@endauth

@if(session('status') === 'profile-information-updated')
<x-alert type="success" :title="__('user.profile_updated')">
    <p>{{ __('user.profile_updated_message') }}</p>
</x-alert>
@endif

@if(session('status') === 'password-updated')
<x-alert type="success" :title="__('auth.password_changed')">
    <p>{{ __('auth.password_changed_message') }}</p>
</x-alert>
@endif

@if(Session::has('success'))
    <x-alert type="success">
        {{ Session::get('success') }}
    </x-alert>
@endif
