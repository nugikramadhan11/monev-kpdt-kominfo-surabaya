@extends('layouts.app')

@section('title', 'Admin Master Data')

@section('content')
<div class="max-w-7xl">
    <h1 class="text-3xl sm:text-4xl font-bold mb-8 text-gray-900">Master Data Management</h1>

    <!-- Tabs -->
    <div class="flex flex-wrap gap-2 sm:gap-4 mb-8 border-b border-gray-200 overflow-x-auto">
        <button onclick="showTab('users')" class="px-4 sm:px-6 py-3 border-b-2 border-blue-600 text-blue-600 font-semibold text-sm sm:text-base whitespace-nowrap">👥 Users</button>
        <button onclick="showTab('wilayah')" class="px-4 sm:px-6 py-3 text-gray-600 hover:text-gray-900 text-sm sm:text-base whitespace-nowrap">📍 Wilayah</button>
        <button onclick="showTab('pilar')" class="px-4 sm:px-6 py-3 text-gray-600 hover:text-gray-900 text-sm sm:text-base whitespace-nowrap">🏷️ Pilar</button>
        <button onclick="showTab('opd')" class="px-4 sm:px-6 py-3 text-gray-600 hover:text-gray-900 text-sm sm:text-base whitespace-nowrap">🏢 OPD</button>
    </div>

    <!-- Users Tab -->
    <div id="users-tab" class="tab-content">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8">
            <!-- User Form -->
            <div class="lg:col-span-1 bg-white p-6 sm:p-7 rounded-xl border border-gray-100 shadow-md">
                <h3 class="font-bold text-lg text-gray-900 mb-6">Tambah User</h3>
                <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="text" name="name" placeholder="Nama" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 text-sm">
                    <input type="email" name="email" placeholder="Email" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 text-sm">
                    <input type="text" name="nip" placeholder="NIP (optional)"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 text-sm">
                    <select name="role" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 text-sm">
                        <option value="">--Pilih Role--</option>
                        <option value="ASN">ASN</option>
                        <option value="PIMPINAN">PIMPINAN</option>
                        <option value="ADMIN">ADMIN</option>
                    </select>
                    <select name="wilayah_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 text-sm">
                        <option value="">--Pilih Wilayah--</option>
                        @foreach($wilayahs as $w)
                            <option value="{{ $w->id }}">{{ $w->name }}</option>
                        @endforeach
                    </select>
                    <input type="password" name="password" id="admin-password-input" placeholder="Password" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 text-sm pr-10">
                    <div class="relative -mt-10 mb-4">
                        <button type="button" id="admin-toggle-password" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700 focus:outline-none">
                            <svg id="admin-eye-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </button>
                    </div>
                    <button type="submit" class="w-full text-white py-3 rounded-lg font-semibold text-sm transition hover:opacity-90" style="background-color: #041beb;">
                        Tambah
                    </button>
                </form>
            </div>

            <!-- Users List -->
            <div class="lg:col-span-2 bg-white rounded-xl border border-gray-100 shadow-md overflow-hidden">
                <div class="p-6 sm:p-7 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-white">
                    <h3 class="font-bold text-lg text-gray-900">Daftar Users</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Nama</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Email</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Role</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($users as $user)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 text-sm text-gray-700">{{ $user->name }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-700">{{ $user->email }}</td>
                                    <td class="px-6 py-4 text-sm">
                                        <span class="px-3 py-1.5 bg-blue-100 text-blue-800 rounded-full text-xs font-medium">
                                            {{ $user->roles->first()?->name ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 text-xs hover:text-red-800 font-medium" onclick="return confirm('Yakin?')">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Wilayah Tab -->
    <div id="wilayah-tab" class="tab-content hidden">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6">
            <div class="lg:col-span-1 bg-white p-4 sm:p-6 rounded-lg border border-gray-200 shadow-sm">
                <h3 class="font-bold text-lg text-gray-900 mb-4">Tambah Wilayah</h3>
                <form action="{{ route('admin.wilayahs.store') }}" method="POST" class="space-y-3">
                    @csrf
                    <input type="text" name="name" placeholder="Nama Wilayah" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 text-sm">
                    <input type="text" name="code" placeholder="Kode" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 text-sm">
                    <button type="submit" class="w-full text-white py-2 rounded-lg font-semibold text-sm transition hover:opacity-90" style="background-color: #041beb;">
                        Tambah
                    </button>
                </form>
            </div>
            <div class="lg:col-span-2 bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
                <div class="p-4 sm:p-6 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-white">
                    <h3 class="font-bold text-lg text-gray-900">Daftar Wilayah</h3>
                </div>
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs sm:text-sm font-semibold text-gray-900">Nama</th>
                            <th class="px-4 py-3 text-left text-xs sm:text-sm font-semibold text-gray-900">Kode</th>
                            <th class="px-4 py-3 text-left text-xs sm:text-sm font-semibold text-gray-900">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($wilayahs as $w)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $w->name }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $w->code }}</td>
                                <td class="px-4 py-3 text-sm">
                                    <form action="{{ route('admin.wilayahs.destroy', $w) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 text-xs hover:text-red-800 font-medium" onclick="return confirm('Yakin?')">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pilar Tab -->
    <div id="pilar-tab" class="tab-content hidden">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6">
            <div class="lg:col-span-1 bg-white p-4 sm:p-6 rounded-lg border border-gray-200 shadow-sm">
                <h3 class="font-bold text-lg text-gray-900 mb-4">Tambah Pilar</h3>
                <form action="{{ route('admin.pilars.store') }}" method="POST" class="space-y-3">
                    @csrf
                    <input type="text" name="name" placeholder="Nama Pilar" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 text-sm">
                    <input type="text" name="hashtag" placeholder="Hashtag" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 text-sm">
                    <input type="color" name="color" value="#3b82f6" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm h-10 cursor-pointer">
                    <button type="submit" class="w-full text-white py-2 rounded-lg font-semibold text-sm transition hover:opacity-90" style="background-color: #041beb;">
                        Tambah
                    </button>
                </form>
            </div>
            <div class="lg:col-span-2 bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
                <div class="p-4 sm:p-6 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-white">
                    <h3 class="font-bold text-lg text-gray-900">Daftar Pilar</h3>
                </div>
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs sm:text-sm font-semibold text-gray-900">Nama</th>
                            <th class="px-4 py-3 text-left text-xs sm:text-sm font-semibold text-gray-900">Hashtag</th>
                            <th class="px-4 py-3 text-left text-xs sm:text-sm font-semibold text-gray-900">Color</th>
                            <th class="px-4 py-3 text-left text-xs sm:text-sm font-semibold text-gray-900">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($pilars as $p)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $p->name }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $p->hashtag }}</td>
                                <td class="px-4 py-3 text-sm">
                                    <div class="w-8 h-8 rounded-lg border border-gray-300" style="background-color: {{ $p->color }}"></div>
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    <form action="{{ route('admin.pilars.destroy', $p) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 text-xs hover:text-red-800 font-medium" onclick="return confirm('Yakin?')">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- OPD Tab -->
    <div id="opd-tab" class="tab-content hidden">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6">
            <div class="lg:col-span-1 bg-white p-4 sm:p-6 rounded-lg border border-gray-200 shadow-sm">
                <h3 class="font-bold text-lg text-gray-900 mb-4">Tambah OPD</h3>
                <form action="{{ route('admin.opds.store') }}" method="POST" class="space-y-3">
                    @csrf
                    <input type="text" name="name" placeholder="Nama OPD" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 text-sm">
                    <input type="text" name="kode" placeholder="Kode OPD" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 text-sm">
                    <select name="wilayah_id" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 text-sm">
                        <option value="">--Pilih Wilayah--</option>
                        @foreach($wilayahs as $w)
                            <option value="{{ $w->id }}">{{ $w->name }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="w-full text-white py-2 rounded-lg font-semibold text-sm transition hover:opacity-90" style="background-color: #041beb;">
                        Tambah
                    </button>
                </form>
            </div>
            <div class="lg:col-span-2 bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
                <div class="p-4 sm:p-6 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-white">
                    <h3 class="font-bold text-lg text-gray-900">Daftar OPD</h3>
                </div>
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs sm:text-sm font-semibold text-gray-900">Nama</th>
                            <th class="px-4 py-3 text-left text-xs sm:text-sm font-semibold text-gray-900">Kode</th>
                            <th class="px-4 py-3 text-left text-xs sm:text-sm font-semibold text-gray-900">Wilayah</th>
                            <th class="px-4 py-3 text-left text-xs sm:text-sm font-semibold text-gray-900">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($opds as $o)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $o->name }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $o->kode }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $o->wilayah->name }}</td>
                                <td class="px-4 py-3 text-sm">
                                    <form action="{{ route('admin.opds.destroy', $o) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 text-xs hover:text-red-800 font-medium" onclick="return confirm('Yakin?')">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
