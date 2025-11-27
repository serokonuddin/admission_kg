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
        margin: 0 auto;
        animation: modalSlideIn 0.6s ease-out;
    }

    @keyframes modalSlideIn {
        0% {
            opacity: 0;
            transform: translateY(-50px) scale(0.9);
        }

        100% {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
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
        animation: titleGlow 2s ease-in-out infinite alternate;
    }

    @keyframes titleGlow {
        0% {
            text-shadow: 0 0 5px rgba(113, 221, 55, 0.5);
        }

        100% {
            text-shadow: 0 0 15px rgba(113, 221, 55, 0.8), 0 0 20px rgba(113, 221, 55, 0.6);
        }
    }

    .selection-message {
        text-align: center;
        color: #FF9800 !important;
        font-size: 1.1rem;
        font-weight: bold;
        background: linear-gradient(135deg, #FFF8E1, #FFECB3);
        padding: 1rem;
        border-radius: 12px;
        margin: 0.5rem 0;
        border: 2px solid #FF9800;
        position: relative;
        overflow: hidden;
        animation: messagePopIn 0.8s ease-out, confettiRain 2s ease-in-out 0.5s;
    }

    @keyframes messagePopIn {
        0% {
            opacity: 0;
            transform: scale(0.5) rotate(-5deg);
        }

        70% {
            transform: scale(1.1) rotate(2deg);
        }

        100% {
            opacity: 1;
            transform: scale(1) rotate(0deg);
        }
    }

    @keyframes confettiRain {
        0% {
            background-position: 0% 0%;
        }

        100% {
            background-position: 100% 100%;
        }
    }

    .selection-message::before {
        content: "🎉";
        position: absolute;
        left: 10px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 1.5rem;
        animation: confettiSpin 2s ease-in-out infinite;
    }

    .selection-message::after {
        content: "🎊";
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 1.5rem;
        animation: confettiSpin 2s ease-in-out infinite reverse;
    }

    @keyframes confettiSpin {

        0%,
        100% {
            transform: translateY(-50%) rotate(0deg);
        }

        50% {
            transform: translateY(-50%) rotate(180deg);
        }
    }

    .student-photo {
        height: 140px;
        width: 140px;
        /* object-fit: cover; */
        border-radius: 8px;
        border: 3px solid #00ADEF;
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.15);
        vertical-align: top;
        animation: photoFadeIn 1s ease-out 0.3s both;
    }

    @keyframes photoFadeIn {
        0% {
            opacity: 0;
            transform: scale(0.8);
        }

        100% {
            opacity: 1;
            transform: scale(1);
        }
    }

    .highlight-name {
        color: red;
        font-weight: 800;
        font-size: 1.1rem;
        animation: textColorPulse 3s ease-in-out infinite;
    }

    .highlight-serial {
        color: red;
        font-size: 1.1rem;
        font-weight: 800;
        animation: textColorPulse 3s ease-in-out infinite 0.5s;
    }

    @keyframes textColorPulse {

        0%,
        100% {
            color: #D32F2F;
            text-shadow: 0 0 5px rgba(211, 47, 47, 0.3);
        }

        50% {
            color: #F44336;
            text-shadow: 0 0 10px rgba(244, 67, 54, 0.5);
        }
    }

    /* Two column layout styles */
    .info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.5rem;
        animation: slideInFromLeft 0.6s ease-out both;
    }

    .info-grid-item {
        display: flex;
        /* justify-content: space-between; */
        border-bottom: 1px solid #f0f0f0;
        padding: 0.4rem 0;
        animation: slideInFromLeft 0.6s ease-out both;
    }

    .info-grid-item:nth-child(1) {
        animation-delay: 0.7s;
    }

    .info-grid-item:nth-child(2) {
        animation-delay: 0.8s;
    }

    .info-grid-item:nth-child(3) {
        animation-delay: 0.9s;
    }

    .info-grid-item:nth-child(4) {
        animation-delay: 1.0s;
    }

    .info-grid-item:nth-child(5) {
        animation-delay: 1.1s;
    }

    @keyframes slideInFromLeft {
        0% {
            opacity: 0;
            transform: translateX(-30px);
        }

        100% {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .info-label {
        font-weight: 600;
        color: #555;
    }

    .info-value {
        font-weight: 700;
        color: #222;
        margin-left: 10px;
    }

    .modal-footer {
        padding: 1rem 1.5rem;
        background: #f8f9fa;
        animation: fadeInUp 0.6s ease-out 1.2s both;
    }

    @keyframes fadeInUp {
        0% {
            opacity: 0;
            transform: translateY(20px);
        }

        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .btn-close-modal {
        background: linear-gradient(135deg, #6c757d, #5a6268);
        color: white;
        border: none;
        padding: 0.5rem 1.5rem;
        border-radius: 6px;
        font-weight: 600;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .btn-close-modal:hover {
        background: linear-gradient(135deg, #5a6268, #495056);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }

    .btn-close-modal::after {
        content: "";
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        transform: translate(-50%, -50%);
        transition: width 0.3s, height 0.3s;
    }

    .btn-close-modal:hover::after {
        width: 100px;
        height: 100px;
    }

    /* Floating celebration elements */
    .celebration-dot {
        position: absolute;
        width: 8px;
        height: 8px;
        background: linear-gradient(135deg, #FFD700, #FF6B6B);
        border-radius: 50%;
        animation: floatAround 6s ease-in-out infinite;
    }

    .celebration-dot:nth-child(1) {
        top: 10%;
        left: 5%;
        animation-delay: 0s;
    }

    .celebration-dot:nth-child(2) {
        top: 20%;
        right: 10%;
        animation-delay: 1s;
    }

    .celebration-dot:nth-child(3) {
        bottom: 30%;
        left: 15%;
        animation-delay: 2s;
    }

    .celebration-dot:nth-child(4) {
        bottom: 20%;
        right: 5%;
        animation-delay: 3s;
    }

    @keyframes floatAround {

        0%,
        100% {
            transform: translate(0, 0) scale(1);
            opacity: 0.7;
        }

        25% {
            transform: translate(20px, -15px) scale(1.2);
            opacity: 1;
        }

        50% {
            transform: translate(-10px, 20px) scale(0.8);
            opacity: 0.5;
        }

        75% {
            transform: translate(15px, 10px) scale(1.1);
            opacity: 0.8;
        }
    }

    /* Improved table layout */
    .student-info-table {
        width: 100%;
        border-collapse: collapse;
    }

    .student-info-table tr:first-child td {
        padding-top: 0;
    }

    .student-info-table tr:last-child td {
        padding-bottom: 0;
    }

    .student-info-table .photo-cell {
        width: 160px;
        text-align: center;
        vertical-align: top;
        padding-top: 10px !important;
    }

    .student-info-table .info-cell {
        vertical-align: top;
        padding-left: 0 !important;
    }

    .student-info-table .serial-cell {
        padding-bottom: 0px !important;
    }

    .student-info-table .name-cell {
        padding-top: 5px !important;
        padding-bottom: 5px !important;
    }

    .student-info-table .guardian-cell {
        padding-top: 0px !important;
        font-size: 14px;
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
            height: 120px;
            width: 120px;
        }

        .selection-message::before,
        .selection-message::after {
            font-size: 1.2rem;
        }

        .student-info-table .photo-cell {
            width: 130px;
        }

        /* Stack columns on mobile */
        .info-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="modal-onboarding">
    <!-- Celebration dots -->
    <div class="celebration-dot"></div>
    <div class="celebration-dot"></div>
    <div class="celebration-dot"></div>
    <div class="celebration-dot"></div>

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
                Congratulations! You are selected
                @if ($result[0]->watting == 1)
                    For Waiting List
                @endif
            </p>
        </div>

        @php
            $gender = [1 => 'Male', 2 => 'Female', '' => ''];
        @endphp

        <div class="onboarding-content mb-0">
            <table class="table table-borderless mb-2 student-info-table">
                <tr>
                    <td colspan="2" class="serial-cell info-cell">
                        <div class="highlight-serial">
                            SERIAL NO: {{ $result[0]->temporary_id ?? '' }}
                        </div>
                    </td>
                    <td rowspan="3" class="photo-cell">
                        <img src="{{ asset($result[0]->photo ?? '') }}" alt="Student Photo" class="student-photo"
                            onerror="this.src='https://via.placeholder.com/140x140/00ADEF/FFFFFF?text=Photo'">
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="name-cell info-cell">
                        <div class="highlight-name">
                            NAME: {{ strtoupper($result[0]->name_en ?? '') }}
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="guardian-cell info-cell">
                        GUARDIAN: {{ strtoupper($result[0]->gurdian_name ?? '') }}<br>
                        MOBILE: {{ $result[0]->mobile ?? '' }}
                    </td>
                </tr>
            </table>

            <div class="mt-2">
                <div class="info-grid">
                    <div class="info-grid-item">
                        <span class="info-label">Version:</span>
                        <span class="info-value">
                            @if ($result[0]->version_id == 1)
                                Bangla
                            @else
                                English
                            @endif
                        </span>
                    </div>

                    <div class="info-grid-item">
                        <span class="info-label">Shift:</span>
                        <span class="info-value">
                            @if ($result[0]->shift_id == 1)
                                Morning
                            @else
                                Day
                            @endif
                        </span>
                    </div>

                    <div class="info-grid-item">
                        <span class="info-label">Date of Birth:</span>
                        <span class="info-value">{{ $result[0]->dob ?? '' }}</span>
                    </div>

                    <div class="info-grid-item">
                        <span class="info-label">Gender:</span>
                        <span class="info-value">{{ $gender[$result[0]->gender] ?? '' }}</span>
                    </div>

                    <div class="info-grid-item" style="grid-column: span 2;">
                        <span class="info-label">Birth Registration:</span>
                        <span class="info-value">{{ $result[0]->birth_registration_number ?? '' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer border-0">
        <button type="button" class="btn-close-modal" data-bs-dismiss="modal">Close</button>
    </div>
</div>
