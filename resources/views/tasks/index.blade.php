<!-- views/tasks/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="p-4 h-100">
    <div class="task-header mb-4">
        <h2 class="text-pretty fw-bold">Daftar Tugas</h2>
        <p class="text-muted mb-0">Kelola dan periksa daftar tugas harian</p>
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
        <div class="col-md-3 text-end">
            <button class="btn btn-primary rounded-pill w-100" data-bs-toggle="modal" data-bs-target="#addTaskModal">
                <i class="bi bi-plus-lg me-1"></i> Tambah Tugas
            </button>
        </div>
    </div>

    <div class="task-list card border-0 shadow-sm">
        @if(isset($tasks) && count($tasks) > 0)
        @foreach($tasks as $task)
        <div class="task-item p-3 border-bottom d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <div class="form-check me-3">
                    <input class="form-check-input" type="checkbox" value="">
                </div>
                <div>
                    <h6 class="mb-0 fw-medium">{{ $task->name }}</h6>
                    <div class="d-flex align-items-center mt-1">
                        <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill fs-xs px-2 py-1 me-2">
                            <i class="bi bi-flag me-1"></i>
                            @if($task->priority == 'low')
                            Rendah
                            @elseif($task->priority == 'high')
                            Tinggi
                            @else
                            Sedang
                            @endif
                        </span>
                        @if($task->due_date)
                        <small class="text-muted">{{ $task->due_date->format('Y-m-d H:i:s') }}</small>
                        @endif
                    </div>
                </div>
            </div>
            <div class="task-actions">
                <button class="btn btn-light btn-sm rounded-circle task-action" data-bs-toggle="modal" data-bs-target="#taskDetailModal" data-task="{{ $task->name }}" data-description="{{ $task->description }}" data-date="{{ $task->due_date }}">
                    <i class="bi bi-info-circle-fill text-primary"></i>
                </button>
                <button class="btn btn-light btn-sm rounded-circle task-action" data-edit-url="{{ route('tasks.edit', $task->id) }}">
                    <i class="bi bi-pencil-square text-warning"></i>
                </button>
                <button class="btn btn-light btn-sm rounded-circle task-action delete-task" data-task-id="{{ $task->id }}" data-task-name="{{ $task->name }}">
                    <i class="bi bi-trash3-fill text-danger"></i>
                </button>
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

<!-- Modal Tambah Tugas -->
<div class="modal fade" id="addTaskModal" tabindex="-1" aria-labelledby="addTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header bg-primary text-white border-0">
                <h5 class="modal-title">
                    <i class="bi bi-plus-circle-fill me-2"></i>Tambah Tugas
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
                    <button type="submit" class="btn btn-primary rounded-pill w-100 py-2 mt-2">
                        <i class="bi bi-check2-circle me-2"></i>Simpan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Lihat Detail -->
