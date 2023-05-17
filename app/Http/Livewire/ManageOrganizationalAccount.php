<?php

namespace App\Http\Livewire;

use App\Models\Organization;
use App\Models\RegulatedOrganization;
use App\Notifications\AccountApproved;
use App\Notifications\AccountSuspended;
use App\Notifications\AccountUnsuspended;
use Illuminate\Validation\Rules\Enum;
use Livewire\Component;
use Spatie\LaravelOptions\Options;

class ManageOrganizationalAccount extends Component
{
    public Organization|RegulatedOrganization $account;

    public array $roles;

    public function mount()
    {
        $this->roles = Options::forEnum(IndividualRole::class)->toArray();
    }

    public function render()
    {
        return view('livewire.manage-organizational-account');
    }

    public function approve()
    {
        if ($this->account instanceof Organization) {
            $data = $this->validate([
                ['roles' => 'required|array'],
                ['roles.required' => __('You must select what :name would like to do on the website.', ['name' => $this->account->name])],
                ['roles.*' => [new Enum(IndividualRole::class)]],
            ]);

            $this->individual->fill($data);
            $this->individual->save();
        }

        if ($this->user->checkStatus('pending')) {
            $this->user->update(['oriented_at' => now()]);
            $this->user->notify(new AccountApproved($this->individual));
            $this->emit('flashMessage', __(':account has been approved.', ['account' => $this->individual->name]));
        }
    }

    // public function approve()
    // {
    //     $this->account->update([
    //         'oriented_at' => now(),
    //         'validated_at' => now(),
    //     ]);

    //     $this->account->notify(new AccountApproved($this->account));
    //     $this->emit('flashMessage', __(':account has been approved.', ['account' => $this->account->getTranslation('name', locale())]));
    // }

    public function suspend()
    {
        $this->account->update(['suspended_at' => now()]);

        foreach ($this->account->users as $user) {
            $user->update(['suspended_at' => now()]);
            if ($user->email !== $this->account->contact_person_email) {
                $user->notify(new AccountSuspended($this->account));
            }
        }

        $this->account->notify(new AccountSuspended($this->account));
        $this->emit('flashMessage', __(':account and its users have been suspended.', ['account' => $this->account->getTranslation('name', locale())]));
    }

    public function unsuspend()
    {
        $this->account->update(['suspended_at' => null]);

        foreach ($this->account->users as $user) {
            $user->update(['suspended_at' => null]);
            if ($user->email !== $this->account->contact_person_email) {
                $user->notify(new AccountUnsuspended($this->account));
            }
        }

        $this->account->notify(new AccountUnsuspended($this->account));
        $this->emit('flashMessage', __('The suspension of :account and its users has been lifted.', ['account' => $this->account->getTranslation('name', locale())]));
    }
}
