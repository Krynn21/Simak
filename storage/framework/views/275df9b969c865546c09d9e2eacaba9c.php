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
                    <?php $__currentLoopData = $kelas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($index + 1); ?></td>
                        <td><?php echo e($k->nama_kelas); ?></td>
                        <td><?php echo e(ucfirst($k->tingkat)); ?></td>
                        <td>
                            <!-- Tombol Edit trigger modal -->
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?php echo e($k->id); ?>">Edit</button>

                            <!-- Modal Edit -->
                            <div class="modal fade" id="editModal<?php echo e($k->id); ?>" tabindex="-1" aria-labelledby="editModalLabel<?php echo e($k->id); ?>" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <form action="<?php echo e(route('kelas.update', $k->id)); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('PUT'); ?>
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="editModalLabel<?php echo e($k->id); ?>">Edit Kelas</h5>
                                      <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                      <div class="mb-3">
                                        <label for="nama_kelas<?php echo e($k->id); ?>" class="form-label">Kelas Berapa</label>
                                        <input type="text" class="form-control" id="nama_kelas<?php echo e($k->id); ?>" name="nama_kelas" value="<?php echo e($k->nama_kelas); ?>" required>
                                      </div>
                                      <div class="mb-3">
                                        <label for="tingkat<?php echo e($k->id); ?>" class="form-label">Tingkat</label>
                                        <select class="form-control" id="tingkat<?php echo e($k->id); ?>" name="tingkat" required>
                                          <option value="">-- Pilih Tingkat --</option>
                                          <?php $__currentLoopData = $tingkats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tingkat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($tingkat); ?>" <?php echo e($k->tingkat === $tingkat ? 'selected' : ''); ?>><?php echo e(ucfirst($tingkat)); ?></option>
                                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                            <form action="<?php echo e(route('kelas.destroy', $k->id)); ?>" method="POST" class="d-inline delete-form">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>

                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
      <form action="<?php echo e(route('kelas.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>
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
              <?php $__currentLoopData = $tingkats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tingkat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($tingkat); ?>"><?php echo e(ucfirst($tingkat)); ?></option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1f9e5f64f242295036c059d9dc1c375c)): ?>
<?php $attributes = $__attributesOriginal1f9e5f64f242295036c059d9dc1c375c; ?>
<?php unset($__attributesOriginal1f9e5f64f242295036c059d9dc1c375c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1f9e5f64f242295036c059d9dc1c375c)): ?>
<?php $component = $__componentOriginal1f9e5f64f242295036c059d9dc1c375c; ?>
<?php unset($__componentOriginal1f9e5f64f242295036c059d9dc1c375c); ?>
<?php endif; ?>
<?php /**PATH C:\laragon\www\example-app\resources\views/kelas/index.blade.php ENDPATH**/ ?>