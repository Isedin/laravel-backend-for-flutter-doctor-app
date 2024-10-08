<?php

namespace App\Http\Controllers;

use App\Models\Appointments;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class DocsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //get doctor's appointment, patients and display it in the doctor's dashboard
        $doctor = Auth::user();
        $appointments = Appointments::where('doc_id', $doctor->id)->where('status', 'upcoming')->get();

        //return doctor's data and appointments to the dashboard
        return view('dashboard')->with(['doctor' => $doctor, 'appointments' => $appointments]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}