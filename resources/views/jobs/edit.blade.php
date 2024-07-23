@props(['job'])

@php
    $tags = [];

    foreach ($job->tags as $tag) {
        $tags[] = $tag['name'];
    }
    $tags = implode(', ', $tags);

@endphp
<x-layout>
    <x-page-heading>
        Edit This Job
    </x-page-heading>


    <x-forms.form method="POST" action="/jobs/{{ $job->id }}">
        @csrf
        @method('PATCH')
        <x-forms.input label="Title" name="title" value="{{ $job->title }}" placeholder="CEO" />
        <x-forms.input label="Salary" name="salary" value="{{ $job->salary }}" placeholder="$90,000 USD" />
        <x-forms.input label="Location" name="location" value="{{ $job->location }}"
            placeholder="Winter Park, Florida" />

        <x-forms.select label="Schedule" name="schedule" value="{{ $job->schedule }}">
            <option value="Part Time">Part Time</option>
            <option value="Full Time">Full Time</option>
        </x-forms.select>

        <x-forms.input label="URL" name="url" value="{{ $job->url }}"
            placeholder="https://acme.com/jobs/ceo-wanted" />

        <x-forms.checkbox label="Featured (Costs Extra)" name="featured" value="{{ $job->featured }}"
            checked="{{ $job->featured === 1 }}" />

        <x-forms.divider />

        <x-forms.input label="Tags (coma separated)" name="tags" value="{{ $tags }}"
            placeholder="laracasts, video, education" />


        <x-forms.button>Update</x-forms.button>

    </x-forms.form>
</x-layout>
