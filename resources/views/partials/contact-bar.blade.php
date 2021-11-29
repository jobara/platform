<ul class="contact-bar" role="list">
    <li>
        <x-heroicon-s-phone aria-hidden="true" class="icon" />
        <x-heroicon-s-chat aria-hidden="true" class="icon" />
        <a href="tel:{{ settings()->get('phone', '1-800-123-4567') }}" >
            <span class="visually-hidden">{{ __('phone or text') }}:</span>
            {{ settings()->get('phone', '1-800-123-4567') }}
        </a>
    </li>
    <li>
        <x-heroicon-s-video-camera aria-hidden="true" class="icon" />
        <a href="tel:{{ settings()->get('vrs', '1-800-987-5643') }}">
            <span class="visually-hidden">{{ __('video relay service') }}:</span>
            {{ settings()->get('vrs', '1-800-987-5643') }}
        </a>
    </li>
    <li>
        <span class="visually-hidden">{{ __('email') }}</span>
        <x-heroicon-s-inbox aria-hidden="true" class="icon" />
        <a href="mailto:{{ settings()->get('email', 'support@accessibilityexchange.ca') }}">
            {{ settings()->get('email', 'support@accessibilityexchange.ca') }}
        </a>
    </li>
    <li class="exit">
        @auth
        <form method="POST" action="{{ localized_route('exit') }}">
            @csrf
            <button type="submit">
                <x-heroicon-o-logout aria-hidden="true" class="icon" />
                {{ __('Quick exit') }}
            </button>
        </form>
        @else
        <a class="button" rel="nofollow noopener noreferrer" href="https://weather.com">
            <x-heroicon-o-logout aria-hidden="true" class="icon" />
            {{ __('Quick exit') }}
        </a>
        @endauth
    </li>
</ul>