<div class="modal fade" id="taskDetailModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header bg-info text-white border-0">
                <h5 class="modal-title">
                    <i class="bi bi-info-circle-fill me-2"></i>Detail Tugas
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <h5 id="detailTaskName" class="fw-bold mb-4"></h5>

                <div class="card border-0 bg-light rounded-4 p-3 mb-3">
                    <div class="d-flex align-items-center mb-2">
                        <div class="icon-circle bg-info bg-opacity-10 rounded-circle p-2 me-2">
                            <i class="bi bi-calendar-event text-info"></i>
                        </div>
                        <h6 class="mb-0 fw-medium">Tanggal</h6>
                    </div>
                    <p id="detailTaskDate" class="ms-4 mb-0 text-secondary"></p>
                </div>

                <div class="card border-0 bg-light rounded-4 p-3">
                    <div class="d-flex align-items-center mb-2">
                        <div class="icon-circle bg-primary bg-opacity-10 rounded-circle p-2 me-2">
                            <i class="bi bi-card-text text-primary"></i>
                        </div>
                        <h6 class="mb-0 fw-medium">Deskripsi</h6>
                    </div>
                    <p id="detailTaskDescription" class="ms-4 mb-0 text-secondary"></p>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <button type="button" class="btn btn-outline-secondary rounded-pill me-2 px-3 py-2" data-bs-dismiss="modal">
                        <i class="bi bi-x-lg me-1"></i>Tutup
                    </button>
                    <button type="button" class="btn btn-primary rounded-pill px-3 py-2">
                        <i class="bi bi-pencil-square me-1"></i>Edit
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteTaskModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header bg-danger text-white border-0">
                <h5 class="modal-title">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>Konfirmasi Hapus
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <p>Apakah Anda yakin ingin menghapus tugas:</p>
                <h5 id="deleteTaskName" class="fw-bold mb-4"></h5>
                <p class="text-muted small">Tindakan ini tidak dapat dibatalkan.</p>

                <div class="d-grid gap-2 d-flex justify-content-between mt-4">
                    <button type="button" class="btn btn-outline-secondary rounded-pill py-2 px-4 flex-grow-1" data-bs-dismiss="modal">
                        <i class="bi bi-x-lg me-1"></i>Batal
                    </button>
                    <button type="button" id="confirmDeleteBtn" class="btn btn-danger rounded-pill py-2 px-4 flex-grow-1">
                        <i class="bi bi-trash3-fill me-1"></i>Hapus
                    </button>
                </div>

                <form id="delete-form" action="{{ route('tasks.destroy', ':task_id') }}" method="POST" class="d-none">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Alert Toast for notifications -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1050">
    <div id="taskToast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-success text-white">
            <i class="bi bi-check-circle-fill me-2"></i>
            <strong class="me-auto">Notifikasi</strong>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            <span id="taskToastMessage"></span>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {

        // Toast notification
        const showToast = (message, type = 'success') => {
            const toast = document.getElementById('taskToast');
            const toastHeader = toast.querySelector('.toast-header');
            const toastMessage = document.getElementById('taskToastMessage');

            // Set message
            toastMessage.textContent = message;

            // Set color based on type
            toastHeader.className = 'toast-header';
            if (type === 'success') {
                toastHeader.classList.add('bg-success', 'text-white');
                toastHeader.innerHTML = '<i class="bi bi-check-circle-fill me-2"></i><strong class="me-auto">Notifikasi</strong><button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>';
            } else if (type === 'error') {
                toastHeader.classList.add('bg-danger', 'text-white');
                toastHeader.innerHTML = '<i class="bi bi-exclamation-triangle-fill me-2"></i><strong class="me-auto">Error</strong><button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>';
            }

            // Show toast
            const bsToast = new bootstrap.Toast(toast);
            bsToast.show();
        };

        // Task detail modal
        const taskDetailModal = document.getElementById("taskDetailModal");
        if (taskDetailModal) {
            taskDetailModal.addEventListener("show.bs.modal", function(event) {
                const button = event.relatedTarget;
                const taskName = button.getAttribute("data-task");
                const taskDescription = button.getAttribute("data-description") || "Tidak ada deskripsi";
                const taskDate = button.getAttribute("data-date");

                document.getElementById("detailTaskName").textContent = taskName;
                document.getElementById("detailTaskDescription").textContent = taskDescription;
                document.getElementById("detailTaskDate").textContent = taskDate;
            });
        }

        // Edit button redirects
        document.querySelectorAll('[data-edit-url]').forEach(button => {
            button.addEventListener('click', function() {
                window.location.href = this.getAttribute('data-edit-url');
            });
        });

        // Delete task handling
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteTaskModal'));
        const deleteForm = document.getElementById('delete-form');
        const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');

        // Delete buttons
        document.querySelectorAll('.delete-task').forEach(button => {
            button.addEventListener('click', function() {
                const taskId = this.getAttribute('data-task-id');
                const taskName = this.getAttribute('data-task-name');

                // Update form action URL
                deleteForm.action = deleteForm.action.replace(':task_id', taskId);

                // Update modal content
                document.getElementById('deleteTaskName').textContent = taskName;

                // Show delete confirmation modal
                deleteModal.show();
            });
        });

        // Confirm delete button
        confirmDeleteBtn.addEventListener('click', function() {
            const taskId = deleteForm.action.split('/').pop();

            fetch("{{ route('tasks.delete.ajax') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        task_id: taskId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Hide the modal
                        deleteModal.hide();

                        // Remove the task from DOM
                        const taskElement = document.querySelector(`[data-task-id="${taskId}"]`).closest('.task-item');
                        taskElement.style.opacity = '0';
                        setTimeout(() => {
                            taskElement.remove();

                            // Show success notification
                            showToast(data.message, 'success');

                            // If there are no more tasks, show empty state
                            if (document.querySelectorAll('.task-item').length === 0) {
                                location.reload(); // Or dynamically add empty state
                            }
                        }, 300);
                    } else {
                        showToast('Terjadi kesalahan saat menghapus tugas', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('Terjadi kesalahan saat menghapus tugas', 'error');
                });

        });
    });

    function toggleSidebar() {
        document.querySelector('.sidebar').classList.toggle('show');
    }

    // Add active class to current nav item
    document.addEventListener('DOMContentLoaded', function() {
        const currentPath = window.location.pathname;
        const navLinks = document.querySelectorAll('.nav-link');

        navLinks.forEach(link => {
            const href = link.getAttribute('href');
            if (href === currentPath || (href !== '#' && currentPath.includes(href))) {
                link.classList.add('active');
                link.classList.add('bg-primary', 'bg-opacity-10', 'text-primary');
                link.classList.remove('text-secondary');
            }
        });
    });
</script>
@endsection