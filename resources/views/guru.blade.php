<x-layout>
<div class="container-fluid">
<canvas id="myAreaChart"></canvas>

<!-- Content Row -->
<div class="card shadow mb-4">
    <div class="card-body">

        <div class="d-flex justify-content-end">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#inputModal">
                Tambah Pengguna
            </button>
        </div>

        <div class="my-2"></div>

        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Pengguna</th>
                        <th>Role</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($user as $u)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $u->username }}</td>
                        <td>{{ $u->role->name ?? 'Tidak ada role' }}</td>
                        <td>
                            <form action="{{ route('pengguna.destroy', $u->id) }}" method="POST" class="delete-form d-inline">
                                <a class="btn btn-warning" href="{{ route('pengguna.edit', $u->id) }}">Edit</a>
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-delete">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    @push('scripts')
                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            const deleteButtons = document.querySelectorAll('.btn-delete');
                            deleteButtons.forEach(button => {
                                button.addEventListener('click', function (e) {
                                    const form = this.closest('form');

                                    Swal.fire({
                                        title: 'Anda yakin?',
                                        text: "Data yang dihapus tidak dapat dikembalikan!",
                                        icon: 'warning',
                                        showCancelButton: true,
                                        confirmButtonColor: '#d33',
                                        cancelButtonColor: '#6c757d',
                                        confirmButtonText: 'Ya, hapus!',
                                        cancelButtonText: 'Batal'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            form.submit();
                                        }
                                    });
                                });
                            });
                        });
                    </script>
                    @endpush
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>

<!-- Modal -->
<div class="modal fade" id="inputModal" tabindex="-1" aria-labelledby="inputModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('pengguna.store') }}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="inputModalLabel">Input Data Pengguna</h5>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="username" class="form-label">Nama Pengguna</label>
            <input type="text" class="form-control" id="username" name="username" required>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="text" class="form-control" id="password" name="password" required>
          </div>
          <div class="mb-3">
            <label for="id_role" class="form-label">Role</label>
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

</x-layout>
