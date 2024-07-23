@props(['job'])


<x-panel class="flex flex-col text-center">

    <div class="self-start relative text-sm flex w-full justify-between items-center">
        <span>{{ $job->employer->name }}</span>
        @can('edit', $job)
            <span
                class="font-bold px-3 py-1 rounded-full border border-white/25 grid place-content-center cursor-pointer list">⁝</span>
            <ul
                class="absolute right-0 -top-24 translate-x-1/2 mr-4 p-3 divide-y-2 text-start shadow-secondary/50 sr-only shadow-md bg-black rounded-lg transition-all duration-300">
                <li class="hover:cursor-pointer mb-2 pt-2 hover:font-extrabold transition-all"><a
                        href="/jobs/edit/{{ $job->id }}">Edit</a></li>
                <li class="hover:cursor-pointer pt-2 text-rose-500 hover:font-extrabold transition-all">
                    <form action="/jobs/{{ $job->id }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn-delete">Delete</button>
                    </form>
                </li>
            </ul>
        @endcan
    </div>

    <div class="py-8">
        <h3 class="group-hover:text-secondary transition-colors duration-200 text-xl font-bold">
            <a href="{{ $job->url }}" target="_blank">
                {{ $job->title }}
            </a>
        </h3>
        <p class="text-xs mt-4">{{ $job->salary }}</p>
    </div>

    <div class="flex justify-between items-center mt-auto">
        <div class="space-x-1">

            @foreach ($job->tags as $tag)
                <x-tag :$tag size="small" />
            @endforeach
        </div>
        <x-employer-logo :employer="$job->employer" :width="42" />
    </div>
</x-panel>
