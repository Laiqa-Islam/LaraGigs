<?php

namespace App\Http\Controllers;

use App\Models\Listings;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class ListingController extends Controller
{
    //Show Index Page
    public function index(){
        return view('listings.index',[
            'listings'=> Listings::latest()->filter(request(['tag','search']))->paginate(6)]);
    }

    //Show Single Listing
    public function show(Listings $listing){
        return view('listings.show',[
            'listing'=> $listing
        ]);
    }

    //Show Create Page
    public function create(){
        return view('listings.create');
    }

    //Post Create Page
    public function store(Request $request){
        $formFields= $request->validate(
            [
                'title'=> 'required',
                'location'=> 'required',
                'company'=> 'required',
                'tags'=> 'required',
                'website'=> 'required',
                'description'=> 'required',
                'email'=>['required', Rule::unique('listings','email')]
            ]
        );

        if(request()->hasFile('logo')){
            $file = request()->file('logo'); //Stores the file name in variable
            $formFields['logo']= $file->store('logos','public'); //stores the file in logos folder inside storage 
        }

        $formFields['user_id']= Auth::id();
        // dd($formFields);


        Listings::create($formFields);
        return redirect()->route('index')->with('success','Listing Created Successfully!');

    }

    //show edit form

    public function edit(Listings $listing){
        return view('listings.edit',['listing'=>$listing]);
    }
    //Post Edit Page
    public function update(Request $request, Listings $listing){
        //Make sure the suer is the owner
        if($listing->user_id!=auth('web')->user()->id){
            abort(403,'Unauthorized Action');
        }

        $formFields= $request->validate(
            [
                'title'=> 'required',
                'location'=> 'required',
                'company'=> 'required',
                'tags'=> 'required',
                'website'=> 'required',
                'description'=> 'required',
                'email'=>'required'
            ]
        );

        if(request()->hasFile('logo')){
            $file = request()->file('logo'); //Stores the file name in variable
            $formFields['logo']= $file->store('logos','public'); //stores the file in logos folder inside storage 
        }

        $listing->update($formFields);
        return back()->with('success','Listing Updated Successfully!');

    }

    //Delete listing
    public function destroy(Listings $listing){
          //Make sure the suer is the owner
          if($listing->user_id!=auth('web')->user()->id){
            abort(403,'Unauthorized Action');
        }
        
        $listing->delete();
        return redirect("/")->with('success','Listing Deleted Successfylly!');
    }


    //manage Listings
    public function manage(){
        return view('listings.manage',['listings'=>auth('web')->user()->listings()->get()]);
    }
}
