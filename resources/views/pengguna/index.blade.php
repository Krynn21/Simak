<x-layout>
<div class="container-fluid">

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Tabel Data Pengguna</h1>

<!-- Card -->
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="d-flex justify-content-end mb-2">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#inputModal">
                Tambah Pengguna
            </button>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Role</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($user as $u)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ ucfirst($u->username) }}</td>
                            <td>{{ $u->role->name ?? 'Tidak ada role' }}</td>
                            <td>
                                <!-- Tombol Edit -->
                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $u->id }}">
                                    Edit
                                </button>

                                <!-- Tombol Hapus -->
                                <form action="{{ route('pengguna.destroy', $u->id) }}" method="POST" class="d-inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>

                        <!-- Modal Edit -->
                        <div class="modal fade" id="editModal{{ $u->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $u->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('pengguna.update', $u->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel{{ $u->id }}">Edit Data Pengguna</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">Nama Pengguna</label>
                                                <input type="text" class="form-control" name="username" value="{{ $u->username }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Password (kosongkan jika tidak ingin mengubah)</label>
                                                <input type="password" class="form-control" name="password">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Role</label>
                                                <select name="id_role" class="form-select" required>
                                                    <option value="">Pilih Role</option>
                                                    @foreach ($roles as $role)
                                                        <option value="{{ $role->id }}" {{ $u->id_role == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="inputModal" tabindex="-1" aria-labelledby="inputModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('pengguna.store') }}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="inputModalLabel">Input Data Pengguna</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Nama Pengguna</label>
            <input type="text" class="form-control" name="username" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="text" class="form-control" name="password" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Role</label>
            <select name="id_role" class="form-select" required>
              <option value="">Pilih Role</option>
              @foreach ($roles as $role)
                <option value="{{ $role->id }}">{{ $role->name }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

</div>
</x-layout>
