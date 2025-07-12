<?php if (isset($component)) { $__componentOriginal1f9e5f64f242295036c059d9dc1c375c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1f9e5f64f242295036c059d9dc1c375c = $attributes; } ?>
<?php $component = App\View\Components\Layout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Layout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<div class="container-fluid">

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Tabel data Jadwal Pelajaran</h1>

<!-- Content Row -->
<div class="card shadow mb-4">
    <div class="card-body">
    <?php if(auth()->guard()->check()): ?>
    <?php if(Auth::user()->isAdmin()): ?>
        <div class="d-flex justify-content-end">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#inputModal">Tambah Data</button>
        </div>
        <?php endif; ?>
        <?php endif; ?>
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
                        <?php if(auth()->guard()->check()): ?>
    <?php if(Auth::user()->isAdmin()): ?>
                        <th>Aksi</th>
                        <?php endif; ?>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $jadwal; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($index + 1); ?></td>
                                <td><?php echo e($item->kelas->nama_kelas); ?> <?php echo e($item->kelas->tingkat); ?></td>
                                <td><?php echo e($item->mapel->nama_mapel); ?></td>
                                <td><?php echo e($item->hari); ?></td>
                                <td>Guru <?php echo e($item->user->username ?? '-'); ?></td>
                                <td><?php echo e(\Carbon\Carbon::parse($item->jam_mulai)->format('H:i')); ?></td>
                                <td><?php echo e(\Carbon\Carbon::parse($item->jam_selesai)->format('H:i')); ?></td>
                                <?php if(auth()->guard()->check()): ?>
                                <?php if(Auth::user()->isAdmin()): ?>
                                <td>
                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal<?php echo e($item->id); ?>">Edit</button>
                                
                                <!-- Modal Edit -->
    <div class="modal fade" id="editModal<?php echo e($item->id); ?>" tabindex="-1" aria-labelledby="editModalLabel<?php echo e($item->id); ?>" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <form action="<?php echo e(route('jadwal.update', $item->id)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <div class="modal-header">
              <h5 class="modal-title" id="editModalLabel<?php echo e($item->id); ?>">Edit Jadwal</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

              <div class="mb-3">
                <label for="kelas_id_<?php echo e($item->id); ?>" class="form-label">Kelas</label>
                <select name="kelas_id" id="kelas_id_<?php echo e($item->id); ?>" class="form-control" required>
                  <?php $__currentLoopData = $kelas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kls): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($kls->id); ?>" <?php echo e($item->kelas_id == $kls->id ? 'selected' : ''); ?>>
                      <?php echo e($kls->nama_kelas); ?> <?php echo e($kls->tingkat); ?>

                    </option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
              </div>

              <div class="mb-3">
                <label for="mapel_id_<?php echo e($item->id); ?>" class="form-label">Mata Pelajaran</label>
                <select name="mapel_id" id="mapel_id_<?php echo e($item->id); ?>" class="form-control" required>
                  <?php $__currentLoopData = $mapel; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($m->id); ?>" <?php echo e($item->mapel_id == $m->id ? 'selected' : ''); ?>>
                      <?php echo e($m->nama_mapel); ?>

                    </option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
              </div>

              <div class="mb-3">
                <label for="hari_<?php echo e($item->id); ?>" class="form-label">Hari</label>
                <select name="hari" id="hari_<?php echo e($item->id); ?>" class="form-control" required>
                  <?php $__currentLoopData = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $h): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($h); ?>" <?php echo e($item->hari == $h ? 'selected' : ''); ?>><?php echo e($h); ?></option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
              </div>

              <div class="mb-3">
                <label for="user_id_<?php echo e($item->id); ?>" class="form-label">Pengajar</label>
                <select name="user_id" id="user_id_<?php echo e($item->id); ?>" class="form-control" required>
                  <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($u->id); ?>" <?php echo e($item->user_id == $u->id ? 'selected' : ''); ?>>
                      <?php echo e($u->username); ?>

                    </option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
              </div>

              <div class="mb-3">
                <label for="jam_mulai_<?php echo e($item->id); ?>" class="form-label">Jam Mulai</label>
                <input type="time" name="jam_mulai" id="jam_mulai_<?php echo e($item->id); ?>" value="<?php echo e(\Carbon\Carbon::parse($item->jam_mulai)->format('H:i')); ?>" class="form-control" required>
              </div>

              <div class="mb-3">
                <label for="jam_selesai_<?php echo e($item->id); ?>" class="form-label">Jam Selesai</label>
                <input type="time" name="jam_selesai" id="jam_selesai_<?php echo e($item->id); ?>" value="<?php echo e(\Carbon\Carbon::parse($item->jam_selesai)->format('H:i')); ?>" class="form-control" required>
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
    
    <form action="<?php echo e(route('jadwal.destroy', $item->id)); ?>" method="POST" class="d-inline delete-form">
    <?php echo csrf_field(); ?>
    <?php echo method_field('DELETE'); ?>
    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
</form>

                                </td>
                                <?php endif; ?>
                                <?php endif; ?>
                            </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
      <form action="<?php echo e(route('jadwal.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>
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
              <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($u->id); ?>"><?php echo e($u->username); ?></option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
          </div>

          <!-- Field Kelas -->
          <div class="mb-3">
            <label for="kelas_id" class="form-label">Kelas</label>
            <select name="kelas_id" id="kelas_id" class="form-control" required>
              <option value="">-- Pilih Kelas --</option>
              <?php $__currentLoopData = $kelas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kls): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($kls->id); ?>"><?php echo e($kls->nama_kelas); ?> <?php echo e($kls->tingkat); ?></option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
          </div>

          <!-- Field Mapel -->
          <div class="mb-3">
            <label for="mapel_id" class="form-label">Mata Pelajaran</label>
            <select name="mapel_id" id="mapel_id" class="form-control" required>
              <option value="">-- Pilih Mapel --</option>
              <?php $__currentLoopData = $mapel; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($m->id); ?>"><?php echo e($m->nama_mapel); ?></option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
          </div>

          <!-- Hari -->
          <div class="mb-3">
            <label for="hari" class="form-label">Hari</label>
            <select name="hari" id="hari" class="form-control" required>
              <option value="">-- Pilih Hari --</option>
              <?php $__currentLoopData = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hari): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($hari); ?>"><?php echo e($hari); ?></option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1f9e5f64f242295036c059d9dc1c375c)): ?>
<?php $attributes = $__attributesOriginal1f9e5f64f242295036c059d9dc1c375c; ?>
<?php unset($__attributesOriginal1f9e5f64f242295036c059d9dc1c375c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1f9e5f64f242295036c059d9dc1c375c)): ?>
<?php $component = $__componentOriginal1f9e5f64f242295036c059d9dc1c375c; ?>
<?php unset($__componentOriginal1f9e5f64f242295036c059d9dc1c375c); ?>
<?php endif; ?><?php /**PATH C:\laragon\www\example-app\resources\views/jadwalpelajaran/index.blade.php ENDPATH**/ ?>