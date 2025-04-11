<?php
    namespace App\Livewire;

    use Livewire\Component;
    use Livewire\WithFileUploads;
    use Livewire\Attributes\Rule;
    use App\Models\User;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Support\Str;

    class RegisterUser extends Component
    {
        use WithFileUploads;

        #[Rule('required|string')]
        public $name;

        #[Rule('required|email|unique:users,email')]
        public $email;

        #[Rule('required|string|min:8')]
        public $password;

        #[Rule('required|string|max:20')]
        public $telephone;

        #[Rule('required|string|in:F,M')]
        public $sexe = 'F';

        #[Rule('required|string')]
        public $adresse;

        #[Rule('nullable|image|mimes:png,jpg,gif,jpeg|max:5000')]
        public $profil;

        #[Rule('required|string')]
        public $poste;

        #[Rule('required|date')]
        public $date_de_naissance;

        public function register()
        {
            $this->validate();

            $userData = [
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'telephone' => $this->telephone,
                'sexe' => $this->sexe,
                'adresse' => $this->adresse,
                'poste' => $this->poste,
                'date_de_naissance' => $this->date_de_naissance,
                'role' => 'employee',
                'employee_code' => 'EMP-' . Str::random(8),
                'profil' => null, // Default to null
            ];

            // Handle profile photo upload with custom filename
            if ($this->profil) {
                $extension = $this->profil->getClientOriginalExtension();
                $filename = 'profile_' . time() . '_' . Str::random(8) . '.' . $extension;
                $path = $this->profil->storeAs('Avatar', $filename, 'public');

                if (!$path) {
                    throw new \Exception('Failed to upload the file');
                }

                $userData['profil'] = $path;
            }

            // Create the user
            User::create($userData);

            session()->flash('message', 'User Registration Successful');

            return $this->redirect('/login', navigate: true);
        }

        public function render()
        {
            return view('livewire.register-user');
        }
    }