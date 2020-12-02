<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use Illuminate\Http\Request;

class DonationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        
        return Donation::with(['user', 'agency'])->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //creating a list of donated items
        //validadtion 
        $this->validate($request, [
            'user_id' => 'required',
            'item_name' => 'required',
            'item_type' => 'required',
            'item_unit' => 'required',
            'item_quantity' => 'required',
            'item_desc' => 'required'
        ]);
        return Donation::create([
            'user_id' => $request->user_id,
            'item_name' => $request->item_name,
            'item_type' => $request->item_type,
            'item_unit' => $request->item_unit,
            'item_quantity' => $request->item_quantity,
            'item_desc' => $request->item_desc,
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
     * @param  \App\Models\Donation  $donation
     * @return \Illuminate\Http\Response
     */
    public function show(Donation $donation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Donation  $donation
     * @return \Illuminate\Http\Response
     */
    public function edit(Donation $donation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Donation  $donation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //validate upon assigning donations to Agencies
        $this->validate($request, [
            'item_name'=> 'required',
            'agency_id' => 'required',
            'id' => 'required',
        ]);
        return Donation::where('id', $request->id)->update([
            'item_name' => $request->item_name,
            'agency_id' => $request->agency_id,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Donation  $donation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Donation $donation)
    {
        //
    }
}
