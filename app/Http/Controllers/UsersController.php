<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\UserDetails;
use Illuminate\Support\Facades\Auth;
use App\Models\Doctor;
use App\Models\Appointments;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = array();
        $user = Auth::user();
        $doctor = User::where('type', 'doctor')->get();
        $doctorData = Doctor::all();
        //return today appointment together with user data
        $date = now()->format('n/j/Y'); // this is date format without leading zero
        $appointment = Appointments::where('date', $date)->first();

        //collect user data and all doctor details
        foreach ($doctorData as $data) {
            //sorting doctor name and doctor details
            foreach ($doctor as $info) {
                if ($data['doc_id'] == $info['id']) {
                    $data['doctor_name'] = $info['name'];
                    $data['doctor_profile'] = $info['profile_photo_url'];
                    if (isset($appointment) && $appointment['doc_id'] == $info['id']) {
                        $data['appointment'] = $appointment;
                    }
                }
            }
        }
        $user['doctor'] = $doctorData;
        return $user; //return user data and doctor details
    }

    /**
     * login.
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        //create a controller to handle incoming requests and return some data
        //validate incoming inputs
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        //check if the user exists in the database
        $user = User::where('email', $request->email)->first();

        //check password
        if (!$user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['These credentials do not match our records.'],
            ]);
        }

        //then return generated token
        return $user->createToken($request->email)->plainTextToken;
    }

    /**
     * register.
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        //validate incoming inputs
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'type' => 'user',
            'password' => Hash::make($request->password),
        ]);

        $userInfo = UserDetails::create([
            'user_id' => $user->id,
            'status' => 'active',
        ]);

        return $user;
    }


    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
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
