
<x-layouts.guest>

<div class="min-h-screen flex bg-white">

    {{-- PARTIE GAUCHE : IDENTITÉ DU SALON --}}
    <section class="relative hidden lg:flex lg:w-1/2 flex-col justify-between overflow-hidden bg-[#35101d] p-14">

        <div class="absolute -right-32 -top-32 h-96 w-96 rounded-full border border-white/10"></div>
        <div class="absolute -bottom-40 -left-32 h-96 w-96 rounded-full border border-white/10"></div>

        <div class="relative z-10">
            <p class="text-3xl font-semibold tracking-wide text-white"
               style="font-family: 'Playfair Display', serif;">
                All in One
            </p>
            <p class="mt-1 text-xs uppercase tracking-[0.5em] text-[#d6b18a]">
                BY EVA
            </p>
        </div>

        <div class="relative z-10 max-w-lg">

            <span class="text-xs font-semibold uppercase tracking-[0.35em] text-[#d6b18a]">
                Bienvenue dans notre univers
            </span>

            <h1 class="mt-7 text-5xl font-semibold leading-tight text-white xl:text-6xl"
                style="font-family: 'Playfair Display', serif;">
                L'excellence dans chaque
                <span class="italic text-[#d6b18a]">détail.</span>
            </h1>

            <p class="mt-7 max-w-md text-base leading-8 text-white/70">
                Gérez votre salon en toute simplicité.
                Retrouvez vos clients, vos rendez-vous
                et votre activité depuis un espace unique.
            </p>

            <div class="mt-10 h-px w-20 bg-[#d6b18a]"></div>

            <p class="mt-5 text-sm tracking-wide text-white/60">
                All in One by Eva — Votre espace de gestion.
            </p>
        </div>

        <p class="relative z-10 text-xs text-white/40">
            © {{ date('Y') }} All in One by Eva. Tous droits réservés.
        </p>

    </section>


    {{-- PARTIE DROITE : FORMULAIRE --}}
    <section class="flex min-h-screen w-full items-center justify-center px-6 py-12 lg:w-1/2 sm:px-12">

        <div class="w-full max-w-md">

            {{-- IDENTITÉ MOBILE --}}
            <div class="mb-14 lg:hidden">
                <p class="text-3xl font-semibold text-[#35101d]"
                   style="font-family: 'Playfair Display', serif;">
                    All in One
                </p>
                <p class="mt-1 text-xs uppercase tracking-[0.4em] text-[#987080]">
                    BY EVA
                </p>
            </div>

            {{-- EN-TÊTE --}}
            <div class="mb-10">

                <div class="mb-6 flex items-center gap-3">
                    <span class="h-px w-10 bg-[#8b4658]"></span>
                    <span class="text-xs font-bold uppercase tracking-[0.25em] text-[#8b4658]">
                        Espace administration
                    </span>
                </div>

                <h2 class="text-4xl font-semibold leading-tight text-[#35101d] sm:text-5xl"
                    style="font-family: 'Playfair Display', serif;">
                    Bienvenue
                    <span class="block italic text-[#8b4658]">
                        chez vous.
                    </span>
                </h2>

                <p class="mt-5 text-sm leading-7 text-stone-500">
                    Accédez à votre espace personnel pour piloter
                    votre activité et retrouver toutes vos informations.
                </p>

            </div>


            {{-- ERREURS --}}
            @if ($errors->any())
                <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-700">
                    {{ $errors->first() }}
                </div>
            @endif


            {{-- FORMULAIRE DE CONNEXION --}}
            <form method="POST" action="{{ route('login.store') }}" class="space-y-6">

                @csrf

                {{-- EMAIL --}}
                <div>
                    <label for="email" class="mb-3 block text-sm font-semibold text-[#35101d]">
                        Adresse e-mail
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="Votre adresse e-mail"
                        autocomplete="username"
                        required
                        autofocus
                        class="w-full rounded-xl border border-stone-200 bg-[#faf9f8] px-5 py-4 text-sm text-[#35101d] outline-none transition focus:border-[#6b263a] focus:bg-white focus:ring-4 focus:ring-[#6b263a]/10"
                    >
                </div>


                {{-- MOT DE PASSE --}}
                <div>
                    <label for="password" class="mb-3 block text-sm font-semibold text-[#35101d]">
                        Mot de passe
                    </label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Votre mot de passe"
                        autocomplete="current-password"
                        required
                        class="w-full rounded-xl border border-stone-200 bg-[#faf9f8] px-5 py-4 text-sm text-[#35101d] outline-none transition focus:border-[#6b263a] focus:bg-white focus:ring-4 focus:ring-[#6b263a]/10"
                    >
                </div>


                {{-- BOUTON --}}
                <button
                    type="submit"
                    class="group flex w-full items-center justify-center gap-3 rounded-xl bg-[#4a1728] px-6 py-4 text-sm font-semibold tracking-wide text-white shadow-lg shadow-[#4a1728]/15 transition hover:-translate-y-0.5 hover:bg-[#35101d] hover:shadow-xl"
                >
                    Accéder à mon espace

                    <span class="text-lg transition-transform group-hover:translate-x-1">
                        →
                    </span>
                </button>

            </form>


            {{-- PIED DE PAGE --}}
            <div class="mt-14 border-t border-stone-200 pt-7">

                <p class="text-center text-xs leading-6 text-stone-400">
                    Cet espace est réservé au personnel autorisé.
                </p>

                <p class="mt-3 text-center text-xs text-stone-400">
                    © {{ date('Y') }} All in One by Eva
                </p>

            </div>

        </div>

    </section>

</div>

</x-layouts.guest>
