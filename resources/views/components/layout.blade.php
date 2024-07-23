<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pixel Positions</title>
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="px-10 bg-primary text-white font-hanken-grotesk pb-20">

    <div>
        <nav class="flex justify-between items-center py-4 border-b border-white/10">
            <div>
                <a href="/">
                    <img src="{{ Vite::asset('resources/images/logo.svg') }}" alt="">
                </a>
            </div>
            <div class="space-x-6 font-bold">
                <x-nav-link href="#">Jobs</x-nav-link>
                <x-nav-link href="#">Careers</x-nav-link>
                <x-nav-link href="#">Salaries</x-nav-link>
                <x-nav-link href="#">Companies</x-nav-link>



            </div>

            @auth
                <div class="space-x-6 font-bold flex items-center">
                    <x-nav-link href="/jobs/create">Post a Job</x-nav-link>

                    <form method="POST" action="/logout"
                        class="border border-secondary px-3 py-1 rounded-xl transition-all hover:ring-2 hover:ring-secondary">
                        @csrf
                        @method('DELETE')
                        <button>Log Out</button>
                    </form>
                </div>
            @endauth

            @guest
                <div class="space-x-6 font-bold">
                    <x-nav-link href="/register">Sign Up</x-nav-link>
                    <x-nav-link href="/login">Log In</x-nav-link>
                </div>
            @endguest


        </nav>


        <main class="mt-10 max-w-[986px] mx-auto">
            {{ $slot }}
        </main>

    </div>
</body>

</html>
