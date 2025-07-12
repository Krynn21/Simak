<x-layout>
<div class="container-fluid">

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Tabel data Mata Pelajaran</h1>

<!-- Content Row -->
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="d-flex justify-content-end">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#inputModal">Tambah Data</button>
        </div>
        <div class="my-2"></div>
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Mata Pelajaran</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($mapel as $index => $m)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $m->nama_mapel }}</td>
                        <td>
                            <!-- Tombol Edit Modal -->
                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $m->id }}">
                                Edit
                            </button>

                            <!-- Modal Edit Mata Pelajaran -->
                            <div class="modal fade" id="editModal{{ $m->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $m->id }}" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <form action="{{ route('mapel.update', $m->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="editModalLabel{{ $m->id }}">Edit Mata Pelajaran</h5>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                    </div>
                                    <div class="modal-body">
                                      <div class="mb-3">
                                        <label for="nama_mapel_{{ $m->id }}" class="form-label">Nama Mata Pelajaran</label>
                                        <input type="text" class="form-control" id="nama_mapel_{{ $m->id }}" name="nama_mapel" value="{{ $m->nama_mapel }}" required>
                                      </div>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                      <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                  </form>
                                </div>
                              </div>
                            </div>
                            
                            <form action="{{ route('mapel.destroy', $m->id) }}" method="POST" class="d-inline delete-form">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
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

<!-- Modal Tambah Data -->
<div class="modal fade" id="inputModal" tabindex="-1" aria-labelledby="inputModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('mapel.store') }}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="inputModalLabel">Input Data Mata Pelajaran</h5>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="nama_mapel" class="form-label">Nama Mata Pelajaran</label>
            <input type="text" class="form-control" id="nama_mapel" name="nama_mapel" required>
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