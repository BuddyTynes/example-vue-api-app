<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreApplicantsRequest;
use App\Http\Requests\UpdateApplicantsRequest;
use Illuminate\Http\Request;
use App\Models\Applicants;
use App\Models\ApplicantSkill;
use App\Http\Resources\ApplicantResource;
use Illuminate\Support\Facades\Log;

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
        return ApplicantResource::collection(Applicants::with('skills')->paginate(5));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreApplicantsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreApplicantsRequest $request)
    {
        // TODO finish validation

        // Create a new applicant.
        $applicant = Applicants::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'status' => 'pending',
        ]);
        
        // Create applicants skills
        foreach($request->skills as $key => $skill) {
            ApplicantSkill::create([
                'applicant_id' => $applicant->id,
                'skill_id' => $skill,
            ]);
        }

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
        if($request->input('q') != '') {
            $applicants = Applicants::with('skills')->where('first_name', 'LIKE', '%' . $request->input('q') . '%')
                ->orWhere('last_name', 'LIKE', '%' . $request->input('q') . '%')
                ->orWhere('status', 'LIKE', '%' . $request->input('q') . '%')
                ->get();
        } else {
            $applicants = Applicants::with('skills')->get();
        }

        return response()->json(ApplicantResource::collection($applicants), 200);
    }
}
