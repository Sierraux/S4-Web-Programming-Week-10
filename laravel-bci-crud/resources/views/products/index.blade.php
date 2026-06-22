<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">
                    Manajemen Produk
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    Kelola data produk menggunakan Laravel CRUD.
                </p>
            </div>

            <a href="{{ route('products.create') }}"
               class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-lg transition hover:bg-indigo-700">
                + Tambah Produk
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-5 py-4 text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-6 rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-100">
                <form method="GET" action="{{ route('products.index') }}" class="flex flex-col gap-3 sm:flex-row">
                    <input type="text"
                           name="search"
                           value="{{ $search }}"
                           placeholder="Cari nama atau kategori produk..."
                           class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">

                    <button type="submit"
                            class="rounded-xl bg-gray-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-gray-700">
                        Cari
                    </button>

                    <a href="{{ route('products.index') }}"
                       class="rounded-xl bg-gray-100 px-5 py-3 text-center text-sm font-semibold text-gray-700 transition hover:bg-gray-200">
                        Reset
                    </a>
                </form>
            </div>

            <div class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-gray-100">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-500">No</th>
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Nama</th>
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Kategori</th>
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Stok</th>
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-500">Harga</th>
                                <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider text-gray-500">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100 bg-white">
                            @forelse ($products as $product)
                                <tr class="transition hover:bg-gray-50">
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ $loop->iteration + ($products->currentPage() - 1) * $products->perPage() }}
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="font-semibold text-gray-900">{{ $product->name }}</div>
                                        <div class="text-sm text-gray-500">
                                            {{ Str::limit($product->description, 45) }}
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        {{ $product->category ?? '-' }}
                                    </td>

                                    <td class="px-6 py-4">
                                        <span class="rounded-full bg-blue-50 px-3 py-1 text-sm font-semibold text-blue-700">
                                            {{ $product->stock }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 text-sm font-semibold text-gray-900">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </td>

                                    <td class="px-6 py-4 text-right">
                                        <div class="flex justify-end gap-2">
                                            <a href="{{ route('products.show', $product) }}"
                                               class="rounded-lg bg-gray-100 px-3 py-2 text-xs font-semibold text-gray-700 hover:bg-gray-200">
                                                Detail
                                            </a>

                                            <a href="{{ route('products.edit', $product) }}"
                                               class="rounded-lg bg-yellow-100 px-3 py-2 text-xs font-semibold text-yellow-700 hover:bg-yellow-200">
                                                Edit
                                            </a>

                                            <form action="{{ route('products.destroy', $product) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                        class="rounded-lg bg-red-100 px-3 py-2 text-xs font-semibold text-red-700 hover:bg-red-200">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                        Belum ada data produk.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="border-t border-gray-100 px-6 py-4">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>