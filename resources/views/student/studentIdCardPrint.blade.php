<!DOCTYPE html>
<html>

<head>
    <title>Student ID Card</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" rel="stylesheet" />
</head>

<style>
    @media print {
        @import url('https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css');
    }

    .text-sm {
        font-size: 12px;
    }

    .text-xl {
        font-size: 19px;
    }
</style>

<body class="flex flex-wrap items-center justify-center min-h-screen bg-gray-100 font-sans">
    @foreach ($students->chunk(1) as $studentPair)
        <div class="page-break w-full flex justify-center space-x-8 mb-8">
            @foreach ($studentPair as $student)
                <div class="bg-white pt-4 pb-4 rounded-lg shadow-lg w-[320px] h-[490px]">
                    <div class="flex items-start gap-1">
                        <img alt="BAF Shaheen College Dhaka logo" class="h-12 w-12 mt-1"
                            src="{{ asset('public/frontend/uploads/school_content/logo/front_logo-608ff44a5f8f07.35255544.png') }}" />
                        <div class="text-center">
                            <h1 class="text-xl font-bold text-left">BAF Shaheen College Dhaka</h1>
                            <p class="text-sm">Dhaka Cantonment, Dhaka - 1206</p>
                            <p class="text-sm text-left">Email: info@bafsd.edu.bd || Cell: 01769975771</p>
                        </div>
                    </div>

                    <div class="flex justify-center my-2">
                        <img alt="Student photo" class="border-2 border-blue-500 w-[130px] h-[150px] object-cover"
                            style="object-position: top center;"
                            src="{{ $student->photo ? $student->photo : asset('public/student.png') }}" />
                    </div>

                    <div class="text-center rounded">
                        <p class="font-bold inline-block bg-red-500 text-white px-3 py-1 rounded">
                            Student ID: {{ $student->student_code }}
                        </p>
                    </div>
                    <div class="text-center my-1">
                        <h2 class="text-lg font-bold text-blue-600">{{ strtoupper($student->first_name) }}</h2>
                    </div>

                    <div style="position: relative;">
                        <div class="absolute inset-0 flex items-center justify-center opacity-10"
                            style="
                    background-image: url('{{ asset('public/frontend/uploads/school_content/logo/front_logo-608ff44a5f8f07.35255544.png') }}');
                    background-size: 58%;
                    background-position: center;
                    top: -44px;
                    background-repeat: no-repeat;">
                        </div>

                        <div class="grid grid-cols-2 gap-1 text-sm px-4">
                            <p><span class="font-bold">Payment ID:</span> {{ $student->PID }}</p>
                            <p><span class="font-bold">Shift:</span>
                                {{ $student->studentActivity->shift_id == 1 ? 'Day' : 'Morning' }}</p>
                            <p><span class="font-bold">Version:</span>
                                {{ $student->studentActivity->version_id == 1 ? 'Bangla' : 'English' }} </p>
                            @if ($student->blood)
                                <p><span class="font-bold">Blood Group:</span> <span style="color: red">
                                        {{ $student->blood }}
                                    </span></p>
                            @endif
                        </div>

                        <p class="text-sm mt-1 px-4"><span class="font-bold">Guardian:</span>
                            {{ ucwords(strtolower($student->local_guardian_name ?? ($student->father_name ?? ($student->mother_name ?? '')))) }}
                        </p>

                        <div class="flex justify-between items-center mt-2 px-4">
                            <div class="text-sm border border-red-500 rounded px-2 py-1"
                                style="letter-spacing: 0.05em;">
                                <p class="font-bold">Validity till: Dec {{ $student->studentActivity->session_id + 1 }}
                                </p>
                            </div>

                            <div class="text-right">
                                <img alt="Signature" class="h-8 mx-auto" src="{{ asset('public/psi.jpg') }}" />
                                <hr>
                                <p class="text-sm border-t border-black">Principal</p>
                            </div>
                        </div>
                    </div>

                    <div class="text-center bg-red-500 text-white py-1 rounded">
                        <p class="font-bold">Emergency Contact: {{ $student->local_guardian_mobile ?? '' }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    @endforeach
</body>

</html>
