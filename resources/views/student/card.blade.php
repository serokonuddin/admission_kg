<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .card {
            box-shadow: 0 4px 8px 0 rgb(0, 149, 221);
            max-width: 300px;
            margin: auto;
            text-align: center;
            font-family: arial;
        }

        .title {
            color: grey;
            font-size: 18px;
        }

        a {
            text-decoration: none;
            font-size: 22px;
            color: black;
        }

        h4,
        p {
            margin-block-start: 5px !important;
            margin-block-end: 5px !important;
        }

        .btn {
            --bs-btn-padding-x: 1.25rem;
            --bs-btn-padding-y: 0.4375rem;
            --bs-btn-font-size: 0.9375rem;
            display: inline-block;
            padding: var(--bs-btn-padding-y) var(--bs-btn-padding-x);
            font-size: var(--bs-btn-font-size);
            text-align: center;
            cursor: pointer;
            border: 1px solid;
            background-color: transparent;
            transition: all .2s ease-in-out;
        }

        .btn-outline-primary {
            color: #696cff;
            border-color: #696cff;
        }

        @media print {
            .no-print {
                display: none !important;
            }

            /* Force background colors to appear in print */
            * {
                -webkit-print-color-adjust: exact;
                color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>

<body>

    @foreach ($studentdata as $key => $student)
    <div class="card" id="card" style="padding-top: 3px;">
        <h3 style="text-align:center">Temporary ID Card</h3>

        <!-- Student Photo -->
        <div style="text-align: center; margin-bottom: 3px;">
            <img src="{{ $student->photo }}" alt="Student Photo"
                style="width: 70px; height: 70px; object-fit: cover; border: 1px solid #ddd;">
        </div>

        <!-- Student Details -->
        <div style="font-size: 12px; line-height: 1.4; color: #333;">
            <h4 style="margin: 0 0 5px 0; font-size: 14px; text-align: center;">{{ $student->first_name }}</h4>
            <p style="margin: 0;">Roll: <strong>{{ substr($student->student_code, -4) }}</strong></p>
            <p style="margin: 0;">Class: <strong>{{ $student->activity->classes->class_name ?? '' }}</strong></p>
            <p style="margin: 0;">Version: <strong>{{ $student->activity->version->version_name ?? '' }}</strong></p>
            <p style="margin: 0;">Shift: <strong>{{ $student->activity->shift->shift_name ?? '' }}</strong></p>
            <p style="margin: 0;">Section: <strong>{{ $student->activity->section->section_name ?? '' }}</strong></p>
            <p style="margin: 0;">Guardian No: <strong>{{ $student->mobile ?? 'N/A' }}</strong></p>
            <p style="margin: 0; color: red;">Blood Group: <strong>{{ $student->blood ?? 'N/A' }}</strong></p>
        </div>

        <!-- QR Code -->
        <div style="text-align: center; margin-top: 5px;">
            {!! $student->qrCode !!}
        </div>

        <p style="background-color: rgb(0,149,221); padding: 10px; color: white; text-align: center;">
            BAF Shaheen College Dhaka<br>
            <span style="font-size: 12px;">Dhaka Cantonment, Dhaka-1206</span>
        </p>
    </div>
    @endforeach

    <div style="text-align:center">
        <a class="btn btn-outline-primary no-print" href="{{ route('StudentProfile', 0) }}">Back</a>
        <button onclick="printFullPage()" class="btn btn-outline-primary no-print">Print</button>
    </div>

    <script>
        function printFullPage() {
            window.print();
        }
    </script>
</body>

</html>
