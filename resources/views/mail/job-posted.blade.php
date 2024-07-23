<x-mail::message>
    <h1>Thank you for using our stage : {{ $user->name }}</h1>
    <br>
    <p>
        Congrats Your job is now live on our website
    <h2 style=" font-size: 1.125rem; line-height: 1.75rem; text-transform: uppercase; color: rgb(99 102 241)">
        {{ $job->title }}
    </h2>
    </p>
    <br>
    <x-mail::button url="{{ url('/search', $job->name) }}">
        View
    </x-mail::button>
</x-mail::message>
