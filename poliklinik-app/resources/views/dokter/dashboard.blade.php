<x-layouts.app title="Dokter Dashboard">
    <div class="px-4 py-8 max-w-7xl mx-auto space-y-8">
        
        {{-- Banner Section --}}
        <div class="relative bg-gradient-to-r from-blue-600 to-blue-400 rounded-3xl shadow-lg overflow-hidden text-white w-full flex items-center lg:h-[260px]">
            {{-- Abstract Pattern overlay --}}
            <div class="absolute inset-0 opacity-10 pointer-events-none mix-blend-overlay bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI0MCIgaGVpZ2h0PSI0MCI+PHBhdGggZD0iTTIwIDIwTDAgMFY0MHpNMjAgMjBMMTQwIDBWMDB6IiBmaWxsPSIjRkZGIiBmaWxsLW9wYWNpdHk9IjAuMSIvPjwvc3ZnPg==')]"></div>
            
            <div class="relative z-10 p-8 w-full lg:w-2/3">
                <p class="text-blue-100 text-lg sm:text-xl font-medium mb-1 drop-shadow-sm">Welcome,</p>
                <h1 class="text-3xl md:text-5xl font-extrabold mb-8 drop-shadow-md">Dr. {{ $user->nama }}</h1>
                
                <p class="text-sm font-medium text-blue-100 mb-4 drop-shadow-sm">Your schedule today</p>
                
                <div class="flex flex-wrap gap-4">
                    {{-- Small Info Pill 1 --}}
                    <div class="bg-white/20 backdrop-blur-md rounded-2xl px-5 py-3 flex items-center gap-4 transform transition hover:scale-105 border border-white/10 hover:bg-white/30">
                        <div class="bg-[#2dd4bf]/90 p-2.5 rounded-xl text-white shadow-sm flex items-center justify-center">
                            <i class="fas fa-users fa-lg"></i>
                        </div>
                        <div>
                            <p class="text-2xl font-bold leading-none tracking-tight">{{ $totalPasien }}</p>
                            <p class="text-xs font-medium text-blue-50 tracking-wide mt-1">Patients</p>
                        </div>
                    </div>

                    {{-- Small Info Pill 2 --}}
                    <div class="bg-white/20 backdrop-blur-md rounded-2xl px-5 py-3 flex items-center gap-4 transform transition hover:scale-105 border border-white/10 hover:bg-white/30">
                        <div class="bg-[#fbbf24]/90 p-2.5 rounded-xl text-white shadow-sm flex items-center justify-center">
                            <i class="fas fa-calendar-check fa-lg"></i>
                        </div>
                        <div>
                            <p class="text-2xl font-bold leading-none tracking-tight">{{ $jadwalAktif }}</p>
                            <p class="text-xs font-medium text-blue-50 tracking-wide mt-1">Schedules</p>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- Vetctor artwork placeholder logic mimicking the patient+doc art --}}
            <div class="hidden lg:flex w-1/3 h-full items-end justify-center relative pointer-events-none">
                <div class="absolute -bottom-6 flex items-end">
                    {{-- Icon acting as illustration, with large shadow --}}
                    <i class="fas fa-user-md text-[180px] text-white/20 drop-shadow-2xl translate-x-12"></i>
                    <i class="fas fa-stethoscope text-[220px] text-white/30 drop-shadow-2xl"></i>
                </div>
            </div>
        </div>

        {{-- Statistics Cards Section --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Card 1 --}}
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex flex-col pt-8 relative overflow-hidden group hover:shadow-md transition">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-blue-50 rounded-full opacity-50 group-hover:scale-150 transition-transform duration-500 pointer-events-none"></div>
                <div class="flex items-center gap-5 relative z-10">
                    <div class="w-16 h-16 rounded-2xl bg-blue-50 text-blue-500 flex items-center justify-center text-3xl shadow-sm border border-blue-100">
                        <i class="fas fa-users"></i>
                    </div>
                    <div>
                        <h3 class="text-4xl font-bold text-slate-800">{{ $totalPasien }}</h3>
                        <p class="text-slate-500 font-medium tracking-wide mt-1">Total Pasien</p>
                    </div>
                </div>
            </div>

            {{-- Card 2 --}}
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex flex-col pt-8 relative overflow-hidden group hover:shadow-md transition">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-emerald-50 rounded-full opacity-50 group-hover:scale-150 transition-transform duration-500 pointer-events-none"></div>
                <div class="flex items-center gap-5 relative z-10">
                    <div class="w-16 h-16 rounded-2xl bg-emerald-50 text-emerald-500 flex items-center justify-center text-3xl shadow-sm border border-emerald-100">
                        <i class="fas fa-file-medical-alt"></i>
                    </div>
                    <div>
                        <h3 class="text-4xl font-bold text-slate-800">{{ $sudahDiperiksa }}</h3>
                        <p class="text-slate-500 font-medium tracking-wide mt-1">Sudah Diperiksa</p>
                    </div>
                </div>
            </div>

            {{-- Card 3 --}}
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex flex-col pt-8 relative overflow-hidden group hover:shadow-md transition">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-rose-50 rounded-full opacity-50 group-hover:scale-150 transition-transform duration-500 pointer-events-none"></div>
                <div class="flex items-center gap-5 relative z-10">
                    <div class="w-16 h-16 rounded-2xl bg-rose-50 text-rose-500 flex items-center justify-center text-3xl shadow-sm border border-rose-100">
                        <i class="fas fa-procedures"></i>
                    </div>
                    <div>
                        <h3 class="text-4xl font-bold text-slate-800">{{ $belumDiperiksa }}</h3>
                        <p class="text-slate-500 font-medium tracking-wide mt-1">Belum Diperiksa</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-layouts.app>