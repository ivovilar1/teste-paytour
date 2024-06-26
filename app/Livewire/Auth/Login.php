<?php

namespace App\Livewire\Auth;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Login extends Component
{
    public string $email = 'joe@doe.com';

    public string $password = 'password';

    #[Layout('components.layouts.guest')]
    public function render(): View
    {
        return view('livewire.auth.login');
    }

    public function login(): void
    {
        if(!Auth::attempt([
            'email' => $this->email,
            'password' => $this->password,
        ])) {
            $this->addError('invalidCredentials', trans('auth.failed'));
            return ;
        }

        $this->redirect(route('dashboard'));
    }
}
