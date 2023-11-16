<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expenditure; 
class ExpenditureController extends Controller
{
    public function index()
    {
        
        $expenditures = Expenditure::paginate(10); 

        return view('expenditures.index', ['expenditures' => $expenditures]);
    }



    public function create()
    {
        
        return view('expenditures\create');
    }

    public function store(Request $request)
    {
        
        $request->validate([
            'description' => 'required',
            'amount' => 'required|numeric',
            'category' => 'required',
            
        ]);

        Expenditure::create([
            'description' => $request->description,
            'amount' => $request->amount,
            'category' => $request->category,
            'date' => now(),
        
        ]);

        return redirect()->route('expenditures.index')->with('success', 'Expenditure added successfully.');
    }
    public function update(Request $request, $id)
    {
        $expenditure = Expenditure::find($id);

        // Validate the form data
        $validatedData=$request->validate([
            'description' => 'required',
            'amount' => 'required|numeric',
            'category' => 'required',
            
        ]);

        // Update the contact
        $expenditure->update($validatedData);

        return redirect()->route('expenditures.index');
    }

    public function edit($id)
    {
        $expenditure = Expenditure::find($id);
        return view('expenditures.edit', compact('expenditure'));
    }

    

    public function destroy($id)
    {
       
        $expenditure = Expenditure::find($id);
        $expenditure->delete();

        return redirect()->route('expenditures.index');
    }
}
