<!-- views/tasks/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="p-4">
    <div class="row mb-4 align-items-center">
        <div class="col-md-8">
            <h3 class="fw-bold text-primary">Daftar Tugas</h3>
            <p class="text-muted mb-0">Kelola dan periksa daftar tugas harian</p>
        </div>
    </div>

    <div class="row mb-4 g-3">
        <div class="col-md-4">
            <div class="input-group rounded-pill overflow-hidden border">
                <span class="input-group-text bg-transparent border-0">
                    <i class="bi bi-calendar3 text-primary"></i>
                </span>
                <input type="text" class="form-control border-0 shadow-none" value="10/03/2025 - 15/03/2025">
            </div>
        </div>
        <div class="col-md-5">
            <div class="input-group rounded-pill overflow-hidden border">
                <input type="text" class="form-control border-0 shadow-none" placeholder="Cari Tugas">
                <span class="input-group-text bg-transparent border-0">
                    <i class="bi bi-search text-primary"></i>
                </span>
            </div>
        </div>
        <div class="col-md-3">
            <button class="btn btn-primary rounded-pill w-100" data-bs-toggle="modal" data-bs-target="#addTaskModal">
                <i class="bi bi-plus-lg me-1"></i> Tambah Tugas
            </button>
        </div>
    </div>

    <div class="card border-0 rounded-4 shadow-sm mb-4">
        <div class="card-body p-0">
            @if(isset($tasks) && count($tasks) > 0)
            @foreach($tasks as $task)
            <div class="p-3 border-bottom task-item d-flex justify-content-between align-items-center hover-effect">
                <div class="d-flex align-items-center">
                    <div class="form-check me-3">
                        <input class="form-check-input" type="checkbox" value="">
                    </div>
                    <div>
                        <h6 class="fw-medium mb-0">{{ $task->name }}</h6>
                        <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill fs-xs px-2 py-1">
                            <i class="bi bi-flag me-1"></i>Sedang
                        </span>
                        <small class="text-muted ms-2">{{ $task->due_date }}</small>
                    </div>
                </div>
                <div>
                    <button class="btn btn-light btn-sm rounded-circle task-action me-1"
                        data-bs-toggle="modal"
                        data-bs-target="#taskDetailModal"
                        data-task="{{ $task->name }}"
                        data-description="{{ $task->description }}"
                        data-date="{{ $task->due_date }}">
                        <i class="bi bi-eye text-primary"></i>
                    </button>
                    <!-- <button class="btn btn-light btn-sm rounded-circle task-action me-1"
                        onclick="location.href='{{ route('tasks.edit', $task->id) }}'">
                        <i class="bi bi-pencil text-warning"></i>
                    </button> -->
                    <button class="btn btn-light btn-sm rounded-circle task-action"
                        onclick="event.preventDefault(); 
                        document.getElementById('delete-form-{{ $task->id }}').submit();">
                        <i class="bi bi-trash text-danger"></i>
                    </button>
                    <form id="delete-form-{{ $task->id }}" action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="d-none">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
            @endforeach
            @else
            <div class="empty-state p-5 text-center">
                <div class="mb-4">
                    <i class="bi bi-clipboard text-primary opacity-50" style="font-size: 4rem;"></i>
                </div>
                <h5 class="text-secondary">Tidak ada tugas</h5>
                <p class="text-muted">Belum ada tugas yang ditambahkan. Klik tombol "Tambah Tugas" untuk membuat tugas baru.</p>
                <button class="btn btn-primary rounded-pill px-4 mt-2" data-bs-toggle="modal" data-bs-target="#addTaskModal">
                    <i class="bi bi-plus-lg me-2"></i> Tambah Tugas Sekarang
                </button>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal Tambah Tugas -->
<div class="modal fade" id="addTaskModal" tabindex="-1" aria-labelledby="addTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header bg-primary text-white border-0">
                <h5 class="modal-title">
                    <i class="bi bi-plus-circle me-2"></i>Tambah Tugas
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form action="{{ route('tasks.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-medium">Nama Tugas</label>
                        <input type="text" class="form-control rounded-pill border-0 bg-light" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium">Deskripsi</label>
                        <textarea class="form-control rounded-3 border-0 bg-light" name="description" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium">Tanggal</label>
                        <input type="date" class="form-control rounded-pill border-0 bg-light" name="due_date" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium">Prioritas</label>
                        <select class="form-select rounded-pill border-0 bg-light" name="priority">
                            <option value="low">Rendah</option>
                            <option value="medium" selected>Sedang</option>
                            <option value="high">Tinggi</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary rounded-pill w-100">
                        <i class="bi bi-save me-2"></i>Simpan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Lihat Detail -->
<div class="modal fade" id="taskDetailModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header bg-info text-white border-0">
                <h5 class="modal-title">
                    <i class="bi bi-info-circle me-2"></i>Detail Tugas
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <h5 id="detailTaskName" class="fw-bold mb-3"></h5>

                <div class="mb-4">
                    <h6 class="text-muted mb-2">
                        <i class="bi bi-calendar me-2"></i>Tanggal
                    </h6>
                    <p id="detailTaskDate" class="ms-4"></p>
                </div>

                <div>
                    <h6 class="text-muted mb-2">
                        <i class="bi bi-file-text me-2"></i>Deskripsi
                    </h6>
                    <p id="detailTaskDescription" class="ms-4"></p>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <button type="button" class="btn btn-outline-secondary rounded-pill me-2" data-bs-dismiss="modal">
                        <i class="bi bi-x me-1"></i>Tutup
                    </button>
                    <button type="button" class="btn btn-primary rounded-pill">
                        <i class="bi bi-pencil me-1"></i>Edit
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var taskDetailModal = document.getElementById("taskDetailModal");
        if (taskDetailModal) {
            taskDetailModal.addEventListener("show.bs.modal", function(event) {
                var button = event.relatedTarget;
                var taskName = button.getAttribute("data-task");
                var taskDescription = button.getAttribute("data-description") || "Tidak ada deskripsi";
                var taskDate = button.getAttribute("data-date");

                document.getElementById("detailTaskName").textContent = taskName;
                document.getElementById("detailTaskDescription").textContent = taskDescription;
                document.getElementById("detailTaskDate").textContent = taskDate;
            });
        }
    });
</script>
@endpush
@endsection