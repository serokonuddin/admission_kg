<style>
    .modal-onboarding .onboarding-content {
        margin: 0px 2rem;
    }

    table td {
        text-align: left;
        font-weight: bold;
    }

    .table>:not(caption)>*>* {
        padding: .25rem 1.25rem !important;
    }
</style>
<div class="modal-header border-0">

    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
    </button>
</div>
<div class="modal-body p-0">
    <div class="onboarding-media">

        <h4 style="color: #71DD37"><a class="navbar-brand" href="#"
                style="font-family: algerian!important;font-size:x-large;font-weight: bold;line-height: 18px;color: #00ADEF">{{ $academy_info->academy_name }}</a>
        </h4>
        <h4 style="color: #71DD37;font-weight: bold">KG Admission 2026</h4>
        <p style="text-align: center;color: orange !important;font-size: 18px;font-weight: bold">Congratulation! You Are
            Selected
            @if ($result[0]->watting == 1)
                For Waiting List
            @endif
        </p>
        <div class="mx-2">

        </div>
    </div>
    @php
        $gender = [1 => 'Male', 2 => 'Female', '' => ''];
    @endphp
    <div class="onboarding-content mb-0">
        <table class="table">

            <tr>
                <td colspan="2" style="width: 60%;color:red;font-size: 16px"> Name:
                    {{-- @if ($result[0]->version_id == 2)
                        {{ $result[0]->name_en ?? '' }}
                    @else
                        {{ $result[0]->name_bn ?? '' }}
                    @endif --}}
                    {{ $result[0]->name_en ?? '' }}
                </td>
                <td rowspan="3" style="width: 120px;text-align: center"><img
                        src="{{ asset($result[0]->photo ?? '') }}" alt="girl-unlock-password-light"
                        style="height: 120px;width: auto" class="img-fluid"
                        data-app-dark-img="{{ asset($result[0]->photo) }}"
                        data-app-light-img="{{ asset($result[0]->photo) }}"></td>
            </tr>
            <tr>
                <td style="color: red !important;width: 60%;font-size: 18px" colspan="2">
                    Mobile: {{ $result[0]->mobile ?? '' }}
                </td>

            </tr>
            <tr>
                <td colspan="2" style="width: 60%">
                    Gurdian Name: {{ $result[0]->gurdian_name ?? '' }}
                </td>

            </tr>
            <tr>
                <td style="width: 40%">
                    Version:
                    @if ($result[0]->version_id == 1)
                        Bangla
                    @else
                        English
                    @endif
                </td>
                <td colspan="2" style="width: 60%">
                    Version:
                    @if ($result[0]->shift_id == 1)
                        Morning
                    @else
                        Day
                    @endif
                </td>
            </tr>
            <tr>
                <td style="width: 40%">
                    DOB: {{ $result[0]->dob ?? '' }}
                </td>
                <td colspan="2" style="width: 60%">
                    Birth Number: {{ $result[0]->birth_registration_number ?? '' }}
                </td>
            </tr>

            <tr>
                <td style="width: 40%">
                    Gender: {{ $gender[$result[0]->gender] ?? '' }}
                </td>
                <td colspan="2" style="width: 60%">
                    Serial No: {{ $result[0]->temporary_id ?? '' }}
                </td>
            </tr>

        </table>






    </div>
</div>
<div class="modal-footer border-0">
    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>

</div>
