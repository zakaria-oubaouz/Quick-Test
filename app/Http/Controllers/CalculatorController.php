<?php

namespace App\Http\Controllers;

use App\Http\Requests\CalculatorRequest;
use Illuminate\Http\Request;

class CalculatorController extends Controller
{
    public function index()
    {
        return view('calculator');
    }

    public function calculate(CalculatorRequest $request)
    {
        $expression = $request->expression;
        // Vérification de la division par zéro
        if (preg_match('/\/0($|[\+\-\*\/])/', $expression)) {
            if ($request->ajax()) {
                return response()->json(['result' => 'Division par zéro est invalide'], 422);
            }
            return view('calculator', ['result' => 'Division par zéro est invalide']);
        }
        
        try {
            // La fonction eval Évalue le code fourni comme étant du code PHP
            $result = eval("return " . $expression . ";");
        } catch (\Exception $e) {
            $result = 'Expression invalide';
        }
        // A priori la requete est en ajax
        if ($request->ajax()) {
            return response()->json(['result' => $result]);
        }

        return view('calculator', compact('result'));
    }
}
