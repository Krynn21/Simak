<x-layout>
<div class="container-fluid">
  <h1 class="h3 mb-2 text-gray-800">Tabel data absen</h1>

  <div class="card shadow mb-4">
    <div class="card-body">

      <!-- Tombol Buka Absen & Export -->
      @unless(Auth::user()->id_role == 2)
  <div class="d-flex justify-content-end gap-2 mb-2">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#inputModal">
      Buka Absen
    </button>
    <a href="/export-absen" class="btn btn-success">
      <i class="fas fa-file-export me-1"></i> Export
    </a>
  </div>
@endunless

      <!-- Tabel Absen -->
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama</th>
              <th>Status</th>
              <th>Keterangan</th>
              <th>Tanggal</th>
            </tr>
          </thead>
          <tbody>
            @foreach($absens as $index => $absen)
              <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $absen->user->username ?? 'Tidak diketahui' }}</td>
                <td>{{ $absen->status }}</td>
                <td>{{ $absen->keterangan }}</td>
                <td>{{ \Carbon\Carbon::parse($absen->sesi->tanggal)->format('d-m-Y') }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- MODAL BUKA ABSEN -->
<div class="modal fade" id="inputModal" tabindex="-1" aria-labelledby="inputModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="inputModalLabel">Daftar Isi Hadir</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <!-- Form Buka Absen -->
        <form method="POST" action="/admin/absen-sesi" class="mb-3">
          @csrf
          <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal</label>
            <input type="date" name="tanggal" id="tanggal" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="judul" class="form-label">Judul Sesi</label>
            <input type="text" name="judul" id="judul" class="form-control" placeholder="Judul Sesi" required>
          </div>
          <button type="submit" class="btn btn-success">Buka Absen</button>
        </form>

        <!-- Daftar Sesi Aktif -->
        <div>
          @foreach($sessions->where('is_open', true)->sortByDesc('tanggal') as $sesi)
            <div class="d-flex justify-content-between align-items-center border-bottom py-2">
              <span>{{ $sesi->tanggal }} - Status: <strong>Dibuka</strong></span>
              <form method="POST" action="/admin/absen-sesi/{{ $sesi->id }}/tutup" class="ms-2">
                @csrf
                <button type="submit" class="btn btn-sm btn-danger">Tutup</button>
              </form>
            </div>
          @endforeach

          <!-- Riwayat Terakhir Sesi Absen Ditutup -->
          @php
            $sesiTertutup = $sessions->where('is_open', false)->sortByDesc('tanggal')->first();
          @endphp

          @if($sesiTertutup)
            <div class="mt-4 border-top pt-3">
              <h5>Riwayat Terakhir Sesi Absen (Ditutup)</h5>
              <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                <span>{{ \Carbon\Carbon::parse($sesiTertutup->tanggal)->format('d-m-Y') }} - Judul: <strong>{{ $sesiTertutup->judul }}</strong></span>
                <span class="badge bg-secondary">Ditutup</span>
              </div>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>

<!-- MODAL ISI ABSEN -->
<div class="modal fade" id="modalIsiAbsen" tabindex="-1" aria-labelledby="modalIsiAbsenLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header ">
        <h5 class="modal-title" id="modalIsiAbsenLabel">Isi Absen</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      @php
        $sesiTerbuka = $sessions->where('is_open', true)->sortByDesc('tanggal')->first();
        $bisaAbsen = false;
        $waktuHabis = true;
        $sudahAbsen = \App\Models\Absen::where('id_user', auth()->id())
                        ->where('absen_session_id', optional($sesiTerbuka)->id)
                        ->exists();

        if ($sesiTerbuka) {
            $selisihMenit = \Carbon\Carbon::parse($sesiTerbuka->dibuka_pada)->diffInMinutes(now());
            $waktuHabis = $selisihMenit > 480;
            $bisaAbsen = !$sudahAbsen && !$waktuHabis;
        }
      @endphp

      <div class="modal-body">
        @if(!$sesiTerbuka)
          <div class="alert alert-warning">Tidak ada sesi absen yang dibuka saat ini.</div>

        @elseif($sudahAbsen)
          <div class="alert alert-success">✅ Kamu sudah mengisi absen untuk sesi: <strong>{{ $sesiTerbuka->judul }}</strong></div>

        @elseif($waktuHabis)
          <div class="alert alert-danger">⏰ Waktu absen sudah habis sejak sesi <strong>{{ $sesiTerbuka->judul }}</strong>.</div>

        @else
          <form method="POST" action="/admin/isi-absen">
            @csrf
            <div class="mb-3">
              <label for="status" class="form-label">Status Kehadiran</label>
              <select name="status" id="status" class="form-control" required>
                <option value="">-- Pilih Status --</option>
                <option value="hadir">Hadir</option>
                <option value="izin">Izin</option>
                <option value="sakit">Sakit</option>
                <option value="alpa">Alpa</option>
              </select>
            </div>
            <div class="mb-3">
              <label for="keterangan" class="form-label">Keterangan (opsional)</label>
              <input type="text" name="keterangan" id="keterangan" class="form-control" placeholder="Keterangan tambahan...">
            </div>
            <button type="submit" class="btn btn-primary">Kirim Absen</button>
          </form>
        @endif
      </div>
    </div>
  </div>
</div>
</x-layout>
