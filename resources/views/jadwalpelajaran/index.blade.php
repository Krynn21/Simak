<x-layout>
<div class="container-fluid">

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Tabel data Jadwal Pelajaran</h1>

<!-- Content Row -->
<div class="card shadow mb-4">
    <div class="card-body">
    @auth
    @if(Auth::user()->isAdmin())
        <div class="d-flex justify-content-end">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#inputModal">Tambah Data</button>
        </div>
        @endif
        @endauth
        <div class="my-2"></div>
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kelas</th>
                        <th>Mapel</th>
                        <th>Hari</th>
                        <th>Pengajar</th>
                        <th>Jam Mulai</th>
                        <th>Jam Selesai</th>
                        @auth
    @if(Auth::user()->isAdmin())
                        <th>Aksi</th>
                        @endif
                        @endauth
                    </tr>
                </thead>
                <tbody>
                @forelse ($jadwal as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->kelas->nama_kelas }} {{ $item->kelas->tingkat }}</td>
                                <td>{{ $item->mapel->nama_mapel }}</td>
                                <td>{{ $item->hari }}</td>
                                <td>Guru {{ $item->user->username ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->jam_mulai)->format('H:i') }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->jam_selesai)->format('H:i') }}</td>
                                @auth
                                @if(Auth::user()->isAdmin())
                                <td>
                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}">Edit</button>
                                
                                <!-- Modal Edit -->
    <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $item->id }}" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <form action="{{ route('jadwal.update', $item->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-header">
              <h5 class="modal-title" id="editModalLabel{{ $item->id }}">Edit Jadwal</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

              <div class="mb-3">
                <label for="kelas_id_{{ $item->id }}" class="form-label">Kelas</label>
                <select name="kelas_id" id="kelas_id_{{ $item->id }}" class="form-control" required>
                  @foreach ($kelas as $kls)
                    <option value="{{ $kls->id }}" {{ $item->kelas_id == $kls->id ? 'selected' : '' }}>
                      {{ $kls->nama_kelas }} {{ $kls->tingkat }}
                    </option>
                  @endforeach
                </select>
              </div>

              <div class="mb-3">
                <label for="mapel_id_{{ $item->id }}" class="form-label">Mata Pelajaran</label>
                <select name="mapel_id" id="mapel_id_{{ $item->id }}" class="form-control" required>
                  @foreach ($mapel as $m)
                    <option value="{{ $m->id }}" {{ $item->mapel_id == $m->id ? 'selected' : '' }}>
                      {{ $m->nama_mapel }}
                    </option>
                  @endforeach
                </select>
              </div>

              <div class="mb-3">
                <label for="hari_{{ $item->id }}" class="form-label">Hari</label>
                <select name="hari" id="hari_{{ $item->id }}" class="form-control" required>
                  @foreach (['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'] as $h)
                    <option value="{{ $h }}" {{ $item->hari == $h ? 'selected' : '' }}>{{ $h }}</option>
                  @endforeach
                </select>
              </div>

              <div class="mb-3">
                <label for="user_id_{{ $item->id }}" class="form-label">Pengajar</label>
                <select name="user_id" id="user_id_{{ $item->id }}" class="form-control" required>
                  @foreach ($users as $u)
                    <option value="{{ $u->id }}" {{ $item->user_id == $u->id ? 'selected' : '' }}>
                      {{ $u->username }}
                    </option>
                  @endforeach
                </select>
              </div>

              <div class="mb-3">
                <label for="jam_mulai_{{ $item->id }}" class="form-label">Jam Mulai</label>
                <input type="time" name="jam_mulai" id="jam_mulai_{{ $item->id }}" value="{{ \Carbon\Carbon::parse($item->jam_mulai)->format('H:i') }}" class="form-control" required>
              </div>

              <div class="mb-3">
                <label for="jam_selesai_{{ $item->id }}" class="form-label">Jam Selesai</label>
                <input type="time" name="jam_selesai" id="jam_selesai_{{ $item->id }}" value="{{ \Carbon\Carbon::parse($item->jam_selesai)->format('H:i') }}" class="form-control" required>
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
    
    <form action="{{ route('jadwal.destroy', $item->id) }}" method="POST" class="d-inline delete-form">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
</form>

                                </td>
                                @endif
                                @endauth
                            </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>

<!-- Modal Tambah Jadwal Pelajaran -->
<!-- Modal Tambah Jadwal Pelajaran -->
<div class="modal fade" id="inputModal" tabindex="-1" aria-labelledby="inputModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('jadwal.store') }}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="inputModalLabel">Input Jadwal Pelajaran</h5>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

          <!-- Field Pengajar -->
          <div class="mb-3">
            <label for="user_id" class="form-label">Pengajar</label>
            <select name="user_id" id="user_id" class="form-control" required>
              <option value="">-- Pilih Pengajar --</option>
              @foreach ($users as $u)
                <option value="{{ $u->id }}">{{ $u->username }}</option>
              @endforeach
            </select>
          </div>

          <!-- Field Kelas -->
          <div class="mb-3">
            <label for="kelas_id" class="form-label">Kelas</label>
            <select name="kelas_id" id="kelas_id" class="form-control" required>
              <option value="">-- Pilih Kelas --</option>
              @foreach ($kelas as $kls)
                <option value="{{ $kls->id }}">{{ $kls->nama_kelas }} {{ $kls->tingkat }}</option>
              @endforeach
            </select>
          </div>

          <!-- Field Mapel -->
          <div class="mb-3">
            <label for="mapel_id" class="form-label">Mata Pelajaran</label>
            <select name="mapel_id" id="mapel_id" class="form-control" required>
              <option value="">-- Pilih Mapel --</option>
              @foreach ($mapel as $m)
                <option value="{{ $m->id }}">{{ $m->nama_mapel }}</option>
              @endforeach
            </select>
          </div>

          <!-- Hari -->
          <div class="mb-3">
            <label for="hari" class="form-label">Hari</label>
            <select name="hari" id="hari" class="form-control" required>
              <option value="">-- Pilih Hari --</option>
              @foreach (['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'] as $hari)
                <option value="{{ $hari }}">{{ $hari }}</option>
              @endforeach
            </select>
          </div>

          <!-- Jam -->
          <div class="mb-3">
            <label for="jam_mulai" class="form-label">Jam Mulai</label>
            <input type="time" name="jam_mulai" id="jam_mulai" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="jam_selesai" class="form-label">Jam Selesai</label>
            <input type="time" name="jam_selesai" id="jam_selesai" class="form-control" required>
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