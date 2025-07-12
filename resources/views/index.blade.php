<x-layout>
<div class="container-fluid">

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">

<h1 class="h3 mb-0 text-gray-800">Dashboard</h1>


@if($user->role)
    <p>Role: {{ $user->role->name }}</p>
@else
    <p>Role tidak ditemukan</p>
@endif


</div>

<!-- Content Row -->
@if ($user && $user->id_role == 1)
<div class="row">

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Guru</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jumlahUsers }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <!-- <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Absen</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div> -->

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Kelas
                        </div>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $jumlahKelas }}</div>
                            </div>
                            <!-- <div class="col">
                                <div class="progress progress-sm mr-2">
                                    <div class="progress-bar bg-info" role="progressbar"
                                        style="width: 50%" aria-valuenow="50" aria-valuemin="0"
                                        aria-valuemax="100"></div>
                                </div>
                            </div> -->
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Jadwal Pelajaran</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jumlahMapel }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-comments fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- Pending Requests Card Example -->
    



<!-- Content Row -->

<div class="row">

    <!-- Area Chart -->
    <div class="col-xl-8 col-lg-7">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <!-- Card Body -->
        </div>
    </div>

    <!-- Pie Chart -->
</div>

<!-- Content Row -->
<div class="row">

    <!-- Content Column -->
    <div class="col-lg-6 mb-4">

        <!-- Project Card Example -->

        <!-- Color System -->
        @if ($absenAktif && !$sudahAbsen)
        <div class="row">
            <div class="col-lg-3 mb-4">
                <div class="card bg-primary text-white shadow">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalIsiAbsen"> Isi Absen
                </button>
                </div>
            </div>
        </div>
        @endif
        
        @if ($sudahAbsen)
            <p class="text-success mt-2">Anda sudah mengisi absen hari ini.</p>
        @endif
    </div>

    <div class="col-lg-6 mb-4">

        <!-- Illustrations -->

        <!-- Approach -->

    </div>
</div>

</div>
<div class="modal fade" id="modalIsiAbsen" tabindex="-1" aria-labelledby="modalIsiAbsenLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-header">
            <h5 class="modal-title" id="modalIsiAbsenLabel">Isi Absen</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <!-- Ganti isi modal sesuai kebutuhan isi absen -->
            <form method="POST" action="/admin/isi-absen">
                @csrf
                <select name="status" required>
                    <option value="">-- Pilih Status --</option>
                    <option value="hadir">Hadir</option>
                    <option value="izin">Izin</option>
                    <option value="sakit">Sakit</option>
                    <option value="alpa">Alpa</option>
                </select>
                <input type="text" name="keterangan" placeholder="Keterangan (opsional)">
                <button type="submit">Kirim Absen</button>
            </form>
        </div>
    </div>
    </div>
</div>
</x-layout>