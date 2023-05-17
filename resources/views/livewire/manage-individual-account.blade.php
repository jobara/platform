<tr>
    <td>
        @if ($individual->isPublishable())
            <a href="{{ localized_route('individuals.show', $individual) }}"><strong>{{ $individual->name }}</strong></a>
        @else
            <strong>{{ $individual->name }}</strong>
        @endif
        <br />
        {{ __('Individual') }}
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
        <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
    </td>
    <td>
        @if ($user->checkStatus('suspended'))
            <strong>{{ __('Suspended') }}</strong>
        @elseif($user->checkStatus('approved'))
            <strong>{{ __('Approved') }}</strong>
        @else
            {{ __('Pending approval') }}
        @endif
    </td>
    <td>
        <form wire:submit.prevent="approve">
            <fieldset class="field @error('roles') field--error @enderror">
                <x-hearth-checkboxes name="roles" :options="$roles" :checked="old('roles', $individual->roles)" />
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
        </form>
    </td>
</tr>