function showTab(tabName) {
    // Hide all tabs
    document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
    // Show selected tab
    document.getElementById(tabName + '-tab').classList.remove('hidden');
    
    // Update button styles
    document.querySelectorAll('.border-b-2').forEach(el => {
        el.classList.remove('border-b-2', 'border-blue-600', 'text-blue-600');
        el.classList.add('text-gray-600', 'hover:text-gray-900');
    });
    event.target.classList.add('border-b-2', 'border-blue-600', 'text-blue-600');
    event.target.classList.remove('text-gray-600', 'hover:text-gray-900');
}

// Toggle password visibility for admin form
const adminTogglePasswordBtn = document.getElementById('admin-toggle-password');
const adminPasswordInput = document.getElementById('admin-password-input');
const adminEyeIcon = document.getElementById('admin-eye-icon');

if (adminTogglePasswordBtn) {
    adminTogglePasswordBtn.addEventListener('click', (e) => {
        e.preventDefault();
        
        if (adminPasswordInput.type === 'password') {
            adminPasswordInput.type = 'text';
            adminEyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-4.432m5.604-1.406a3.001 3.001 0 003.093 3.093 3.001 3.001 0 00-3.093-3.093zM15 12a3 3 0 11-6 0 3 3 0 016 0zm6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>';
        } else {
            adminPasswordInput.type = 'password';
            adminEyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>';
        }
    });
}
</script>
@endsection
