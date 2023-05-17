<?php

namespace App\Http\Livewire;

use App\Models\Individual;
use App\Models\User;
use App\Notifications\AccountApproved;
use App\Notifications\AccountSuspended;
use App\Notifications\AccountUnsuspended;
use Illuminate\Validation\Rules\Enum;
use Livewire\Component;
use Spatie\LaravelOptions\Options;

class ManageIndividualAccount extends Component
{
    public User $user;

    public Individual $individual;

    public array $roles;

    public function mount()
    {
        $this->individual = $this->user->individual;
        $this->roles = Options::forEnum(IndividualRole::class)->toArray();
    }

    public function render()
    {
        return view('livewire.manage-individual-account');
    }

    public function approve()
    {
        $data = $this->validate([
            ['roles' => 'required|array'],
            ['roles.required' => __('You must select what :name would like to do on the website.', ['name' => $this->individual->name])],
            ['roles.*' => [new Enum(IndividualRole::class)]],
        ]);

        $this->individual->fill($data);
        $this->individual->save();

        if ($this->user->checkStatus('pending')) {
            $this->user->update(['oriented_at' => now()]);
            $this->user->notify(new AccountApproved($this->individual));
            $this->emit('flashMessage', __(':account has been approved.', ['account' => $this->individual->name]));
        }
    }

    // public function approve()
    // {
    //     $this->user->update(['oriented_at' => now()]);

    //     $this->user->notify(new AccountApproved($this->individual));
    //     $this->emit('flashMessage', __(':account has been approved.', ['account' => $this->individual->name]));
    // }

    public function suspend()
    {
        $this->user->update(['suspended_at' => now()]);

        $this->user->notify(new AccountSuspended($this->individual));
        $this->emit('flashMessage', __(':account has been suspended.', ['account' => $this->individual->name]));
    }

    public function unsuspend()
    {
        $this->user->update(['suspended_at' => null]);

        $this->user->notify(new AccountUnsuspended($this->individual));
        $this->emit('flashMessage', __('The suspension of :account has been lifted.', ['account' => $this->individual->name]));
    }
}
