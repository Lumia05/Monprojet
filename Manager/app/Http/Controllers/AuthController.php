<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function register(){
        return view('pages.signup');
    }

    public function create(Request $request)
    {
        try {
            $validateData = $request->validate([
                'name' => 'required|string',
                'email' => 'email|required|unique:users,email',
                'telephone' => 'string|required',
                'password' => 'required|min:8',
                'sexe' => 'string|required',
                // 'profil' => 'required|image|mimes:png,jpg,gif,jpeg|max=50000',
                'adresse' => 'required|string',
                'poste' => 'string|required',
            ]);

            $userData = $request->except('profil');

            //gerer lenregistrement de phto de profil
            if($request->hasFile('profil')) {
                $file = $request->file('profil');
                $extension = $file->getClientOriginalExtension();
                $filename = 'profile_'. time() . '.' . $extension ;
                $path = $file->storeAs('Avatar' ,  $filename , 'public');
            

                if (!$path) {
                    throw new \Exception('Failed to upload the file');
                }

                $userData['profil'] = $filename ;
            }

            $newUser = User::create($request->all());
            
            // Log::info('user:', $newUser);

            $newUser->profil = $filename ;
            $newUser->save();

            return view('welcome');

        } catch (\Exception $e){
            Log::error($e);
        }
    }

    // public function 
}
