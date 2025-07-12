<x-layout>
<div class="container-fluid">

<h1 class="h3 mb-2 text-gray-800">Tabel data kelas</h1>

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
                        <th>Kelas</th>
                        <th>Tingkat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kelas as $index => $k)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $k->nama_kelas }}</td>
                        <td>{{ ucfirst($k->tingkat) }}</td>
                        <td>
                            <!-- Tombol Edit trigger modal -->
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $k->id }}">Edit</button>

                            <!-- Modal Edit -->
                            <div class="modal fade" id="editModal{{ $k->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $k->id }}" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <form action="{{ route('kelas.update', $k->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="editModalLabel{{ $k->id }}">Edit Kelas</h5>
                                      <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                      <div class="mb-3">
                                        <label for="nama_kelas{{ $k->id }}" class="form-label">Kelas Berapa</label>
                                        <input type="text" class="form-control" id="nama_kelas{{ $k->id }}" name="nama_kelas" value="{{ $k->nama_kelas }}" required>
                                      </div>
                                      <div class="mb-3">
                                        <label for="tingkat{{ $k->id }}" class="form-label">Tingkat</label>
                                        <select class="form-control" id="tingkat{{ $k->id }}" name="tingkat" required>
                                          <option value="">-- Pilih Tingkat --</option>
                                          @foreach($tingkats as $tingkat)
                                            <option value="{{ $tingkat }}" {{ $k->tingkat === $tingkat ? 'selected' : '' }}>{{ ucfirst($tingkat) }}</option>
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

                            <!-- Form Hapus -->
                            <form action="{{ route('kelas.destroy', $k->id) }}" method="POST" class="d-inline delete-form">
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
      <form action="{{ route('kelas.store') }}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="inputModalLabel">Input Data Kelas</h5>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="nama_kelas" class="form-label">Kelas Berapa</label>
            <input type="text" class="form-control" id="nama_kelas" name="nama_kelas" required>
          </div>
          <div class="mb-3">
            <label for="tingkat" class="form-label">Tingkat</label>
            <select class="form-control" id="tingkat" name="tingkat" required>
              <option value="">-- Pilih Tingkat --</option>
              @foreach($tingkats as $tingkat)
                <option value="{{ $tingkat }}">{{ ucfirst($tingkat) }}</option>
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
