<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Http\Requests\StoreJobRequest;
use App\Http\Requests\UpdateJobRequest;
use App\Mail\JobPosted;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jobs = Job::latest('updated_at')->with(['employer', 'tags'])->get()->groupBy('featured');

        return view('jobs.index', [
            'featuredJobs' => $jobs[1],
            'jobs' => $jobs[0],
            'tags' => Tag::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('jobs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $attributes = $request->validate([
            'title' => ['required'],
            'salary' => ['required'],
            'location' => ['required'],
            'schedule' => ['required', Rule::in(['Part Time', 'Full Time'])],
            'url' => ['required', 'active_url'],
            'tags'  => ['nullable']
        ]);
        // that will true or false depending whether the request has a value for that featured checkbox
        // remember, if that input isn't checked , There is nothing gets passed
        // if that input is checked it's set to on
        $attributes['featured'] = $request->has('featured');

        $job = Auth::user()->employer->jobs()->create(Arr::except($attributes, 'tags'));


        // if we don't have anything there, let's just assume false
        if ($attributes['tags'] ?? false) {
            foreach (explode(',', $attributes['tags']) as $tag) {
                // laravel,backend,frontend ['laravel']
                $job->tag($tag);
            }
        }



        // send adding job email
        // $user
        Mail::to(Auth::user())->queue(
            new JobPosted(Auth::user(), $job)
        );

        return redirect('/');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {

        $jobs = Job::query()
            ->with(['employer', 'tags'])
            ->where('id', $request->id)
            ->get();

        return view('results', ['jobs' => $jobs]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Job $job)
    {
        //

        return view('jobs.edit', [
            'job' => $job
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Job $job)
    {
        //

        $attributes = $request->validate([
            'title' => ['required'],
            'salary' => ['required'],
            'location' => ['required'],
            'schedule' => ['required', Rule::in(['Part Time', 'Full Time'])],
            'url' => ['required', 'active_url'],
            'tags'  => ['nullable']
        ]);
        // that will true or false depending whether the request has a value for that featured checkbox
        // remember, if that input isn't checked , There is nothing gets passed
        // if that input is checked it's set to on
        $attributes['featured'] = $request->has('featured');

        $job->update(Arr::except($attributes, 'tags'));

        // Retrieve existing tags
        $existingTags = $job->tags->pluck('name')->toArray();

        // Convert tags from request to an array
        $tags = $attributes['tags'] ? array_map('trim', explode(',', $attributes['tags'])) : [];


        $tags = array_unique($tags);

        // Detach tags that are no longer in the new request
        // $tagsToDetach = array_diff($existingTags, $newTags);
        if (!empty($existingTags)) {
            $job->tags()->detach(
                Tag::whereIn('name', $existingTags)->pluck('id')->toArray()
            );
        }

        // Attach new tags
        foreach ($tags as $tag) {
            $job->tag($tag);
        }


        return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Job $job)
    {
        //
        $job->delete();
        return redirect('/');
    }
}
