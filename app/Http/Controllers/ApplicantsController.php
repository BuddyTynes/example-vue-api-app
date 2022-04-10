<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreApplicantsRequest;
use App\Http\Requests\UpdateApplicantsRequest;
use Illuminate\Http\Request;
use App\Models\Applicants;
use App\Http\Resources\ApplicantResource;

class ApplicantsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Return a list of applicants.
        return ApplicantResource::collection(Applicants::with('skills')->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreApplicantsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreApplicantsRequest $request)
    {
        // Create a new applicant.
        $applicant = Applicants::create($request->all());
        return response()->json($applicant, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Applicants  $applicants
     * @return \Illuminate\Http\Response
     */
    public function show(Applicants $applicants)
    {
        // Return a single applicant.
        return response()->json($applicants);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateApplicantsRequest  $request
     * @param  \App\Models\Applicants  $applicants
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateApplicantsRequest $request, Applicants $applicant)
    {
        // Update an existing applicant.
        $applicant->update($request->all());
        return response()->json($applicant, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Applicants  $applicants
     * @return \Illuminate\Http\Response
     */
    public function destroy(Applicants $applicant)
    {
        // Delete an existing applicant.
        $applicant->delete();
        return response('Deleted Successfully', 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Applicants  $applicants
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        // Search for applicants.
        $applicants = Applicants::where('first_name', 'like', '%' . $request->input('query') . '%')
            ->orWhere('last_name', 'like', '%' . $request->input('query') . '%')
            ->orWhere('email', 'like', '%' . $request->input('query') . '%')
            ->get();
        return response()->json($applicants, 200);
    }
}
