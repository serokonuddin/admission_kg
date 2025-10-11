<style>
    :root {
        --bs-breadcrumb-divider: ">";
    }

    .breadcrumb a {
        text-decoration: none;
        color: #007bff;
    }

    .breadcrumb a:hover {
        text-decoration: underline;
        color: #0056b3;
    }

    .card {
        background-color: #f8f9fa;
    }

    .card-header {
        font-size: 1rem;
        padding: 20px !important;
    }

    .card-header span {
        font-size: 1rem;
        color: #03C3EC;
    }

    .section-item {
        background-color: #ffffff;
        border-radius: 10px;
        margin-top: 20px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .section-item:hover {
        background-color: #eaf4ff;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
    }

    .average-mark {
        font-size: 1.2rem;
        color: #343a40;
        font-weight: 500;
    }

    .average-mark strong {
        color: #28a745;
    }

    .average-mark .text-muted {
        color: #6c757d;
    }
</style>
<div class="card">
    <div class="card-body pb-4">
        @foreach ($shifts as $shift)
            <div class="section-item mb-4 p-3 rounded-lg border border-light shadow-sm">
                <div class="row">
                    <div class="col-md-6">
                        <button type="button" class="btn btn-class mx-1 my-1" name="shiftId"
                            value="{{ $shift->shift_id }}">
                            {{ $shift->shift_id == 1 ? 'Morning' : 'Day' }}
                        </button>
                    </div>
                    <div class="col-md-6 d-flex align-items-center justify-content-center">
                        <p class="average-mark mb-0">
                            <span class="text-muted">Average highest:</span>
                            <strong>{{ number_format($shiftHighestData[$shift->shift_id], 2) ?? 0 }}%</strong>
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
