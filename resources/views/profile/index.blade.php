<x-layout>
    <div class="container mt-4">
        <h2>Profil Saya</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            <div class="mb-3">
                <label>Username</label>
                <input type="text" name="username" value="{{ old('username', $user->username) }}" class="form-control">
                @error('username') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            {{-- Jika kamu ingin menampilkan role user --}}
            <div class="mb-3">
                <label>Role ID</label>
                <input type="text" value="{{ $user->id_role }}" class="form-control" disabled>
            </div>

            {{-- Kalau kamu ingin tambahkan ubah password di halaman ini, beri kolom tambahan --}}
            {{-- <div class="mb-3">
                <label>Password Baru</label>
                <input type="password" name="password" class="form-control">
                @error('password') <small class="text-danger">{{ $message }}</small> @enderror
            </div> --}}

            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</x-layout>
