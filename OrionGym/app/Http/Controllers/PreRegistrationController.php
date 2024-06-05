<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PreRegistration;

class PreRegistrationController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:pre_registrations,email',
            'tel' => 'nullable|string|max:255',
        ]);

        // Remova o campo _token dos dados do formulário
        $data = $request->except('_token');

        

        PreRegistration::create($data);

        return redirect()->back()->with('success', 'Pré-inscrição realizada com sucesso!');
    }
    public function index()
    {
        $preRegistrations = PreRegistration::all();
        return view('pre-registrations.index', compact('preRegistrations'));
    }
}
