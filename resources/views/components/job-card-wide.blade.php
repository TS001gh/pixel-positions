@props(['job'])

<x-panel class="flex gap-x-6">
    <div>
        <x-employer-logo :employer="$job->employer" />
    </div>
    <div class="flex-1 flex flex-col">
        <a href="#" class="self-start text-sm text-gray-400">{{ $job->employer->name }}</a>

        <h3 class="font-bold text-xl mt-3 group-hover:text-secondary transition-colors duration-200">
            <a href="{{ $job->url }}" target="_blank">
                {{ $job->title }}
            </a>
        </h3>
        <p class="text-sm text-gray-400 mt-auto">{{ $job->salary }}</p>
    </div>

    <div class="space-x-2 flex items-start relative">
        @foreach ($job->tags as $tag)
            <x-tag :$tag />
        @endforeach

        @can('edit', $job)
            <span
                class="font-bold px-3 py-1 rounded-full border border-white/25 grid place-content-center cursor-pointer list">⁝</span>
            <ul
                class="absolute right-4 -top-24 -mt-2 translate-x-1/2 p-3 divide-y-2 text-start shadow-secondary/50 sr-only shadow-md bg-black rounded-lg transition-all duration-300">
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
</x-panel>
