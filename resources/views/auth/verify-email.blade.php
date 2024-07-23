<x-layout>

    <section class="flex flex-col space-y-6 border border-white/50">
        <h1 class="mb-4">Please verify your email through the email we've sent you</h1>
        <p>Didn't get the email?</p>


        <form action="{{ route('verification.send') }}" method="POST">
            @csrf
            <button class="btn">Send again</button>
        </form>
    </section>

</x-layout>
