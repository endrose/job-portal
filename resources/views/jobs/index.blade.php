@extends('layouts.app')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold text-dark mb-0 text-center">Daftar Lowongan</h3>
</div>

{{-- Search Bar --}}
<form action="#" method="GET" class="mb-4">
    <div class="input-group shadow-sm">
        <input type="text" name="search" class="form-control form-control-lg border-0" placeholder="Cari pekerjaan..." value="{{ request('search') }}">
        <button class="btn btn-primary px-4" type="submit">
            <i class="bi bi-search"></i> Search
        </button>
    </div>
</form>

{{-- Job Grid --}}
<div class="row g-4">
    @forelse($jobs as $job)
        <div class="col-xl-3 col-lg-4 col-md-6">
            <div class="card job-card border-0 shadow-sm h-100">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div>
                        <h5 class="job-title mb-1 text-primary">{{ $job['title'] }}</h5>
                        <p class="job-company mb-2 text-muted small">{{ $job['employer']['name'] ?? 'Perusahaan Tidak Diketahui' }}</p>
                        <p class="text-secondary small">{{ Str::limit($job['description'], 100) }}</p>
                    </div>
                    <div class="mt-3 text-end">
                        <button class="btn btn-success btn-sm px-4 fw-semibold shadow-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#applyModal"
                                data-job-id="{{ $job['id'] }}"
                                data-job-title="{{ $job['title'] }}">
                            LAMAR
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center text-muted py-5">
            <p>Tidak ada lowongan ditemukan.</p>
        </div>
    @endforelse
</div>

{{-- Modal Lamar --}}
<div class="modal fade" id="applyModal" tabindex="-1" aria-labelledby="applyModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg rounded-4">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title fw-bold" id="applyModalLabel">Lamar Pekerjaan</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <form id="applyForm" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
            <input type="hidden" name="job_id" id="job_id">
            <div class="mb-3">
                <label class="form-label">Posisi</label>
                <input type="text" id="job_title" class="form-control" readonly>
            </div>
            <div class="mb-3">
                <label class="form-label">Pengalaman Kerja</label>
                <textarea name="experience" class="form-control" required rows="3"></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Gaji yang Diharapkan</label>
                <input type="number" name="expected_salary" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Upload CV</label>
                <input type="file" name="cv" class="form-control" accept=".pdf,.doc,.docx" required>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-success">Kirim Lamaran</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const applyModal = document.getElementById('applyModal');
    const applyForm = document.getElementById('applyForm');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Set modal data
    applyModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const jobId = button.getAttribute('data-job-id');
        const jobTitle = button.getAttribute('data-job-title');

        document.getElementById('job_id').value = jobId;
        document.getElementById('job_title').value = jobTitle;

        applyForm.setAttribute('data-url', `http://127.0.0.1:8000/api/jobs/${jobId}/apply`);
    });

    // Auto login jika belum login
    async function autoLogin() {
        const response = await fetch("http://127.0.0.1:8000/api/login", {
            method: "POST",
            headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": csrfToken },
            body: JSON.stringify({
                email: "stracke.hortense@example.org",
                password: "password"
            })
        });
        const data = await response.json();
        if (!response.ok || !data.access_token) throw new Error(data.message ?? "Login gagal");
        return data;
    }

    // Submit lamaran
    applyForm.addEventListener('submit', async function (e) {
        e.preventDefault();
        const formData = new FormData(applyForm);
        const url = applyForm.getAttribute('data-url');

        try {
            let token = localStorage.getItem("token");
            if (!token) {
                const data = await autoLogin();
                token = data.access_token;
                localStorage.setItem("token", token);
            }

            const response = await fetch(url, {
                method: "POST",
                headers: {
                    "Authorization": "Bearer " + token,
                    "X-CSRF-TOKEN": csrfToken
                },
                body: formData
            });

            const result = await response.json();
            console.log(response.status, result);

            if (response.ok) {
                Swal.fire({ icon: 'success', title: 'Lamaran Terkirim!', text: result.message });
                bootstrap.Modal.getInstance(applyModal).hide();
                applyForm.reset();
            } else {
                Swal.fire({ icon: 'error', title: 'Gagal Mengirim Lamaran', text: result.message ?? "Terjadi kesalahan" });
            }

        } catch (err) {
            Swal.fire({ icon: 'error', title: 'Error', text: err.message });
        }
    });
});
</script>
@endsection
