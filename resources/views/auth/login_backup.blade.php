
<x-layouts.guest>

<div class="min-h-screen grid lg:grid-cols-2 bg-[#faf8f6]">

    {{-- PARTIE GAUCHE : UNIVERS DU SALON --}}
    <section class="relative hidden lg:block overflow-hidden">

        <img
            src="https://images.unsplash.com/photo-1600948836101-f9ffda59d250?w=1600&q=90"
            alt="Univers élégant du salon All in One by Eva"
            class="absolute inset-0 h-full w-full object-cover"
        >

        <div class="absolute inset-0 bg-gradient-to-t
                    from-[#290b15]/95 via-[#421522]/35 to-[#421522]/10">
        </div>

        <div class="relative z-10 flex h-full flex-col justify-between p-14">

            {{-- LOGO --}}
            <div>
                <div class="flex items-center gap-4">

                    <div class="flex h-14 w-14 items-center justify-center
                                rounded-2xl border border-white/30
                                bg-white/10 text-2xl text-[#e8c69c]">
                        ✧
                    </div>

                    <div>
                        <p class="text-xl font-semibold tracking-wide text-white"
                           style="font-family: 'Playfair Display', serif;">
                            All in One
                        </p>

                        <p class="text-[10px] uppercase tracking-[0.4em] text-[#e8c69c]">
                            BY EVA
                        </p>
                    </div>

                </div>
            </div>

            {{-- TEXTE DE PRESENTATION --}}
            <div class="max-w-xl pb-8">

                <div class="mb-6 flex items-center gap-3">
                    <span class="h-px w-12 bg-[#e8c69c]"></span>

                    <span class="text-xs font-semibold uppercase
                                 tracking-[0.35em] text-[#e8c69c]">
                        Beauté • Bien-être • Élégance
                    </span>
                </div>

                <h1 class="text-5xl font-semibold leading-tight text-white xl:text-6xl"
                    style="font-family: 'Playfair Display', serif;">

                    Révélez votre
                    <span class="mt-2 block italic text-[#e8c69c]">
                        élégance.
                    </span>

                </h1>

                <p class="mt-7 max-w-md text-base leading-8 text-white/80">
                    Un univers dédié à votre beauté, votre bien-être
                    et votre épanouissement. Chaque détail compte,
                    chaque instant mérite d'être exceptionnel.
                </p>

                <div class="mt-10 flex items-center gap-3">

                    <span class="h-1 w-12 rounded-full bg-[#e8c69c]"></span>
                    <span class="h-1 w-3 rounded-full bg-white/50"></span>
                    <span class="h-1 w-3 rounded-full bg-white/50"></span>

                </div>

            </div>

            <p class="text-xs tracking-wide text-white/60">
                L'élégance commence par une attention particulière.
            </p>

        </div>
    </section>


    {{-- PARTIE DROITE : CONNEXION --}}
    <section class="flex min-h-screen flex-col justify-center px-6 py-12 sm:px-12 lg:px-16 xl:px-24">

        <div class="mx-auto w-full max-w-md">

            {{-- LOGO MOBILE --}}
            <div class="mb-12 flex items-center justify-center gap-3 lg:hidden">

                <div class="flex h-12 w-12 items-center justify-center
                            rounded-xl bg-[#4a1725] text-2xl text-[#e8c69c]">
                    ✧
                </div>

                <div>
                    <p class="text-xl font-semibold text-[#421522]"
                       style="font-family: 'Playfair Display', serif;">
                        All in One
                    </p>

                    <p class="text-[10px] uppercase tracking-[0.35em] text-[#98705e]">
                        BY EVA
                    </p>
                </div>

            </div>


            {{-- EN-TETE --}}
            <div class="mb-10">

                <div class="mb-5 inline-flex items-center gap-2
                            rounded-full bg-[#f1e5e7] px-4 py-2">

                    <span class="h-2 w-2 rounded-full bg-[#7b3548]"></span>

                    <span class="text-[10px] font-bold uppercase
                                 tracking-[0.2em] text-[#642337]">
                        Espace professionnel
                    </span>

                </div>

                <h2 class="text-4xl font-semibold leading-tight text-[#421522] sm:text-5xl"
                    style="font-family: 'Playfair Display', serif;">
                    Heureuse de vous
                    <span class="italic text-[#8b4658]">retrouver.</span>
                </h2>

                <p class="mt-4 text-sm leading-7 text-stone-500">
                    Connectez-vous à votre espace de gestion
                    pour retrouver votre activité et prendre
                    soin de votre salon.
                </p>

            </div>


            {{-- MESSAGES D'ERREUR --}}
            @if ($errors->any())

                <div class="mb-6 rounded-xl border border-red-200
                            bg-red-50 p-4 text-sm text-red-700">

                    {{ $errors->first() }}

                </div>

            @endif


            {{-- FORMULAIRE --}}
            <form method="POST"
                  action="{{ route('login.store') }}"
                  class="space-y-6">

                @csrf

                {{-- EMAIL --}}
                <div>

                    <label for="email"
                           class="mb-2 block text-sm font-semibold text-[#421522]">
                        Adresse e-mail
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="exemple@email.com"
                        autocomplete="username"
                        required
                        autofocus
                        class="w-full rounded-xl border border-stone-200
                               bg-white px-5 py-4 text-sm text-stone-700
                               outline-none transition duration-300
                               placeholder:text-stone-400
                               focus:border-[#7b3548]
                               focus:ring-4 focus:ring-[#7b3548]/10"
                    >

                </div>


                {{-- MOT DE PASSE --}}
                <div>

                    <label for="password"
                           class="mb-2 block text-sm font-semibold text-[#421522]">
                        Mot de passe
                    </label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Entrez votre mot de passe"
                        autocomplete="current-password"
                        required
                        class="w-full rounded-xl border border-stone-200
                               bg-white px-5 py-4 text-sm text-stone-700
                               outline-none transition duration-300
                               placeholder:text-stone-400
                               focus:border-[#7b3548]
                               focus:ring-4 focus:ring-[#7b3548]/10"
                    >

                </div>


                {{-- BOUTON --}}
                <button
                    type="submit"
                    class="group flex w-full items-center justify-center
                           gap-3 rounded-xl bg-[#4a1725] px-6 py-4
                           text-sm font-semibold tracking-wide text-white
                           shadow-lg shadow-[#4a1725]/15
                           transition duration-300
                           hover:-translate-y-1 hover:bg-[#642337]
                           hover:shadow-xl"
                >

                    Se connecter

                    <span class="text-lg transition-transform
                                 group-hover:translate-x-1">
                        →
                    </span>

                </button>

            </form>


            {{-- PIED DE PAGE --}}
            <div class="mt-14 border-t border-stone-200 pt-7">

                <div class="flex items-center justify-center gap-2">

                    <span class="text-lg text-[#8b4658]">✧</span>

                    <p class="text-xs font-medium tracking-wide text-stone-500">
                        Espace privé et sécurisé
                    </p>

                </div>

                <p class="mt-4 text-center text-xs text-stone-400">
                    © {{ date('Y') }} All in One by Eva.
                    Tous droits réservés.
                </p>

            </div>

        </div>

    </section>

</div>

</x-layouts.guest>
