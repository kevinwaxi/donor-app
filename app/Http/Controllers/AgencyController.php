<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AgencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Agency::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //creating new agency
        $this->validate($request, [
            'agency_name' => 'required|unique:agencies',
            'mobile' => 'required|unique:agencies|unique:users',
            'email' => 'required|unique:agencies|unique:users',
            'agency_type' => 'required',
            'agency_desc' => 'required',
            'address' => 'required|unique:agencies',
            'agency_location' =>'required',
        ]);

        return Agency::create([
            'user_id'=> Auth::user()->id,
            'agency_name' =>$request->agency_name,
            'mobile' =>$request->mobile,
            'email'=>$request ->email,
            'agency_type'=>$request->agency_type,
            'agency_location'=>$request->agency_location,
            'agency_desc'=>$request->agency_desc,
            'address'=>$request->address,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Agency  $agency
     * @return \Illuminate\Http\Response
     */
    public function show(Agency $agency)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Agency  $agency
     * @return \Illuminate\Http\Response
     */
    public function edit(Agency $agency)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Agency  $agency
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Agency $agency)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Agency  $agency
     * @return \Illuminate\Http\Response
     */
    public function destroy(Agency $agency)
    {
        //
    }
}
