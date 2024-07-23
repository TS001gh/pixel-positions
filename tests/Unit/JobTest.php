<?php

use App\Models\Employer;
use App\Models\Job;

it('it belongs to an employer', function () {

    // Arrange

    $employer = Employer::factory()->create();
    $job = Job::factory()->create([
        // override the employer inside the job factory
        'employer_id' => $employer->id
    ]);

    // Act and Assert
    expect($job->employer->is($employer))->toBeTrue();
});


it('can have tags', function () {
    $job = Job::factory()->create();

    $job->tag('Frontend');

    expect($job->tags)->toHaveCount(1);
});
