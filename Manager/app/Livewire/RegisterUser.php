<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class RegisterUser extends Component
{

    public $name;
    public $email;
    public $password;
    public $telephone;
    public $sexe;
    public $adresse;
    public $profil;
    public $poste;
    public $date_de_naissance;

    protected $rules = [
        'name' => 'required|string',
        'email' => 'email|required|unique:users,email',
        'telephone' => 'string|required',
        'password' => 'required|min:8',
        'sexe' => 'string|required',
        'profil' => 'nullable|image|mimes:png,jpg,gif,jpeg|max:50000',
        'adresse' => 'required|string',
        'poste' => 'string|required',
        'date_de_naissance' => 'required|date',
    ];

    public function register()
    {
        $this->validate();

        User::create([
            'name' => $this->name 
        ]);
    }

    public function render()
    {
        return view('livewire.register-user');
    }
}
