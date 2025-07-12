<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>SIMAK DALPA - Dashboard</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,700,900" rel="stylesheet">

    <!-- Custom styles -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Tambahkan ke bagian <style> -->
<style>
    .sidebar {
    display: flex;
    flex-direction: column;
    justify-content: flex-start; /* Menu mulai dari atas */
    align-items: stretch;
    text-align: left;
    padding-top: 1rem;
}


    .sidebar .nav-item {
        width: 100%;
    }

    .sidebar .nav-link {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 10px 0;
        font-size: 0.85rem;
    }

    .sidebar .nav-link span {
        margin-top: 4px;
        font-size: 0.75rem;
    }

    .sidebar .sidebar-heading {
        margin-bottom: 1rem;
        font-size: 0.75rem;
        color: rgba(255,255,255,0.5);
        text-transform: uppercase;
    }
    @media (max-width: 768px) {
    .table-responsive {
        overflow-x: auto;       /* Wajib untuk bisa geser horizontal */
        -webkit-overflow-scrolling: touch; /* Tambahan untuk iOS */
        margin-bottom: 1rem;
        border-radius: 0.5rem;
    }

    .table {
        min-width: 600px; /* Tambahkan minimal lebar agar bisa digeser */
    }

    .table th, .table td {
        white-space: nowrap;
        font-size: 0.85rem;
    }

    .table thead th {
        background-color: #f8f9fc;
    }
}

</style>



</head>
<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Sidebar -->
    <x-navbar></x-navbar>

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                <!-- Sidebar Toggle Button -->
                <!-- <button class="btn btn-link d-md-none rounded-circle me-3 sidebar-toggle-btn" aria-label="Toggle Sidebar">
    <i class="fa fa-bars"></i>
</button> -->


                <!-- Topbar Navbar -->
                <ul class="navbar-nav ms-auto">
                    <!-- User Info -->
                    <li class="nav-item dropdown no-arrow">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
    <span class="d-none d-sm-inline-block text-gray-600 small">
        {{ ucfirst(Str::limit(Auth::user()->username, 15)) }}
    </span>
    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-person-fill ms-2" viewBox="0 0 16 16">
        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
    </svg>
</a>
                        <ul class="dropdown-menu dropdown-menu-end shadow animated--grow-in" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="profile"><i class="fas fa-user fa-sm fa-fw me-2 text-gray-400"></i> Profile</a></li>
                            <!-- <li><a class="dropdown-item" href="#"><i class="fas fa-cogs fa-sm fa-fw me-2 text-gray-400"></i> Settings</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-list fa-sm fa-fw me-2 text-gray-400"></i> Activity Log</a></li>
                            <li><hr class="dropdown-divider"></li> -->
                            <li><a class="dropdown-item" href="/login" data-bs-toggle="modal" data-bs-target="#logoutModal"><i class="fas fa-sign-out-alt fa-sm fa-fw me-2 text-gray-400"></i> Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>

            <!-- Sidebar Backdrop -->
            <div class="sidebar-backdrop" id="sidebarBackdrop"></div>

            <!-- Begin Page Content -->
            <div class="container-fluid px-3">
                {{ $slot }}
            </div>
        </div>

        <!-- Footer -->
        <footer class="sticky-footer bg-white mt-auto">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright &copy; Dalam Pagar Kandangan 2025</span>
                </div>
            </div>
        </footer>

    </div>
</div>

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ready to Leave?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <a class="btn btn-primary" href="/login">Logout</a>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap & Script -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Toggle Sidebar Script -->
<!-- <script>
    const sidebar = document.getElementById('accordionSidebar');
    const toggleBtn = document.querySelector('.sidebar-toggle-btn');
    const backdrop = document.getElementById('sidebarBackdrop');

    toggleBtn?.addEventListener('click', () => {
        sidebar.classList.toggle('active');
        backdrop.classList.toggle('show');
        document.body.classList.toggle('sidebar-open');
    });

    backdrop?.addEventListener('click', () => {
        sidebar.classList.remove('active');
        backdrop.classList.remove('show');
        document.body.classList.remove('sidebar-open');
    });
</script> -->


<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if (session('success'))
<script>
Swal.fire({
    icon: 'success',
    title: 'Berhasil!',
    text: "{{ session('success') }}"
});
</script>
@endif
@if (session('error'))
<script>
Swal.fire({
    icon: "error",
    title: "Oops...",
    text: "Something went wrong!",
    footer: '<a href="#">Why do I have this issue?</a>'
});
</script>
@endif
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteForms = document.querySelectorAll('.delete-form');

        deleteForms.forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault(); // cegah form langsung submit

                Swal.fire({
                    title: "Yakin ingin menghapus?",
                    text: "Data yang dihapus tidak bisa dikembalikan!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya, hapus!",
                    cancelButtonText: "Batal"
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // lanjutkan submit form
                    }
                });
            });
        });
    });
</script>


@stack('scripts')
</body>
</html>
