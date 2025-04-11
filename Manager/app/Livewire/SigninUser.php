<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Rule;
use Livewire\Component;

class SigninUser extends Component
{
    #[Rule('required|email')]
    public $email;

    #[Rule('required|string|min:8')]
    public $password;

    public $error ;

    public function signin() 
    {
        $this->validate() ;

        $loginData = [
            'email' => $this->email ,
            'password' => $this->password
        ];

        if(Auth::attempt($loginData))
        {
            request()->session()->regenerate();

            $user = Auth::user() ;

            if($user->role === 'employee')
            {
                return redirect()->intended('/employee');
            }
            if($user->role === 'admin' || $user->role === 'super_admin')
            {
                return redirect()->intended('/admin');
            }
        }

        $this->error = 'Sorry!! No User Found with those Credentials' ;
    }

    public function logout()
    {
        Auth::logout() ;

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/');
    }

    public function render()
    {
        return view('livewire.signin-user');
    }
}
