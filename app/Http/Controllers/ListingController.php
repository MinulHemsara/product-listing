<?php

namespace App\Http\Controllers;

use App\Models\listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
    public function index(){
        return view('listings.index',[
            'listings' => Listing::latest()->filter(request(['tag','search']))->paginate(5)
        ]);
    }

    public function show(listing $listing){
        return view('listings.show',[
            'listing' => $listing
        ]);
    }

    public function create(){
        return view('listings.create');
    }

public function store(Request $request){
$formFields = $request->validate([
    'title' => 'required',
    'company' => ['required', Rule::unique('listings', 'company')],
    'location'=>'required',
    'website'=> 'required',
    'email' => ['required','email'],
    'tags' => 'required',
    'description' => 'required'

]);

if($request->hasFile('logo')){
    $formFields['logo'] = $request->file('logo')->store('logos','public');
}


$formFields['user_id']=auth()->id();

listing::create($formFields);


Session::flash('message','Listing Created Successfully');

return redirect('/');

}

public function edit(listing $listing){
    return view('listings.edit',['listing' => $listing]);
}


//updatre
public function update(Request $request,listing $listing){


if($listing->user_id != auth()->id()){
    abort(403,'unauthorized action');
}

    $formFields = $request->validate([
        'title' => 'required',
        'company' => ['required', Rule::unique('listings', 'company')],
        'location'=>'required',
        'website'=> 'required',
        'email' => ['required','email'],
        'tags' => 'required',
        'description' => 'required'
    
    ]);
    
    if($request->hasFile('logo')){
        $formFields['logo'] = $request->file('logo')->store('logos','public');
    }
    
    $listing->update($formFields);
    
    
    // Session::flash();
    
    return back()->with('message','Listing Created Successfully');
    
    }

    public function delete(listing $listing){

        if($listing->user_id != auth()->id()){
            abort(403,'unauthorized action');
        }
        $listing->delete();
        return redirect('/')->with('message','deleted successfully');
    }


    public function manage(){
        return view('listings.manage',['listings'=>auth()->user()->listings()->get()]);
    }

}