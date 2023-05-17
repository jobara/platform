<tr>
    <td>
        @if ($account->isPublishable())
            <a
                href="{{ localized_route($account->getRoutePrefix() . '.show', $account) }}"><strong>{{ $account->name }}</strong></a>
        @else
            <strong>{{ $account->name }}</strong>
        @endif
        <br />
        {{ $account instanceof App\Models\RegulatedOrganization ? Str::ucfirst(__('regulated-organization.singular_name')) : Str::ucfirst(__('organization.singular_name')) }}
        @if (!$user->checkStatus('suspended'))
            <form wire:submit.prevent="suspend">
                <button class="secondary destructive">
                    @svg('heroicon-o-ban')
                    {{ __('Suspend') }}
                </button>
            </form>
        @else
            <form wire:submit.prevent="unsuspend">
                <button class="secondary">{{ __('Unsuspend') }}</button>
            </form>
        @endif
    </td>
    <td>
        <a href="mailto:{{ $account->contact_person_email }}">{{ $account->contact_person_email }}</a>
    </td>
    <td>
        @if ($account->checkStatus('suspended'))
            <strong>{{ __('Suspended') }}</strong>
        @elseif($account->checkStatus('approved'))
            <strong>{{ __('Approved') }}</strong>
        @else
            {{ __('Pending approval') }}
        @endif
    </td>
    <td>
        {{-- TODO: Remove --}}
        @if ($account->checkStatus('suspended'))
            <span class="text-error flex items-center gap-2">
                @svg('heroicon-o-ban') <span class="font-semibold">{{ __('Suspended') }}</span>
            </span>
        @else
            @if ($account->checkStatus('pending'))
                {{ __('Pending approval') }}
            @elseif($account->checkStatus('approved'))
                {{ __('Approved') }}
            @endif
        @endif
    </td>
    <td>
        <form wire:submit.prevent="approve">
            @if ($account instanceof App\Models\Organization)
                <fieldset class="field @error('roles') field--error @enderror">
                    <x-hearth-checkboxes name="roles" :options="$roles" :checked="old('roles', $account->roles)" />
                    <x-hearth-error for="roles" />
                </fieldset>

                <button class="secondary">
                    @if ($user->checkStatus('approved'))
                        {{ __('Update') }}
                    @else
                        {{ __('Approve') }}
                    @endif
                </button>
                <button class="borderless" type="button" wire:click="$refresh">{{ __('Reset') }}
                @elseif ($user->checkStatus('pending'))
                    <button class="secondary">{{ __('Approve') }}</button>
            @endif
        </form>
    </td>
</tr>
