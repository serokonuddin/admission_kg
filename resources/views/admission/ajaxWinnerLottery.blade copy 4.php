<style>
    .modal-onboarding .onboarding-content {
        margin: 0px 1.5rem;
    }

    table td {
        text-align: left;
        font-weight: bold;
        vertical-align: middle;
    }

    .table>:not(caption)>*>* {
        padding: 0.5rem 0.75rem !important;
    }

    .modal-onboarding {
        /* max-width: 650px; */
        margin: 0 auto;
    }

    .modal-header {
        background: linear-gradient(135deg, #00ADEF, #0080FF);
        padding: 1rem 1.5rem;
        position: relative;
        border-radius: 0;
    }

    .btn-close {
        filter: invert(1);
        opacity: 0.8;
    }

    .academy-name {
        font-family: Algerian, sans-serif;
        font-size: 1.5rem;
        font-weight: bold;
        color: #00ADEF;
        text-decoration: none;
        line-height: 1.2;
    }

    .admission-title {
        color: #71DD37;
        font-weight: bold;
        font-size: 1.25rem;
        margin: 0.5rem 0;
    }

    .selection-message {
        text-align: center;
        color: #FF9800 !important;
        font-size: 1.1rem;
        font-weight: bold;
        background: #FFF8E1;
        padding: 0.5rem;
        border-radius: 6px;
        margin: 0.5rem 0;
    }

    .student-photo {
        height: 100px;
        width: 100px;
        object-fit: cover;
        border-radius: 8px;
        border: 3px solid #00ADEF;
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.15);
        vertical-align: top;
    }

    .highlight-name {
        color: red;
        font-weight: 800;
        font-size: 1.1rem;
    }

    .highlight-serial {
        color: red;
        font-size: 1.1rem;
        font-weight: 800;
    }

    .info-row-compact {
        display: flex;
        justify-content: space-between;
        border-bottom: 1px solid #f0f0f0;
        padding: 0.4rem 0;
    }

    .info-label {
        font-weight: 600;
        color: #555;
    }

    .info-value {
        font-weight: 700;
        color: #222;
    }

    .modal-footer {
        padding: 1rem 1.5rem;
        background: #f8f9fa;
    }

    .btn-close-modal {
        background: #6c757d;
        color: white;
        border: none;
        padding: 0.5rem 1.5rem;
        border-radius: 4px;
        font-weight: 600;
    }

    .btn-close-modal:hover {
        background: #5a6268;
    }

    @media (max-width: 576px) {
        .modal-onboarding .onboarding-content {
            margin: 0px 1rem;
        }

        .academy-name {
            font-size: 1.3rem;
        }

        .admission-title {
            font-size: 1.1rem;
        }

        .student-photo {
            height: 80px;
            width: 80px;
        }
    }
</style>

<div class="modal-header border-0">
    {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
</div>

<div class="modal-body p-0">
    <div class="onboarding-media text-center pt-3 px-3">
        <a class="academy-name" href="#">
            {{ $academy_info->academy_name }}
        </a>
        <h4 class="admission-title">KG Admission 2026</h4>
        <p class="selection-message">
            Congratulation! You Are Selected
            @if ($result[0]->watting == 1)
                For Waiting List
            @endif
        </p>
    </div>

    @php
        $gender = [1 => 'Male', 2 => 'Female', '' => ''];
    @endphp

    <div class="onboarding-content mb-0">
        <table class="table table-borderless mb-2">
            <tr>
                <td colspan="2" class="pb-1">
                    <div class="highlight-name">
                        NAME: {{ strtoupper($result[0]->name_en ?? '') }}
                    </div>
                </td>
                <td rowspan="3" class="text-center" style="width: 120px;">
                    <img src="{{ asset($result[0]->photo ?? '') }}" alt="Student Photo" class="student-photo"
                        onerror="this.src='https://via.placeholder.com/100x100/00ADEF/FFFFFF?text=Photo'">
                </td>
            </tr>
            <tr>
                <td colspan="2" class="py-1">
                    <div class="highlight-serial">
                        SERIAL NO: {{ $result[0]->temporary_id ?? '' }}
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="pt-1">
                    GUARDIAN: {{ strtoupper($result[0]->gurdian_name ?? '') }}<br>
                    MOBILE: {{ $result[0]->mobile ?? '' }}
                </td>
            </tr>
        </table>

        <div class="mt-2">
            <div class="info-row-compact">
                <span class="info-label">Version:</span>
                <span class="info-value">
                    @if ($result[0]->version_id == 1)
                        Bangla
                    @else
                        English
                    @endif
                </span>
            </div>

            <div class="info-row-compact">
                <span class="info-label">Shift:</span>
                <span class="info-value">
                    @if ($result[0]->shift_id == 1)
                        Morning
                    @else
                        Day
                    @endif
                </span>
            </div>

            <div class="info-row-compact">
                <span class="info-label">Date of Birth:</span>
                <span class="info-value">{{ $result[0]->dob ?? '' }}</span>
            </div>

            <div class="info-row-compact">
                <span class="info-label">Birth Registration:</span>
                <span class="info-value">{{ $result[0]->birth_registration_number ?? '' }}</span>
            </div>

            <div class="info-row-compact">
                <span class="info-label">Gender:</span>
                <span class="info-value">{{ $gender[$result[0]->gender] ?? '' }}</span>
            </div>
        </div>
    </div>
</div>

<div class="modal-footer border-0">
    <button type="button" class="btn-close-modal" data-bs-dismiss="modal">Close</button>
</div>
