<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entrepreneur;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Models\Stand;

class EntrepreneurAuthController extends Controller
{
    /**
     * Show the registration form
     */
    public function showRegistrationForm()
    {
        return view('auth.entrepreneur.register');
    }

    /**
     * Handle registration
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom_entreprise' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:entrepreneurs',
            'mot_de_passe' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $entrepreneur = Entrepreneur::create([
            'nom_entreprise' => $request->nom_entreprise,
            'email' => $request->email,
            'mot_de_passe' => Hash::make($request->mot_de_passe),
            'role' => 'entrepreneur_en_attente',
            'statut' => 'En attente',
        ]);

        // Automatically create a stand for the entrepreneur
        Stand::create([
            'nom_stand' => $request->nom_entreprise . "'s Stand",
            'description' => 'Default stand description',
            'utilisateur_id' => $entrepreneur->id,
        ]);

        // Log the entrepreneur in
        Auth::guard('entrepreneur')->login($entrepreneur);

        return redirect()->route('entrepreneur.dashboard')
            ->with('success', 'Registration successful! Your account is pending approval.');
    }

    /**
     * Show the login form
     */
    public function showLoginForm()
    {
        return view('auth.entrepreneur.login');
    }

    /**
     * Handle login
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'mot_de_passe' => 'required',
        ]);

        if (Auth::guard('entrepreneur')->attempt(['email' => $credentials['email'], 'mot_de_passe' => $credentials['mot_de_passe']], $request->boolean('remember'))) {
            $request->session()->regenerate();
            
            $entrepreneur = Auth::guard('entrepreneur')->user();
            
            // Check if entrepreneur is rejected
            if ($entrepreneur->statut === 'Rejeté') {
                Auth::guard('entrepreneur')->                                                                                                                                                                                                                                                                                                                                                                   logout();
                return redirect()->back()->withErrors([
                    'email' => 'Votre compte a été rejeté. Raison : ' . $entrepreneur->raison_rejet
                ]);
            }
            
            return redirect()->intended(route('entrepreneur.dashboard'));
        }

        throw ValidationException::withMessages([
            'email' => __('auth.failed'),
        ]);
    }

    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        Auth::guard('entrepreneur')->logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('entrepreneur.login');
    }
}