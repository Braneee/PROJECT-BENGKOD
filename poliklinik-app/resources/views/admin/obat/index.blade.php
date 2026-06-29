<x-layouts.app title="Data Obat">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-slate-800">
            Data Obat
        </h2>

        <a href="{{ route('obat.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 
                  bg-primary hover:bg-primary/90 
                  text-white text-sm font-semibold 
                  rounded-xl transition">
            <i class="fas fa-plus text-xs"></i>
            Tambah Obat
        </a>
    </div>

    {{-- Search Bar --}}
    <div class="mb-6 flex justify-end">
        <form action="{{ route('obat.index') }}" method="GET" class="w-full max-w-sm">
            <div class="relative">
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Cari obat, golongan, distributor..." 
                       class="w-full pl-4 pr-10 py-2.5 border-2 rounded-xl focus:border-primary focus:outline-none text-sm text-slate-700">
                <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-primary transition">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>
    </div>

    {{-- Card --}}
    <div class="card bg-base-100 shadow-md rounded-2 border">
        <div class="card-body p-0">

            <div class="overflow-x-auto">
                <table class="table w-full">

                    {{-- Table Head --}}
                    <thead class="bg-slate-50 text-slate-500 uppercase text-xs tracking-wider">
                        <tr>
                            <th class="px-6 py-4">Nama Obat</th>
                            <th class="px-6 py-4">Kemasan</th>
                            <th class="px-6 py-4">Harga</th>
                             <th class="px-6 py-4">Expired</th>
                             <th class="px-6 py-4">Golongan</th>
                             <th class="px-6 py-4">Stok</th>
                             <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>

                    {{-- Table Body --}}
                    <tbody class="text-sm text-slate-700">
                        @forelse($obats as $obat)
                        <tr class="border-t border-slate-100 hover:bg-slate-50 transition">

                            <td class="px-6 py-4 font-semibold text-slate-800">
                                {{ $obat->nama_obat }}
                            </td>

                            <td class="px-6 py-4">
                                <span class="inline-block px-3 py-1 text-xs font-semibold 
                                             rounded-full bg-green-100 text-green-600">
                                    {{ $obat->kemasan ?? '-' }}
                                </span>
                            </td>

                            <td class="px-6 py-4 font-semibold text-slate-800">
                                Rp {{ number_format($obat->harga, 0, ',', '.') }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $obat->expired ? \Carbon\Carbon::parse($obat->expired)->format('d-M-Y') : '-' }}
                            </td>

                            <td class="px-6 py-4">
                                <span class="inline-block px-3 py-1 text-xs font-semibold 
                                             rounded-full bg-blue-100 text-blue-600">
                                    {{ $obat->golongan_obat ?? '-' }}
                                </span>
                            </td>

                            <td class="px-6 py-4">
                                @if($obat->stok == 0)
                                    <span class="inline-block px-3 py-1 text-xs font-bold rounded-full bg-red-50 text-red-500 border border-red-200">
                                        <i class="fas fa-exclamation-triangle"></i> Habis
                                    </span>
                                @elseif($obat->stok < 10)
                                    <span class="inline-block px-3 py-1 text-xs font-bold rounded-full bg-amber-50 text-amber-600 border border-amber-200">
                                        <i class="fas fa-warning"></i> Menipis ({{ $obat->stok }})
                                    </span>
                                @else
                                    <span class="inline-block px-3 py-1 text-xs font-bold rounded-full bg-emerald-50 text-emerald-600 border border-emerald-200">
                                        <i class="fas fa-check"></i> Tersedia ({{ $obat->stok }})
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2">

                                    {{-- Edit --}}
                                    <a href="{{ route('obat.edit', $obat->id) }}" class="inline-flex items-center gap-1 px-4 py-2 
                                              bg-amber-500 hover:bg-amber-600 
                                              text-white text-xs font-semibold 
                                              rounded-lg transition">
                                        <i class="fas fa-pen text-xs"></i>
                                        Edit
                                    </a>

                                    {{-- Delete --}}
                                    <form action="{{ route('obat.destroy', $obat->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                            onclick="return confirm('Yakin ingin menghapus obat ini?')" class="inline-flex items-center gap-1 px-4 py-2 
                                                   bg-red-500 hover:bg-red-600 
                                                   text-white text-xs font-semibold 
                                                   rounded-lg transition">
                                            <i class="fas fa-trash text-xs"></i>
                                            Hapus
                                        </button>
                                    </form>

                                </div>
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-12 text-slate-400">
                                <i class="fas fa-inbox text-3xl mb-3 block"></i>
                                Belum ada data obat
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

            {{-- Pagination --}}
            @if(method_exists($obats, 'hasPages') && $obats->hasPages())
                <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
                    {{ $obats->appends(request()->query())->links() }}
                </div>
            @endif

        </div>
    </div>

</x-layouts.app>