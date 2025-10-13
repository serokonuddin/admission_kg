<?php

namespace App\Http\Controllers;

use App\Exports\PidFormatExport;
use App\Exports\StudentsExport;
use App\Imports\StudentsPIDImports;
use App\Imports\StudentsSubjectImports;
use App\Http\Controllers\NoticeController;
use App\Http\Requests\Admission\AdmissionStoreRequest;
use App\Http\Requests\CollegeStudentStoreRequest;
use App\Http\Requests\Student\StudentStoreRequest;
use App\Imports\BoardResultImport;
use App\Imports\StudentBasicInfoUpload;
use App\Models\Attendance\Attendance;
use App\Models\sttings\Sessions;
use App\Models\sttings\Shifts;
use Illuminate\Support\Facades\File;
use App\Models\Website\Notice;
use App\Models\sttings\Classes;
use App\Models\sttings\Sections;
use App\Models\Employee\EmployeeActivity;
use App\Models\sttings\Versions;
use App\Models\Finance\StudentFeeTansaction;
use App\Models\Finance\StudentHeadWiseFee;
use App\Models\Fee;
use App\Models\Syllabus;
use App\Models\Student\Student;
use App\Models\sttings\ClassWiseSubject;
use App\Models\Student\StudentActivity;
use App\Models\sttings\Category;
use App\Models\User;
use Illuminate\Http\Request;
use App\Imports\StudentsImports;
use App\Models\Employee\Employee;
use App\Models\Student\BoardResult;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Student\StudentSubjects;
use App\Models\Student\TcInactive;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

use function Laravel\Prompts\table;

ini_set('max_execution_time', 36000); // 3600 seconds = 60 minutes
set_time_limit(36000);
class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        // Set session values for active menu and submenu
        Session::put('activemenu', 'student');
        Session::put('activesubmenu', 'si');

        // Fetch necessary dropdown data
        $sessions = Sessions::get();
        $versions = Versions::where('active', 1)->get();
        $shifts = Shifts::where('active', 1)->get();
        $version_for = Auth::user()->version_id;
        $shift_for = Auth::user()->shift_id;
        if ($version_for) {
            $versions = Versions::where('active', 1)
                ->where('id', $version_for)
                ->get();
        }
        if ($shift_for) {
            $shifts = Shifts::where('active', 1)
                ->where('id', $shift_for)
                ->get();
        }
        $classes = Classes::where('active', 1)
            ->when($request->session_id, function ($query, $session_id) {
                return $query->where('session_id', $session_id);
            })
            ->when($request->shift_id, function ($query, $shift_id) {
                return $query->where('shift_id', $shift_id);
            })
            ->when($request->version_id, function ($query, $version_id) {
                return $query->where('version_id', $version_id);
            })
            ->get();

        $sections = Sections::where('active', 1)
            ->when($request->class_code, function ($query, $class_code) {
                return $query->where('class_code', $class_code);
            })
            ->when($request->version_id, function ($query, $version_id) {
                return $query->where('version_id', $version_id);
            })
            ->when($request->shift_id, function ($query, $shift_id) {
                return $query->where('shift_id', $shift_id);
            })
            ->get();

        // Initialize variables for filters
        $sessionID = $request->session_id;
        $versionID = $request->version_id;
        $shiftID = $request->shift_id;
        $classCode = $request->class_code;
        $sectionID = $request->section_id;
        $page_size = $request->get('page_size', 50); // Default to 50 if not provided

        $students = collect(); // Default empty collection

        if ($request->hasAny(['session_id', 'version_id', 'shift_id', 'class_code', 'section_id', 'text_search', 'search'])) {

            // Start building the student query
            $studentsQuery = Student::join('student_activity', 'students.student_code', '=', 'student_activity.student_code')
                ->where('students.active', 1)->where('student_activity.active', 1)
                ->select('students.*', 'student_activity.section_id', 'student_activity.roll', 'student_activity.class_code', 'student_activity.active', 'student_activity.session_id', 'student_activity.version_id', 'student_activity.shift_id');
            // if (Auth::user()->class_id) {
            //     $studentsQuery->whereIn('student_activity.class_id', implode(',', Auth::user()->class_id));
            // }
            // if (Auth::user()->version_id) {
            //     $studentsQuery->where('student_activity.version_id', Auth::user()->version_id);
            // }
            // if (Auth::user()->shift_id) {
            //     $studentsQuery->where('student_activity.shift_id', Auth::user()->shift_id);
            // }
            // Apply filters step by step
            if ($sectionID) {
                $studentsQuery->where('student_activity.section_id', $sectionID);
            }

            if ($sessionID) {
                $studentsQuery->where('student_activity.session_id', $sessionID);
            }

            if ($versionID) {
                $studentsQuery->where('student_activity.version_id', $versionID);
            }

            if ($shiftID) {
                $studentsQuery->where('student_activity.shift_id', $shiftID);
            }

            if ($request->class_code == '0') {
                $studentsQuery->where('student_activity.class_code', 0);
            } elseif ($request->class_code) {
                $studentsQuery->where('student_activity.class_code', $request->class_code);
            }

            // Apply text search filter
            if ($request->text_search) {
                $studentsQuery->where(function ($query) use ($request) {
                    $query->where('students.first_name', 'like', '%' . $request->text_search . '%')
                        ->orWhere('students.student_code', 'like', '%' . $request->text_search . '%')
                        ->orWhere('students.mobile', 'like', '%' . $request->text_search . '%')
                        ->orWhere('students.email', 'like', '%' . $request->text_search . '%')
                        ->orWhere('students.sms_notification', 'like', '%' . $request->text_search . '%')
                        ->orWhere('students.PID', 'like', '%' . $request->text_search . '%');
                });
            }

            // Fetch and paginate the filtered data
            $students = $studentsQuery->orderBy('student_activity.roll', 'asc')
                ->paginate($page_size); // Order by roll
            //->paginate($page_size); // Use the dynamic page size

        }

        // Render AJAX pagination if requested
        if ($request->ajax()) {
            return view('student.pagination', compact('students'))->render();
        }

        // Render main student view
        $createdBy = Auth::user()->name;

        return view('student.student', compact('students', 'sessions', 'versions', 'shifts', 'classes', 'sections', 'createdBy', 'version_for', 'shift_for'));
    }
    public function saveDisciplinaryIssues(Request $request)
    {
        $request->validate([
            'photo' => 'required|mimes:jpg,jpeg,pdf|max:2000', // max size in KB
            'details' => 'required|string',
            'student_code' => 'required|exists:students,id',
        ]);

        // Handle file upload
        if ($request->hasFile('photo')) {
            // Define the destination path
            $destinationPath = 'disciplinary/';
            $imageDirectory = public_path($destinationPath);

            // Ensure the directory exists, create it if not
            if (!File::exists($imageDirectory)) {
                File::makeDirectory($imageDirectory, 0755, true);
            }

            // Define the image filename
            $myimage = time() . $request->student_code . $request->photo->getClientOriginalName();
            $imagePath = $imageDirectory . '/' . $myimage;

            try {
                // Load the image
                $image = Image::make($request->photo);

                // Resize and crop to ensure 600x600 dimension (passport size)
                // $image->fit(600, 600); // Fit the image to 600x600, cropping excess
                // $image->fit(600, 600, function ($constraint) {
                //     $constraint->upsize(); // Prevent upscaling
                // }, 'top'); // Fit the image to 600x600, cropping excess from center

                // Compress the image to reduce file size (80% quality)
                $image->save($imagePath); // Save with 80% quality for compression

                // Get the asset URL for the photo
                $photo = $destinationPath . '/' . $myimage;
            } catch (Exception $e) {

                $photo = ''; // Fallback to the old photo
                return response()->json(['message' => 'Disciplinary issue file not found'], 404);
            }
        } else {
            return response()->json(['message' => 'Disciplinary issue file not found'], 404);
        }

        // Save to database (example model: DisciplinaryIssue)
        \App\Models\DisciplinaryIssue::create([
            'student_code' => $request->student_code,
            'file_path' => $photo ?? null,
            'details' => $request->details,
            'date' => date('Y-m-d'),
            'created_by' => Auth::user(),
        ]);
        return response()->json(['message' => 'Disciplinary issue saved successfully'], 200);
    }
    public function studentSearchByClass(Request $request)
    {
        $version_id = $request->version_id;
        $session_id = $request->session_id;
        $shift_id = $request->shift_id;
        $class_id = $request->class_id;
        $group_id = $request->group_id;
        $amount = $request->amount;
        $students = Student::where('students.active', 1)
            ->join('student_activity', 'student_activity.student_code', '=', 'students.student_code')
            ->with([
                'studentActivity.session',
                'studentActivity.version',
                'studentActivity.shift',
                'studentActivity.classes',
                'studentActivity.group',
                'studentActivity.section'
            ]);

        $students = $students->whereIn('students.student_code', function ($row) use ($group_id, $session_id, $version_id, $shift_id, $class_id) {
            $row->select('student_code')
                ->from('student_activity');
            if ($session_id) {

                $row->whereRaw('session_id = "' . $session_id . '"');
            }
            if ($version_id) {
                $row->whereRaw('version_id = "' . $version_id . '"');
            }
            if ($shift_id) {
                $row->whereRaw('shift_id = "' . $shift_id . '"');
            }
            if ($class_id) {
                $row->whereRaw('class_id = "' . $class_id . '"');
            }
            if ($group_id) {
                $row->whereRaw('group_id = "' . $group_id . '"');
            }
        });

        $students = $students->orderBy('section_id', 'asc')->orderBy('roll', 'asc');
        $students = $students->get();
        return view('student.ajaxstudent', compact('students', 'amount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Session::put('activemenu', 'student');
        Session::put('activesubmenu', 'se');
        $sessions = Sessions::get();
        $versions = Versions::where('active', 1)->get();
        $shifts = Shifts::where('active', 1)->get();
        $districts = DB::table('districts')->get();
        $groups = DB::table('academygroups')->get();
        $classes = array();
        $sections = array();
        $categories = Category::where('active', 1)->where('type', 2)->get();

        return view('student.create', compact('sessions', 'versions', 'groups', 'shifts', 'categories', 'districts', 'sections', 'classes'));
    }

    public function student2()
    {
        Session::put('activemenu', 'student');
        Session::put('activesubmenu', 'se2');
        $sessions = Sessions::where('active', 1)->get();
        $versions = Versions::where('active', 1)->get();
        $shifts = Shifts::where('active', 1)->get();
        $districts = DB::table('districts')->get();
        $groups = DB::table('academygroups')->get();
        $classes = array();
        $sections = array();
        $categories = Category::where('active', 1)->where('type', 2)->get();

        return view('student.student2', compact('sessions', 'versions', 'groups', 'shifts', 'categories', 'districts', 'sections', 'classes'));
    }
    public function import()
    {
        Excel::import(new StudentsImports, 'xl/students.xlsx');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function addScienceSection($gender, $third_subject, $class_id, $fourth_subject, $student_code, $session_id, $version_id, $check)
    {
        if ($version_id == 1 && $gender == 1) {
            $section = Sections::where('version_id', $version_id)->where('group_id', 1)->where('class_id', 59)->where('is_full', 0)->orderBy('serial', 'asc')->first();
        } elseif ($version_id == 1 && $gender == 2) {
            $section = Sections::where('version_id', $version_id)->where('group_id', 1)->where('class_id', 59)->where('is_female_full', 0)->orderBy('serial', 'asc')->first();
        } elseif ($version_id == 2 && $gender == 1) {
            $section = Sections::where('version_id', $version_id)->where('group_id', 1)->where('class_id', 59)->where('is_full', 0)->orderBy('serial', 'asc')->first();
        } elseif ($version_id == 2 && $gender == 2) {
            $section = Sections::where('version_id', $version_id)->where('group_id', 1)->where('class_id', 59)->where('is_female_full', 0)->orderBy('serial', 'asc')->first();
        }

        //dd($third_subject,$fourth_subject);

        $thirdsubject = explode('-', $third_subject[0]);
        $fourthsubjectarray = explode('-', $fourth_subject[0]);
        sort($fourthsubjectarray);

        $fourthsubjectdata = array_unique($fourthsubjectarray);

        $i = 0;
        $fourthsubject = [];
        foreach ($fourthsubjectdata as $subject) {
            $fourthsubject[$i++] = $subject;
        }
        //if($fourthsubject[0]==70){
        //	$fourthsubject[0]=69;
        //	$fourthsubject[1]=70;
        //}
        $section_id = 0;
        if ($version_id == 1) {

            if ($thirdsubject[0] == 70 && $fourthsubject[0] == 71) {
                $section_id = 174;
            } elseif ($fourthsubject[0] == 82) {
                $section_id = 176;
            } elseif ($thirdsubject[0] == 68 && $fourthsubject[0] == 71) {
                $section_id = 175;
            } else {
                if ($section) {
                    $section_id = $section->id;
                } else {
                    $section_id = 174;
                }
            }
        } else {
            if ($thirdsubject[0] == 70 && $fourthsubject[0] == 71) {
                $section_id = 178;
            } elseif ($fourthsubject[0] == 82) {
                $section_id = 173;
            } elseif ($thirdsubject[0] == 68 && $fourthsubject[0] == 71) {
                $section_id = 173;
            } else {
                if ($section) {
                    $section_id = $section->id;
                } else {
                    $section_id = 173;
                }
            }
        }

        if ($check == 'check') {
            return $section_id;
        }
        $section = Sections::where('id', $section_id)->first();
        $studentCount = StudentActivity::where('class_id', 11)
            ->join('students', 'students.student_code', '=', 'student_activity.student_code')
            ->where('student_activity.section_id', $section_id)
            ->where('student_activity.session_id', $session_id)
            ->where('student_activity.version_id', $version_id)
            ->where('students.gender', $gender)
            ->where('student_activity.active', 1)
            ->count();
        $studenttCount = StudentActivity::where('class_id', 11)
            ->where('student_activity.section_id', $section_id)
            ->where('student_activity.session_id', $session_id)
            ->where('student_activity.version_id', $version_id)
            ->where('student_activity.active', 1)
            ->count();
        if ($section->male == $studentCount + 1 && $gender == 1) {

            $sectiondata = array(
                'is_full' => 1
            );

            DB::table('sections')->where('id', $section->id)->update($sectiondata);
        } elseif ($section->female == $studentCount + 1 && $gender == 2) {
            $sectiondata = array(
                'is_female_full' => 1
            );
            DB::table('sections')->where('id', $section->id)->update($sectiondata);
        } elseif ($section->student_number == $studenttCount + 1) {
            $sectiondata = array(
                'is_female_full' => 1,
                'is_full' => 1
            );
            DB::table('sections')->where('id', $section->id)->update($sectiondata);
        }

        $studentSectionUpdate = array('section_id' => $section_id);
        DB::table('admission_temporary')->where('session_id', $session_id)->where('student_code', $student_code)->update(['section_id' => $section_id]);
        StudentActivity::where('session_id', $session_id)->where('student_code', $student_code)->update($studentSectionUpdate);
        return 1;
    }

    public function addCommerceSection($gender, $third_subject, $class_id, $fourth_subject, $student_code, $session_id, $version_id, $check)
    {

        if ($version_id == 1 && $gender == 1) {
            $section = Sections::where('version_id', $version_id)->where('group_id', 3)->where('class_id', 59)->where('is_full', 0)->orderBy('serial', 'asc')->first();
        } elseif ($version_id == 1 && $gender == 2) {
            $section = Sections::where('version_id', $version_id)->where('group_id', 3)->where('class_id', 59)->where('is_female_full', 0)->orderBy('serial', 'asc')->first();
        } elseif ($version_id == 2) {
            $section = Sections::where('version_id', $version_id)->where('group_id', 3)->where('class_id', 59)->orderBy('serial', 'asc')->first();
        }

        $thirdsubject = explode('-', $third_subject[0]);
        $fourthsubjectarray = explode('-', $fourth_subject[0]);
        sort($fourthsubjectarray);

        $fourthsubjectdata = array_unique($fourthsubjectarray);

        $i = 0;
        $fourthsubject = [];
        foreach ($fourthsubjectdata as $subject) {
            $fourthsubject[$i++] = $subject;
        }

        $section_id = 0;
        if ($version_id == 1) {
            if ($fourthsubject[0] == 82 || $fourthsubject[1] == 82) {
                $section_id = 182;
            } else if ($fourthsubject[0] == 73 || $fourthsubject[1] == 73) {
                $section_id = 182;
            } else {
                $section_id = $section->id;
            }
        } else {
            $section_id = $section->id;
        }

        if ($check == 'check') {
            return $section_id;
        }
        $section = Sections::where('id', $section_id)->first();
        $studentCount = StudentActivity::where('class_id', 11)
            ->join('students', 'students.student_code', '=', 'student_activity.student_code')
            ->where('student_activity.section_id', $section_id)
            ->where('student_activity.session_id', $session_id)
            ->where('student_activity.version_id', $version_id)
            ->where('students.gender', $gender)
            ->where('student_activity.active', 1)
            ->count();
        $studenttCount = StudentActivity::where('class_id', 11)
            ->where('student_activity.section_id', $section_id)
            ->where('student_activity.session_id', $session_id)
            ->where('student_activity.version_id', $version_id)
            ->where('student_activity.active', 1)
            ->count();
        if ($section->male == $studentCount + 1 && $gender == 1) {

            $sectiondata = array(
                'is_full' => 1
            );

            DB::table('sections')->where('id', $section->id)->update($sectiondata);
        } elseif ($section->female == $studentCount + 1 && $gender == 2) {
            $sectiondata = array(
                'is_female_full' => 1
            );
            DB::table('sections')->where('id', $section->id)->update($sectiondata);
        } elseif ($section->student_number == $studenttCount + 1) {
            $sectiondata = array(
                'is_female_full' => 1,
                'is_full' => 1
            );
            DB::table('sections')->where('id', $section->id)->update($sectiondata);
        }

        $studentSectionUpdate = array('section_id' => $section_id);
        DB::table('admission_temporary')->where('session_id', $session_id)->where('student_code', $student_code)->update(['section_id' => $section_id]);
        StudentActivity::where('session_id', $session_id)->where('student_code', $student_code)->update($studentSectionUpdate);
        return 1;
    }

    public function addArtsSection($gender, $third_subject, $class_id, $fourth_subject, $student_code, $session_id, $version_id, $check)
    {

        if ($version_id == 1 && $gender == 1) {
            $section = Sections::where('version_id', $version_id)->where('group_id', 2)->where('class_id', 59)->where('is_full', 0)->orderBy('serial', 'asc')->first();
        } else {
            $section = Sections::where('version_id', $version_id)->where('group_id', 2)->where('class_id', 59)->where('is_female_full', 0)->orderBy('serial', 'asc')->first();
        }


        $thirdsubject = explode('-', $third_subject[0]);

        $thirdsubjectarray = explode('-', $third_subject[0]);
        sort($thirdsubjectarray);

        $thirdsubjectdata = array_unique($thirdsubjectarray);

        $i = 0;
        $thirdsubject = [];
        foreach ($thirdsubjectdata as $subject) {
            $thirdsubject[$i++] = $subject;
        }

        $fourthsubjectarray = explode('-', $fourth_subject[0]);
        sort($fourthsubjectarray);

        $fourthsubjectdata = array_unique($fourthsubjectarray);

        $i = 0;
        $fourthsubject = [];
        foreach ($fourthsubjectdata as $subject) {
            $fourthsubject[$i++] = $subject;
        }
        //dd($thirdsubject[1],$fourthsubject);
        $section_id = 0;
        if ($thirdsubject[0] == 89 || $thirdsubject[1] == 89) {
            $section_id = 186;
        } else if ($fourthsubject[0] == 73 || $fourthsubject[1] == 73) {
            $section_id = 187;
        } else {
            if ($section) {
                $section_id = $section->id;
            } else {
                $section_id = 186;
            }
        }
        //dd($section_id);
        if ($check == 'check') {
            return $section_id;
        }
        $section = Sections::where('id', $section_id)->first();
        $studentCount = StudentActivity::where('class_id', 11)
            ->join('students', 'students.student_code', '=', 'student_activity.student_code')
            ->where('student_activity.section_id', $section_id)
            ->where('student_activity.session_id', $session_id)
            ->where('student_activity.version_id', $version_id)
            ->where('students.gender', $gender)
            ->where('student_activity.active', 1)
            ->count();
        $studenttCount = StudentActivity::where('class_id', 11)
            ->where('student_activity.section_id', $section_id)
            ->where('student_activity.session_id', $session_id)
            ->where('student_activity.version_id', $version_id)
            ->where('student_activity.active', 1)
            ->count();
        if ($section->male == $studentCount + 1 && $gender == 1) {

            $sectiondata = array(
                'is_full' => 1
            );

            DB::table('sections')->where('id', $section->id)->update($sectiondata);
        } elseif ($section->female == $studentCount + 1 && $gender == 2) {
            $sectiondata = array(
                'is_female_full' => 1
            );
            DB::table('sections')->where('id', $section->id)->update($sectiondata);
        } elseif ($section->student_number == $studenttCount + 1) {
            $sectiondata = array(
                'is_female_full' => 1,
                'is_full' => 1
            );
            DB::table('sections')->where('id', $section->id)->update($sectiondata);
        }

        $studentSectionUpdate = array('section_id' => $section_id);
        DB::table('admission_temporary')->where('session_id', $session_id)->where('student_code', $student_code)->update(['section_id' => $section_id]);
        StudentActivity::where('session_id', $session_id)->where('student_code', $student_code)->update($studentSectionUpdate);
        return 1;
    }
    public function addsection($gender, $third_subject, $fourth_subject, $class_id, $group_id, $student_code, $session_id, $version_id, $check = '')
    {
        if ($group_id == 1) {
            return $this->addScienceSection($gender, $third_subject, $class_id, $fourth_subject, $student_code, $session_id, $version_id, $check);
        } else if ($group_id == 2) {
            return $this->addArtsSection($gender, $third_subject, $class_id, $fourth_subject, $student_code, $session_id, $version_id, $check);
        } else {
            return $this->addCommerceSection($gender, $third_subject, $class_id, $fourth_subject, $student_code, $session_id, $version_id, $check);
        }
    }
    public function checksection(Request $request)
    {

        $third_subject = $request->third_subject;
        $fourth_subject = $request->fourth_subject;
        $class_id = $request->class_id;
        $group_id = $request->group_id;
        $gender = $request->gender;
        $student_code = $request->student_code;
        $session_id = $request->session_id;
        $version_id = $request->version_id;
        return $this->addsection($gender, $third_subject, $fourth_subject, $class_id, $group_id, $student_code, $session_id, $version_id, 'check');
    }

    public function getLastRoll(Request $request)
    {
        $shift_id = $request->shift_id;
        $version_id = $request->version_id;
        $class_id = $request->class_id;
        $session_id = $request->session_id;
        $section_id = $request->section_id;

        // You need to adjust the query based on your database schema and logic.
        $lastRoll = StudentActivity::where('shift_id', $shift_id)
            ->where('version_id', $version_id)
            ->where('class_id', $class_id)
            ->where('session_id', $session_id)
            ->where('section_id', $section_id)
            ->orderBy('roll', 'desc')
            ->first();

        // If no roll exists, return 1 (or any other default value)
        return response()->json($lastRoll ? $lastRoll->roll + 1 : 1);
    }

    public function store(StudentStoreRequest $request)
    {
        try {
            // Proceed with file handling and saving logic...
            $classdata = Classes::where('id', (int) $request->class_id)->first();
            $sessiondata = Sessions::where('id', $request->session_id)->first();

            // Convert birthdate to database format
            $birthdate = $request->birthdate
                ? Carbon::createFromFormat('d/m/Y', $request->birthdate)->format('Y-m-d')
                : null;


            // File Uploads
            $photo = $this->uploadFile($request, 'photo', 'photo_old', 'student/' . $sessiondata->session_name . '/' . $request->class_id);
            $testimonial = $this->uploadFile($request, 'testimonial', 'testimonial_old', 'testimonial/' . $sessiondata->session_name . '/' . $request->class_id);
            $academic_transcript = $this->uploadFile($request, 'academic_transcript', 'academic_transcript_old', 'academic_transcript/' . $sessiondata->session_name . '/' . $request->class_id);
            $birth_certificate = $this->uploadFile($request, 'birth_certificate', 'birth_certificate_old', 'birth_certificate/' . $sessiondata->session_name . '/' . $request->class_id);
            $text = '';
            if ($request->student_code != 0) {
                // Update existing student logic
                $activity = StudentActivity::where('student_code', $request->student_code)
                    ->where('session_id', $request->session_id)
                    ->where('active', 1)
                    ->first();

                $student = $request->except([
                    '_token',
                    'student_code',
                    'photo_old',
                    'testimonial_old',
                    'academic_transcript_old',
                    'birth_certificate_old',
                    'roll',
                    'mainsubject',
                    'third_subject',
                    'fourth_subject',
                    '_method',
                    'session_id',
                    'version_id',
                    'shift_id',
                    'class_id',
                    'group_id',
                    'category_id',
                    'section_id',
                    'old_photo',
                    'old_birth_certificate',
                    'present_district_id',
                    'permanent_district_id',
                ]);
                //$student['photo'] = $photo;
                //$student['birthdate'] = $birthdate;
                //$student['testimonial'] = $testimonial;
                //$student['academic_transcript'] = $academic_transcript;
                //$student['birth_certificate'] = $birth_certificate;
                $student['updated_by'] = Auth::user()->id;
                $student['updated_at'] = now();

                DB::table('students')->where('student_code', $request->student_code)->update($student);
                $activity->updated_by = Auth::user()->id;
                $activity->save();

                $text = 'Student has been updated successfully';
            } else {
                // New student logic
                $activity = new StudentActivity();
                $activity->session_id = $request->session_id;
                $activity->version_id = $request->version_id;
                $activity->shift_id = $request->shift_id;
                $activity->class_id = $request->class_id;
                $activity->class_code = $request->class_id;
                $activity->group_id = $request->group_id;
                $activity->section_id = $request->section_id;
                $activity->category_id = $request->category_id;
                $activity->roll = $request->roll;
                $activity->house_id = $this->housenumber($request->class_id, $request->gender);
                $activity->active = 1;

                $student = $request->except([
                    '_token',
                    'id',
                    'roll',
                    '_method',
                    'photo_old',
                    'testimonial_old',
                    'academic_transcript_old',
                    'birth_certificate_old',
                    'session_id',
                    'version_id',
                    'shift_id',
                    'class_id',
                    'group_id',
                    'section_id',
                    'old_photo',
                    'old_birth_certificate',
                    'present_district_id',
                    'permanent_district_id',
                ]);
                //$student['photo'] = $photo;
                //$student['birthdate'] = $birthdate;
                //$student['testimonial'] = $testimonial;
                //$student['academic_transcript'] = $academic_transcript;
                //$student['birth_certificate'] = $birth_certificate;
                $student['active'] = 1;

                $activity->created_by = Auth::user()->id;
                $id = DB::table('students')->insertGetId($student);
                $activity->student_code = date('Y') . $request->roll;
                $activity->save();

                $sudentdata = Student::find($id);
                $sudentdata->student_code = date('Y') . $request->roll;
                $sudentdata->save();
                $text = 'Student has been saved successfully';
            }

            // Additional logic for class 59
            if ($activity->class_id == 59) {
                $this->addsubject($request->mainsubject, $request->third_subject, $request->fourth_subject, $request->student_code, $activity->session_id);
            }

            // Store the success message in the session for Toastr
            // session()->flash('success', $text);

            // Redirect to the students index page with success message
            return redirect()->route('students.index')->with('success', $text);
        } catch (\Exception $e) {
            // Store error message in the session for Toastr
            session()->flash('error', $e->getMessage());
            return back()->withInput();
        }
    }


    public function show($id)
    {
        // dd($id);
        if ($id != 0) {

            $studentdata = Student::where('id', $id)->first();
            // dd($studentdata);

            $activity = StudentActivity::with('classes')
                ->where('student_code', $studentdata->student_code)
                ->where('active', 1)
                ->orderBy('id', 'desc')
                ->first();
            //$studentdata=array();
            $classes = Classes::where('session_id', $activity->session_id)
                ->where('class_code', $activity->class_code)
                ->get();
            $sections = Sections::where('class_code', $activity->class_code)->get();
        } else {

            // $student=Student::where('local_guardian_mobile',Auth::user()->phone)->get();

            $studentdata = DB::select('SELECT * FROM `students` WHERE `student_code` LIKE "' . Auth::user()->ref_id . '" order by id desc LIMIT 1');
            //dd($studentdata);
            if (count($studentdata) > 1) {
                $student = $studentdata;
            } else {
                $student = $studentdata[0];
            }
            $activity = StudentActivity::where('student_code', $studentdata[0]->student_code)->orderBy('id', 'desc')->first();

            $id = $studentdata[0]->id;
            $classes = Classes::where('session_id', $activity->session_id)
                ->where('class_code', $activity->class_code)
                ->get();
            $sections = Sections::where('class_code', $activity->class_code)->get();
        }

        Session::put('activemenu', 'profile');
        Session::put('activesubmenu', 'sc');
        $sessions = Sessions::where('active', 1)->get();
        $versions = Versions::where('active', 1)->get();
        $shifts = Shifts::where('active', 1)->get();
        $districts = DB::table('districts')->get();
        $groups = DB::table('academygroups')->get();
        $houses = DB::table('houses')->get();

        $categories = Category::where('active', 1)->where('type', 2)->get();
        if ($activity->classes->class_code == '11' || $activity->classes->class_code == '12') {

            $comsubjects = ClassWiseSubject::where('class_wise_subject.active', 1)
                ->join('classes', 'classes.id', '=', 'class_wise_subject.class_id')
                ->join('subjects', 'subjects.id', '=', 'class_wise_subject.subject_id')
                ->select('subjects.*', 'class_wise_subject.subject_code')
                ->where('subject_type', 1)->with('subject')->where('class_wise_subject.class_code', $activity->classes->class_code)->orderBy('class_wise_subject.subject_code', 'asc')->get();
            $comsubjects = collect($comsubjects->groupBy('parent_subject'));
            $groupsubjects = ClassWiseSubject::where('class_wise_subject.active', 1)
                ->join('classes', 'classes.class_code', '=', 'class_wise_subject.class_code')
                ->join('subjects', 'subjects.id', '=', 'class_wise_subject.subject_id')
                ->where('group_id', $activity->group_id)
                ->select('subjects.*', 'class_wise_subject.subject_code')
                ->where('subject_type', 2)->where('class_wise_subject.class_code', $activity->classes->class_code)->orderBy('class_wise_subject.subject_code', 'asc')->get();

            $groupsubjects = collect($groupsubjects->groupBy('parent_subject'));
            $optionalsubjects = ClassWiseSubject::where('class_wise_subject.active', 1)
                ->join('classes', 'classes.class_code', '=', 'class_wise_subject.class_code')
                ->join('subjects', 'subjects.id', '=', 'class_wise_subject.subject_id')
                ->where('group_id', $activity->group_id)
                ->select('subjects.*', 'class_wise_subject.subject_code')
                ->where('subject_type', 3)->where('class_wise_subject.class_code', $activity->classes->class_code)->orderBy('class_wise_subject.serial', 'asc')->get();
            //dd($groupsubjects);
            $optionalsubjects = collect($optionalsubjects->groupBy('parent_subject'));
            $fourthsubjects = ClassWiseSubject::where('class_wise_subject.active', 1)
                ->join('classes', 'classes.class_code', '=', 'class_wise_subject.class_code')
                ->join('subjects', 'subjects.id', '=', 'class_wise_subject.subject_id')
                ->where('group_id', $activity->group_id)
                ->select('subjects.*', 'class_wise_subject.subject_code');
            if ($activity->version_id == 2) {
                $fourthsubjects = $fourthsubjects->whereNotIn('subject_code', [123, 124]);
            }

            $fourthsubjects = $fourthsubjects->where('subject_type', 4)->where('class_wise_subject.class_code', $activity->classes->class_code)->orderBy('class_wise_subject.serial', 'asc')->get();
            //dd($groupsubjects);
            $fourthsubjects = collect($fourthsubjects->groupBy('parent_subject'));

            $student_third_subject = DB::table('student_subject')
                ->join('subjects', 'subjects.id', '=', 'student_subject.subject_id')
                ->join('class_wise_subject', 'class_wise_subject.subject_id', '=', 'student_subject.subject_id')
                ->where('student_subject.session_id', $activity->session_id)
                ->where('student_subject.student_code', $activity->student_code)
                ->where('is_fourth_subject', 2)
                ->select('subjects.*', 'class_wise_subject.subject_code')
                ->get();
            $student_third_subject = collect($student_third_subject->groupBy('parent_subject'));

            $student_fourth_subject = DB::table('student_subject')
                ->join('subjects', 'subjects.id', '=', 'student_subject.subject_id')
                ->join('class_wise_subject', 'class_wise_subject.subject_id', '=', 'student_subject.subject_id')
                ->where('student_subject.session_id', $activity->session_id)
                ->where('student_subject.student_code', $activity->student_code)
                ->where('is_fourth_subject', 1)
                ->select('subjects.*', 'class_wise_subject.subject_code')
                ->get();
            $student_fourth_subject = collect($student_fourth_subject->groupBy('parent_subject'));
        } else {
            $comsubjects = array();
            $groupsubjects = array();
            $optionalsubjects = array();
            $fourthsubjects = array();
            $student_third_subject = array();
            $student_fourth_subject = array();
        }

        // $subjects=collect($subjects)->groupBy('subject_type');
        // dd($subjects);
        //return view('student.details_view_student',compact('sessions','houses','fourthsubjects','student_third_subject','student_fourth_subject','comsubjects','groupsubjects','optionalsubjects','studentdata','groups','versions','shifts','categories','districts','sections','classes','student','activity','id'));
        // dd($studentdata);
        //$checkarray=$this->isOneDimensional($studentdata);

        if (isset($studentdata[0]->submit)) {

            $submit = $studentdata[0]->submit;
            $studentdata = $studentdata[0];
            $student = $studentdata;
        } else {
            $submit = $studentdata->submit;
            $student = $studentdata;
        }


        // if ($activity->classes->class_code == '11' && $submit != 2) {

        //     return view('student.studentAdmissionNew', compact('sessions', 'houses', 'fourthsubjects', 'student_third_subject', 'student_fourth_subject', 'comsubjects', 'groupsubjects', 'optionalsubjects', 'studentdata', 'groups', 'versions', 'shifts', 'categories', 'districts', 'sections', 'classes', 'student', 'activity', 'id'));
        // } elseif ($activity->classes->class_code == '11' || $activity->classes->class_code == '12') {
        //     return view('student.studentAdmissionNew', compact('sessions', 'houses', 'fourthsubjects', 'student_third_subject', 'student_fourth_subject', 'comsubjects', 'groupsubjects', 'optionalsubjects', 'studentdata', 'groups', 'versions', 'shifts', 'categories', 'districts', 'sections', 'classes', 'student', 'activity', 'id'));
        // } else if ($activity->classes->class_code == 0 && $submit != 2) {
        //     return view('student.student_update_kg', compact('sessions', 'houses', 'fourthsubjects', 'student_third_subject', 'student_fourth_subject', 'comsubjects', 'groupsubjects', 'optionalsubjects', 'studentdata', 'groups', 'versions', 'shifts', 'categories', 'districts', 'sections', 'classes', 'student', 'activity', 'id'));
        // } else {

        //     return view('student.student_update', compact('sessions', 'houses', 'fourthsubjects', 'student_third_subject', 'student_fourth_subject', 'comsubjects', 'groupsubjects', 'optionalsubjects', 'studentdata', 'groups', 'versions', 'shifts', 'categories', 'districts', 'sections', 'classes', 'student', 'activity', 'id'));
        // }


        return view('student.details', compact('sessions', 'houses', 'fourthsubjects', 'student_third_subject', 'student_fourth_subject', 'comsubjects', 'groupsubjects', 'optionalsubjects', 'studentdata', 'groups', 'versions', 'shifts', 'categories', 'districts', 'sections', 'classes', 'student', 'activity', 'id'));
    }

    /**
     * File Upload Helper Function
     */
    private function uploadFile($request, $fieldName, $oldFieldName, $destinationPath)
    {
        if ($request->hasFile($fieldName)) {
            if (file_exists($request->$oldFieldName)) {
                unlink($request->$oldFieldName);
            }
            $destinationPath = 'public/' . $destinationPath;
            $fileName = $request->file($fieldName)->getClientOriginalName();
            $request->file($fieldName)->move(public_path($destinationPath), $fileName);
            return asset($destinationPath . '/' . $fileName);
        }
        return $request->$oldFieldName;
    }

    /*
    public function uploadimage(Request $request)
    {

        //dd($request->session_id);
        $classdata = Classes::where('class_code', $request->class_code)->first();
        $sessiondata = Sessions::where('id', $request->session_id)->first();
        if ($request->hasFile('photo')) {
            if (file_exists($request->photo_old)) {
                //unlink($request->photo_old);
            }
            $destinationPath = 'sutdent/' . $sessiondata->session_name . '/' . $classdata->class_code;
            $myimage = $request->student_code . 'photo' . $request->photo->getClientOriginalName();
            $request->photo->move(public_path($destinationPath), $myimage);
            $photo = asset('public/' . $destinationPath) . '/' . $myimage;
        } else {
            $photo = $request->photo_old;
        }
        $student['photo'] = $photo;
        DB::table('students')->where('id', $request->id)->update($student);
        DB::table('users')->where('group_id', 4)->where('ref_id', $request->student_code)->update($student);
        return 1;
    }
	*/
    public function uploadimage(Request $request)
    {
        //dd( $request->all());
        // Validate file type & size (200KB = 200 * 1024 = 204800 bytes)
        $request->validate([
            'photo' => 'mimes:jpg,jpeg|max:200', // size in KB
            'academic_transcript' => 'mimes:jpg,jpeg,pdf|max:200', // size in KB
            'admit_card' => 'mimes:jpg,jpeg,pdf|max:200', // size in KB
            'testimonial' => 'nullable|mimes:jpg,jpeg,pdf|max:200', // size in KB
            'birth_certificate' => 'nullable|mimes:jpg,jpeg,pdf|max:200', // size in KB
            'father_nid' => 'nullable|mimes:jpg,jpeg,pdf|max:200', // size in KB
            'mother_nid' => 'nullable|mimes:jpg,jpeg,pdf|max:200', // size in KB
            'arm_certification' => 'nullable|mimes:jpg,jpeg,pdf|max:200', // size in KB
            'staff_certification' => 'nullable|mimes:jpg,jpeg,pdf|max:200', // size in KB
        ]);

        $classdata = Classes::where('class_code', $request->class_code)->first();
        $sessiondata = Sessions::where('id', $request->session_id)->first();

        if ($request->hasFile('photo')) {
            // Delete old file if exists
            if ($request->photo_old && file_exists(public_path(str_replace(asset(''), '', $request->photo_old)))) {
                // unlink(public_path(str_replace(asset(''), '', $request->photo_old)));
            }

            $destinationPath = 'sutdent/' . $sessiondata->session_name . '/' . $classdata->class_code;

            // Safe unique filename
            $extension = $request->photo->getClientOriginalExtension();
            $myimage = $request->student_code . '_photo_' . time() . '.' . $extension;

            $request->photo->move(public_path($destinationPath), $myimage);

            $photo = asset('public/' . $destinationPath . '/' . $myimage);
        } else {
            $photo = $request->photo_old;
        }

        $student['photo'] = $photo;

        DB::table('students')->where('id', $request->id)->update($student);
        DB::table('users')->where('group_id', 4)->where('ref_id', $request->student_code)->update($student);

        return 1;
    }

    public function stagevalidationcheck($request)
    {
        $rules = [];
        if ($request->stage == 1) {
            $request->validate([
                'student_code' => 'required',
                'id' => 'required',
                'first_name' => 'required',
                'religion' => 'required',
                'nationality' => 'required',
                'mobile' => 'required',
                'gender' => 'required',
                'father_name' => 'required',
                'mother_name' => 'required',
                'local_guardian_name' => 'required',
                'local_guardian_mobile' => 'required',
                'student_relation' => 'required',
                'sms_notification' => 'required',

            ], [
                'required' => ':attribute is required.',
            ]);
        } else if ($request->stage == 2) {
            $request->validate([
                'mainsubject'     => 'required|array',
                'third_subject'   => 'required|array',
                'fourth_subject'  => 'required|array',
            ], [
                'required' => ':attribute is required.',
            ]);
        } else if ($request->stage == 3) {
            if (empty($request->academic_transcript_old)) {
                $rules['academic_transcript'] = 'required';
            }

            // Admit Card check
            if (empty($request->admit_card_old)) {
                $rules['admit_card'] = 'required';
            }
            if (empty($request->registration_number)) {
                $rules['registration_number'] = 'required';
            }

            $request->validate($rules, [
                'academic_transcript.required' => 'SSC Academic transcript is required.',
                'admit_card.required' => 'SSC Admit card is required.',
                'registration_number.required' => 'Registration number is required.',
            ]);
        } else if ($request->stage == 4 && $request->categoryid == 1) {
        } else if ($request->stage == 4 && $request->categoryid == 2) {

            if (empty($request->name)) {
                $rules['name'] = 'required';
            }
            if (empty($request->designation)) {
                $rules['designation'] = 'required';
            }
            if (empty($request->service_number)) {
                $rules['service_number'] = 'required';
            }
            if (empty($request->arms_name)) {
                $rules['arms_name'] = 'required';
            }
            if (empty($request->name)) {
                $rules['is_service'] = 'required';
            }
            if (empty($request->arm_certification_old)) {
                $rules['arm_certification'] = 'required';
            }
            $request->validate($rules, [
                'name.required' => 'Name of Service Holder is required.',
                'designation.required' => 'Rank/Designation is required.',
                'service_number.required' => 'Service number is required.',
                'arms_name.required' => 'Name of Service is required.',
                'is_service.required' => 'Service/Retired is required.',
                'office_address.required' => 'Present Office Address is required.',
                'arm_certification.required' => 'Certification/Testimonial from office is required.',
            ]);
        } else if ($request->stage == 4 && $request->categoryid == 3) {
            if (empty($request->name)) {
                $rules['name_of_staff'] = 'required';
            }
            if (empty($request->designation)) {
                $rules['staff_designation'] = 'required';
            }
            if (empty($request->service_number)) {
                $rules['staff_id'] = 'required';
            }

            if (empty($request->staff_certification_old)) {
                $rules['staff_certification'] = 'required';
            }
            $request->validate($rules, [
                'name_of_staff.required' => 'Name of the Staff is required.',
                'staff_designation.required' => 'Designation is required.',
                'staff_id.required' => 'Staff ID is required.',
                'staff_certification.required' => 'Staff certification/Testimonial from BAFSD is required.',
            ]);
        }
        return (($request->stage == 5) ? 5 : ($request->stage + 1));
    }
    public function admissionSave(StudentStoreRequest $request)
    {
        // dd($request->all());

        $stage = $this->stagevalidationcheck($request);
        try {
            $classdata = Classes::where('class_code', $request->class_code)->first();

            $sessiondata = Sessions::where('id', $request->session_id)->first();
            // if ($request->hasFile('photo')) {
            //     if (file_exists($request->photo_old)) {
            //         //unlink($request->photo_old);
            //     }
            //     $destinationPath = 'sutdent/' . $request->session_id . '/' . $classdata->class_code;
            //     $myimage = $request->student_code . 'photo' . $request->photo->getClientOriginalName();
            //     $request->photo->move(public_path($destinationPath), $myimage);
            //     $photo = asset('public/' . $destinationPath) . '/' . $myimage;
            // } else {
            //     $photo = $request->photo_old;
            // }
            if ($request->hasFile('photo')) {
                // Define the destination path
                $destinationPath = 'student/' . $request->session_id . '/' . $classdata->class_code;
                $imageDirectory = public_path($destinationPath);

                // Ensure the directory exists, create it if not
                if (!File::exists($imageDirectory)) {
                    File::makeDirectory($imageDirectory, 0755, true);
                }

                // Define the image filename
                $myimage = $request->student_code . 'photo' . $request->photo->getClientOriginalName();
                $imagePath = $imageDirectory . '/' . $myimage;

                try {
                    // Load the image
                    $image = Image::make($request->photo);

                    // Resize and crop to ensure 600x600 dimension (passport size)
                    // $image->fit(600, 600); // Fit the image to 600x600, cropping excess
                    $image->fit(600, 600, function ($constraint) {
                        $constraint->upsize(); // Prevent upscaling
                    }, 'top'); // Fit the image to 600x600, cropping excess from center

                    // Compress the image to reduce file size (80% quality)
                    $image->save($imagePath, 80); // Save with 80% quality for compression

                    // Get the asset URL for the photo
                    $photo = asset('public/' . $destinationPath) . '/' . $myimage;
                } catch (Exception $e) {
                    dd($e->getMessage());
                    $photo = $request->photo_old; // Fallback to the old photo
                }
            } else {
                $photo = $request->photo_old;
            }

            if ($request->hasFile('admit_card')) {
                if (file_exists($request->admit_card_old)) {
                    // unlink($request->admit_card_old);
                }
                $destinationPath6 = 'admitcard/' . $request->session_id . '/' . $classdata->class_code . '/' . $request->section_id;
                $myimage = $request->student_code . 'admitcard' . $request->admit_card->getClientOriginalName();
                $request->admit_card->move(public_path($destinationPath6), $myimage);
                $admit_card = asset('public/' . $destinationPath6) . '/' . $myimage;
            } else {
                $admit_card = $request->photo_old;
            }
            if ($request->hasFile('father_nid')) {
                if (file_exists($request->father_nid_old)) {
                    // unlink($request->father_nid_old);
                }
                $destinationPath7 = 'nid/' . $request->session_id . '/' . $classdata->class_code . '/' . $request->section_id;
                $myimage = $request->student_code . 'nid' . $request->father_nid->getClientOriginalName();
                $request->father_nid->move(public_path($destinationPath7), $myimage);
                $father_nid = asset('public/' . $destinationPath7) . '/' . $myimage;
            } else {
                $father_nid = $request->father_nid_old;
            }
            if ($request->hasFile('mother_nid')) {
                if (file_exists($request->mother_nid_old)) {
                    // unlink($request->mother_nid_old);
                }
                $destinationPath8 = 'nid/' . $request->session_id . '/' . $classdata->class_code . '/' . $request->section_id;
                $myimage = $request->student_code . 'nidm' . $request->mother_nid->getClientOriginalName();
                $request->mother_nid->move(public_path($destinationPath8), $myimage);
                $mother_nid = asset('public/' . $destinationPath8) . '/' . $myimage;
            } else {
                $mother_nid = $request->mother_nid_old;
            }

            if ($request->hasFile('testimonial')) {
                if (file_exists($request->testimonial_old)) {
                    // unlink($request->testimonial_old);
                }
                $destinationPath1 = 'testimonial/' . $request->session_id . '/' . $classdata->class_code . '/' . $request->section_id;
                $myimage1 = $request->student_code . 'testimonial' . $request->testimonial->getClientOriginalName();
                $request->testimonial->move(public_path($destinationPath1), $myimage1);
                $testimonial = asset('public/' . $destinationPath1) . '/' . $myimage1;
            } else {
                $testimonial = $request->testimonial_old;
            }
            if ($request->hasFile('academic_transcript')) {
                if (file_exists($request->academic_transcript_old)) {
                    //  unlink($request->academic_transcript_old);
                }
                $destinationPath2 = 'academic_transcript/' . $request->session_id . '/' . $classdata->class_code . '/' . $request->section_id;
                $myimage2 = $request->student_code . 'academic_transcript' . $request->academic_transcript->getClientOriginalName();
                $request->academic_transcript->move(public_path($destinationPath2), $myimage2);

                $academic_transcript = asset('public/' . $destinationPath2) . '/' . $myimage2;
            } else {
                $academic_transcript = $request->academic_transcript_old;
            }
            if ($request->hasFile('birth_certificate')) {
                if (file_exists($request->birth_certificate_old)) {
                    // unlink($request->birth_certificate_old);
                }
                $destinationPath3 = 'birth_certificate/' . $request->session_id . '/' . $classdata->class_code . '/' . $request->section_id;
                $myimage2 = $request->student_code . 'birth_certificate' . $request->birth_certificate->getClientOriginalName();
                $request->birth_certificate->move(public_path($destinationPath3), $myimage2);

                $birth_certificate = asset('public/' . $destinationPath3) . '/' . $myimage2;
            } else {
                $birth_certificate = $request->birth_certificate_old;
            }
            if ($request->hasFile('staff_certification')) {
                if (file_exists($request->staff_certification_old)) {
                    //  unlink($request->staff_certification_old);
                }
                $destinationPath4 = 'birth_certificate/' . $request->session_id . '/' . $classdata->class_code . '/' . $request->section_id;
                $myimage2 = $request->student_code . 'staff_certification' . $request->staff_certification->getClientOriginalName();
                $request->staff_certification->move(public_path($destinationPath4), $myimage2);

                $staff_certification = asset('public/' . $destinationPath4) . '/' . $myimage2;
            } else {
                $staff_certification = $request->staff_certification_old;
            }

            if ($request->hasFile('arm_certification')) {
                if (file_exists($request->arm_certification_old)) {
                    // unlink($request->arm_certification_old);
                }
                $destinationPath5 = 'birth_certificate/' . $request->session_id . '/' . $classdata->class_code . '/' . $request->section_id;
                $myimage2 = $request->student_code . 'arm_certification' . $request->arm_certification->getClientOriginalName();
                $request->arm_certification->move(public_path($destinationPath5), $myimage2);

                $arm_certification = asset('public/' . $destinationPath5) . '/' . $myimage2;
            } else {
                $arm_certification = $request->arm_certification_old;
            }

            if ($request->id != 0) {

                $activity = StudentActivity::where('student_code', $request->student_code)->where('session_id', 2026)->where('active', 1)->first();


                $sessions = Sessions::where('active', 1)->first();

                //DB::table('admission_temporary')->where('session_id',$sessions->id)->where('student_code',$request->student_code)->update(['section_id'=>$activity->section_id]);
                if ($activity->class_code == 11 || $activity->class_code == 12) {
                    if (isset($request->third_subject) && count($request->third_subject) > 0 && $request->fourth_subject && count($request->fourth_subject) > 0) {
                        $this->addsubject($request->mainsubject, $request->third_subject, $request->fourth_subject, $request->student_code, $activity->session_id);
                        //  $this->addsection($request->gender,$request->third_subject,$request->fourth_subject,$activity->class_id,$activity->group_id,$request->student_code,$activity->session_id,$activity->version_id);
                    } else {
                        // return redirect()->route('StudentProfile',$request->id)->with('warning','Third And Fourth Subject Choose First');
                    }
                }

                // dd($request->all());

                if (Auth::user()->group_id == 2 || Auth::user()->group_id == 7) {
                    $activity->session_id = $request->session_id;
                    $activity->version_id = $request->version_id;
                    $activity->shift_id = $request->shift_id;
                    $activity->class_id = $request->class_code;
                    $activity->class_code = $request->class_code;
                    $activity->group_id = $request->group_id;
                    $activity->section_id = $request->section_id;
                    $activity->category_id = $request->categoryid;
                    $activity->roll = $request->roll;
                    $activity->house_id = $request->house_id;
                } else {
                    // $activity->house_id = $request->house_id;
                    //$this->housenumber($request->class_id, $request->gender);
                }

                $activity->active = 1;

                $student_code = $request->student_code;
                $student = [];
                if (Auth::user()->group_id == 2 || Auth::user()->group_id == 7) {
                    $student = $request->except(['_token', 'house_id', 'roll', 'group_id', 'section_id', 'category_id', 'class_code', 'shift_id', 'class_id', 'session_id', 'version_id', 'staff_certification_old', 'arm_certification_old', 'admit_card_old', 'student_code', 'father_nid_old', 'birth_certificate_old', 'mother_nid_old', 'photo_old', 'testimonial_old', 'academic_transcript_old', 'house_id', 'roll', 'mainsubject', 'third_subject', 'fourth_subject', '_method', 'session_id', 'version_id', 'shift_id', 'class_id', 'group_id', 'category_id', 'section_id', 'old_photo', 'old_birth_certificate', 'present_district_id', 'permanent_district_id', 'stage']);
                } else {
                    $student = $request->except(['_token', 'staff_certification_old', 'arm_certification_old', 'admit_card_old', 'student_code', 'father_nid_old', 'birth_certificate_old', 'mother_nid_old', 'photo_old', 'testimonial_old', 'academic_transcript_old', 'roll', 'mainsubject', 'third_subject', 'fourth_subject', '_method', 'session_id', 'version_id', 'shift_id', 'class_code', 'house_id', 'class_id', 'group_id', 'category_id', 'section_id', 'old_photo', 'old_birth_certificate', 'present_district_id', 'permanent_district_id', 'stage']);
                }
                $student['active'] = 1;
                $activity->updated_by = Auth::user()->id;
                $student['updated_by'] = Auth::user()->id;
                $student['photo'] = $photo;
                $student['stage'] = $stage;
                $student['testimonial'] = $testimonial;
                $student['student_relation'] = $request->student_relation;
                $student['academic_transcript'] = $academic_transcript;
                $student['birth_certificate'] = $birth_certificate;
                $student['arm_certification'] = $arm_certification;
                $student['staff_certification'] = $staff_certification;
                $student['admit_card'] = $admit_card;
                $student['father_nid'] = $father_nid;
                $student['mother_nid'] = $mother_nid;
                $student['updated_by'] = Auth::user()->id;
                $student['updated_at'] = date('Y-m-d H:s:i');
                $student['present_district_id'] = $request->present_district_id;
                $student['permanent_district_id'] = $request->permanent_district_id;
                $student['local_guardian_address'] = $request->local_guardian_address;

                // dd($activity);

                // dd($student);

                DB::table('students')->where('id', $request->id)->update($student);
                $activity->save();
                $text = 'Student has been update successfully';
            } else {
                $activity = new StudentActivity();
                $activity->session_id = $request->session_id;
                $activity->version_id = $request->version_id;
                $activity->shift_id = $request->shift_id;
                $activity->class_id = $request->class_code;
                $activity->class_code = $request->class_code;
                $activity->group_id = $request->group_id;
                $activity->section_id = $request->section_id;
                $activity->category_id = $request->category_id;
                $activity->roll = $request->roll;
                $activity->house_id = $request->house_id;
                // $this->housenumber($request->class_id, $request->gender);

                $activity->active = 1;


                $student = $request->except(['_token', 'staff_certification_old', 'arm_certification_old', 'id', 'admit_card_old', 'roll', '_method', 'photo_old', 'testimonial_old', 'academic_transcript_old', 'session_id', 'version_id', 'shift_id', 'class_id', 'group_id', 'section_id', 'old_photo', 'old_birth_certificate', 'present_district_id', 'permanent_district_id',]);
                $student['active'] = 1;
                $student['photo'] = $photo;
                $student['testimonial'] = $testimonial;

                $student['academic_transcript'] = $academic_transcript;
                $student['birth_certificate'] = $birth_certificate;
                $student['arm_certification'] = $arm_certification;
                $student['staff_certification'] = $staff_certification;
                $student['admit_card'] = $admit_card;
                $student['father_nid'] = $father_nid;
                $student['mother_nid'] = $mother_nid;

                $activity->created_by = Auth::user()->id;
                $id = DB::table('students')->insertGetId($student);
                $activity->student_code = date('Ym') . $id;
                $activity->save();
                $sudentdata = Student::find($id);
                $sudentdata->student_code = date('Ym') . $id;
                $sudentdata->save();
                $text = 'Student has been Save successfully';
            }

            if ($activity->class_code == 11 || $activity->class_code == 12) {
                if (Auth::user()->group_id != 2 && Auth::user()->group_id != 7) {

                    if (isset($request->third_subject) && count($request->third_subject) > 0 && $request->fourth_subject && count($request->fourth_subject) > 0) {
                        $this->addsubject($request->mainsubject, $request->third_subject, $request->fourth_subject, $request->student_code, $activity->session_id);
                    }
                }
            }
            if (Auth::user()->group_id == 4) {
                $user_id = Auth::user()->id;
                // $userdata = array('photo' => $photo);
                // DB::table('users')->where('id', $user_id)->update($userdata);
            } else {
                // $userdata = array('photo' => $photo);
                // DB::table('users')->where('ref_id', $request->student_code)->update($userdata);
            }


            // if(Auth::user()->group_id==4 && $request->submit==2){

            //     return redirect()->route('getidcard')->with('success',$text);
            // }
            // if(Auth::user()->group_id==4 && $request->submit==1){
            //     return redirect()->route('StudentProfile',0)->with('success',$text);
            // }
            // return redirect()->route('students.index')->with('success',$text);
            return $stage;
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
    public function studentUpdate(Request $request)
    {
        // dd($request->all());

        //$this->addsection($request->third_subject,$request->fourth_subject,$request->student_code);
        $classdata = Classes::where('id', $request->class_id)->first();
        $sessiondata = Sessions::where('id', $request->session_id)->first();
        $photo = '';
        // if ($request->hasFile('photo')) {
        //     if (file_exists($request->photo_old)) {
        //         //unlink($request->photo_old);
        //     }
        //     $destinationPath = 'sutdent/' . $sessiondata->session_name . '/' . $classdata->class_code;
        //     $myimage = $request->student_code . 'photo' . $request->photo->getClientOriginalName();
        //     $request->photo->move(public_path($destinationPath), $myimage);
        //     $photo = asset('public/' . $destinationPath) . '/' . $myimage;
        // } else {
        //     $photo = $request->photo_old;
        // }

        if ($request->hasFile('father_nid')) {
            if (file_exists($request->father_nid_old)) {
                // unlink($request->father_nid_old);
            }
            $destinationPath7 = 'nid/' . $sessiondata->session_name . '/' . $classdata->class_code;
            $myimage = $request->student_code . 'nid' . $request->father_nid->getClientOriginalName();
            $request->father_nid->move(public_path($destinationPath7), $myimage);
            $father_nid = asset('public/' . $destinationPath7) . '/' . $myimage;
        } else {
            $father_nid = $request->father_nid_old;
        }
        if ($request->hasFile('mother_nid')) {
            if (file_exists($request->mother_nid_old)) {
                // unlink($request->mother_nid_old);
            }
            $destinationPath8 = 'nid/' . $sessiondata->session_name . '/' . $classdata->class_code;
            $myimage = $request->student_code . 'nidm' . $request->mother_nid->getClientOriginalName();
            $request->mother_nid->move(public_path($destinationPath8), $myimage);
            $mother_nid = asset('public/' . $destinationPath8) . '/' . $myimage;
        } else {
            $mother_nid = $request->mother_nid_old;
        }



        if ($request->hasFile('birth_certificate')) {
            if (file_exists($request->birth_certificate_old)) {
                // unlink($request->birth_certificate_old);
            }
            $destinationPath3 = 'birth_certificate/' . $sessiondata->session_name . '/' . $classdata->class_code;
            $myimage2 = $request->student_code . 'birth_certificate' . $request->birth_certificate->getClientOriginalName();
            $request->birth_certificate->move(public_path($destinationPath3), $myimage2);

            $birth_certificate = asset('public/' . $destinationPath3) . '/' . $myimage2;
        } else {
            $birth_certificate = $request->birth_certificate_old;
        }
        if ($request->hasFile('staff_certification')) {
            if (file_exists($request->staff_certification_old)) {
                //  unlink($request->staff_certification_old);
            }
            $destinationPath4 = 'birth_certificate/' . $sessiondata->session_name . '/' . $classdata->class_code;
            $myimage2 = $request->student_code . 'staff_certification' . $request->staff_certification->getClientOriginalName();
            $request->staff_certification->move(public_path($destinationPath4), $myimage2);

            $staff_certification = asset('public/' . $destinationPath4) . '/' . $myimage2;
        } else {
            $staff_certification = $request->staff_certification_old;
        }

        if ($request->hasFile('arm_certification')) {
            if (file_exists($request->arm_certification_old)) {
                // unlink($request->arm_certification_old);
            }
            $destinationPath5 = 'birth_certificate/' . $sessiondata->session_name . '/' . $classdata->class_code;
            $myimage2 = $request->student_code . 'arm_certification' . $request->arm_certification->getClientOriginalName();
            $request->arm_certification->move(public_path($destinationPath5), $myimage2);

            $arm_certification = asset('public/' . $destinationPath5) . '/' . $myimage2;
        } else {
            $arm_certification = $request->arm_certification_old;
        }

        if ($request->id != 0) {

            $activity = StudentActivity::where('student_code', $request->student_code)->where('session_id', $request->session_id)->where('active', 1)->first();
            $sessions = Sessions::where('active', 1)->first();

            //DB::table('admission_temporary')->where('session_id',$sessions->id)->where('student_code',$request->student_code)->update(['section_id'=>$activity->section_id]);
            if ($activity->class_id == 59) {
                if (isset($request->third_subject) && count($request->third_subject) > 0 && $request->fourth_subject && count($request->fourth_subject) > 0) {

                    //  $this->addsection($request->gender,$request->third_subject,$request->fourth_subject,$activity->class_id,$activity->group_id,$request->student_code,$activity->session_id,$activity->version_id);
                } else {
                    // return redirect()->route('StudentProfile',$request->id)->with('warning','Third And Fourth Subject Choose First');
                }
            }
            // $activity->session_id=$request->session_id;
            // $activity->version_id=$request->version_id;
            // $activity->shift_id=$request->shift_id;
            // $activity->class_id=$request->class_id;
            //$activity->group_id=$request->group_id;
            // $activity->section_id=$request->section_id;
            // $activity->category_id=$request->category_id;
            //$activity->roll=$request->roll;
            //$activity->house_id=$this->housenumber($request->class_id,$request->gender);
            $activity->active = 1;

            $student_code = $request->student_code;
            $student = $request->except(['_token', 'staff_certification_old', 'arm_certification_old', 'admit_card_old', 'student_code', 'father_nid_old', 'birth_certificate_old', 'mother_nid_old', 'photo_old', 'testimonial_old', 'academic_transcript_old', 'roll', 'mainsubject', 'third_subject', 'fourth_subject', '_method', 'session_id', 'version_id', 'shift_id', 'class_id', 'group_id', 'category_id', 'section_id', 'old_photo', 'old_birth_certificate']);
            $student['active'] = 1;
            $activity->updated_by = Auth::user()->id;
            $student['updated_by'] = Auth::user()->id;
            $student['photo'] = $photo;

            $student['birth_certificate'] = $birth_certificate;
            $student['staff_certification'] = $staff_certification;
            $student['arm_certification'] = $arm_certification;
            $student['father_nid'] = $father_nid;
            $student['mother_nid'] = $mother_nid;
            $student['updated_by'] = Auth::user()->id;
            $student['updated_at'] = date('Y-m-d H:s:i');

            DB::table('students')->where('id', $request->id)->update($student);
            $activity->save();
            $text = 'Student has been update successfully';
        }


        $user_id = Auth::user()->id;
        $userdata = array('photo' => $photo);
        DB::table('users')->where('id', $user_id)->update($userdata);


        // if(Auth::user()->group_id==4 && $request->submit==2){

        //     return redirect()->route('getidcard')->with('success',$text);
        // }
        // if(Auth::user()->group_id==4 && $request->submit==1){
        //     return redirect()->route('StudentProfile',0)->with('success',$text);
        // }
        // return redirect()->route('students.index')->with('success',$text);
        return $student_code;
    }
    public function addsubject($mainsubject, $third_subject, $fourth_subject, $student_code, $session_id)
    {

        $activity = StudentActivity::where('student_code', $student_code)->where('session_id', $session_id)->where('active', 1)->first();
        $student_subject = array();
        $i = 0;
        DB::table('student_subject')->where('student_code', $student_code)->where('session_id', $session_id)->delete();
        foreach ($mainsubject as $subjectdata) {
            $multisubject = explode('-', $subjectdata);
            $multisubject = array_unique($multisubject);
            foreach ($multisubject as $subject) {
                $student_subject[$i++] = array(
                    'class_id' => $activity->class_id,
                    'class_code' => $activity->class_code,
                    'version_id' => $activity->version_id,
                    'session_id' => $activity->session_id,
                    'subject_id' => $subject,
                    'student_code' => $student_code,
                    'is_fourth_subject' => 0,
                    'created_by' => Auth::user()->id
                );
            }
        }
        foreach ($third_subject as $subjectdata) {
            $multisubject = explode('-', $subjectdata);
            $multisubject = array_unique($multisubject);
            foreach ($multisubject as $subject) {
                $student_subject[$i++] = array(
                    'class_id' => $activity->class_id,
                    'class_code' => $activity->class_code,
                    'version_id' => $activity->version_id,
                    'session_id' => $activity->session_id,
                    'subject_id' => $subject,
                    'student_code' => $student_code,
                    'is_fourth_subject' => 2,
                    'created_by' => Auth::user()->id
                );
            }
        }
        foreach ($fourth_subject as $subjectdata) {
            $multisubject = explode('-', $subjectdata);
            $multisubject = array_unique($multisubject);
            foreach ($multisubject as $subject) {
                $student_subject[$i++] = array(
                    'class_id' => $activity->class_id,
                    'class_code' => $activity->class_code,
                    'version_id' => $activity->version_id,
                    'session_id' => $activity->session_id,
                    'subject_id' => $subject,
                    'student_code' => $student_code,
                    'is_fourth_subject' => 1,
                    'created_by' => Auth::user()->id
                );
            }
        }
        DB::table('student_subject')->insert($student_subject);
    }
    public function getidcard()
    {
        $studentdata = DB::select('SELECT * FROM `students` WHERE `student_code` LIKE "' . Auth::user()->ref_id . '"');



        foreach ($studentdata as $key => $student) {
            $studentdata[$key]->activity = StudentActivity::where('student_code', $student->student_code)
                ->with(['session', 'version', 'classes', 'section', 'group', 'shift'])
                ->where('active', 1)->first();
            $studentdata[$key]->qrCode   = QrCode::size(100)->style('round')->generate($student->student_code . '-' . $student->first_name);
        }
        // dd($studentdata);
        return view('student.card', compact('studentdata'));
    }

    /**
     * Display the specified resource.
     */
    public function getStudentDetails(Request $request)
    {

        $session_id = $request->session_id;
        $student = Student::with([
            'studentlastWeekAttendance',
            'studentActivity.version',
            'studentActivity.shift',
            'studentActivity.classes',
            'studentActivity.group',
            'studentActivity.section',
            'studentActivity.category',
            'studentActivity.house'
        ]);
        $student = $student->whereIn('student_code', function ($row) use ($session_id) {
            $row->select('student_code')
                ->from('student_activity');
            if ($session_id) {

                $row->whereRaw('session_id = "' . $session_id . '"');
            }
        })->where('student_code', $request->student_code)->first();

        // dd($student);

        return view('student.profile', compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        if ((Auth::user()->group_id != 2 && Auth::user()->group_id != 7) || Auth::user()->is_view_user != 0) {
            abort(403, 'You do not have permission to access this resource.');
        }
        Session::put('activemenu', 'student');
        Session::put('activesubmenu', 'sc');
        $sessions = Sessions::where('active', 1)->get();
        $versions = Versions::where('active', 1)->get();
        $shifts = Shifts::where('active', 1)->get();
        $districts = DB::table('districts')->get();
        $groups = DB::table('academygroups')->get();
        $activity = StudentActivity::where('student_code', $student->student_code)->orderBy('id', 'desc')->first();
        return $this->StudentProfile($student->id);
    }
    public function housenumber($class_id, $gender)
    {
        $session = Sessions::where('active', 1)->first();
        $count = DB::table('student_activity')
            ->join('students', 'students.student_code', '=', 'student_activity.student_code')
            ->where('session_id', $session->id)
            ->where('gender', $gender)
            ->where('class_id', $class_id)
            ->count();
        return (($count - 1) % 4) + 1;
    }
    public function StudentProfile($id)
    {

        Session::put('activemenu', 'profile');
        Session::put('activesubmenu', 'sc');
        // $sessions = Sessions::where('active', 0)->get();
        $sessions = Sessions::pluck('session_code', 'id');

        $versions = Versions::where('active', 1)->get();
        $shifts = Shifts::where('active', 1)->get();
        $districts = DB::table('districts')->get();
        $classes = DB::table('classes')->where('active', 1)->get();
        $groups = DB::table('academygroups')->get();
        $houses = DB::table('houses')->get();
        $categories = Category::where('active', 1)->where('type', 2)->get();

        if ($id != 0) {

            $studentdata = Student::where('id', $id)->first();

            $activity = StudentActivity::with('classes')->where('student_code', $studentdata->student_code)->orderBy('id', 'desc')->first();
            // dd($activity);
            $sections = Sections::where('class_code', $activity->class_code)
                ->when(!empty($activity->version_id), function ($query) use ($activity) {
                    return $query->where('version_id', $activity->version_id);
                })
                ->when(!empty($activity->shift_id), function ($query) use ($activity) {
                    return $query->where('shift_id', $activity->shift_id);
                })
                ->orderBy('section_name', 'asc')
                ->get();
        } else {

            $studentdata = DB::select('SELECT * FROM `students` WHERE `student_code` LIKE "' . Auth::user()->ref_id . '" order by id desc LIMIT 1');
            if ($studentdata[0]->submit == 2 && $studentdata[0]->is_idcard_download == 0) {
                return redirect()->route('dashboard')->with('warning', 'Print Your ID CARD First');
            }
            if (count($studentdata) > 1) {
                $student = $studentdata;
            } else {
                $student = $studentdata[0];
            }
            $activity = StudentActivity::where('student_code', $studentdata[0]->student_code)->orderBy('id', 'desc')->first();

            $id = $studentdata[0]->id;
            $classes = Classes::where('session_id', $activity->session_id)
                ->where('class_code', $activity->class_code)
                ->get();
            $sections = Sections::where('class_code', $activity->class_code)
                ->when(!empty($activity->version_id), function ($query) use ($activity) {
                    return $query->where('version_id', $activity->version_id);
                })
                ->when(!empty($activity->shift_id), function ($query) use ($activity) {
                    return $query->where('shift_id', $activity->shift_id);
                })
                ->orderBy('section_name', 'asc')
                ->get();
        }


        if ($activity->classes->class_code == '11' || $activity->classes->class_code == '12') {

            $comsubjects = ClassWiseSubject::where('class_wise_subject.active', 1)
                ->join('classes', 'classes.id', '=', 'class_wise_subject.class_id')
                ->join('subjects', 'subjects.id', '=', 'class_wise_subject.subject_id')
                ->select('subjects.*', 'class_wise_subject.subject_code')
                ->where('subject_type', 1)->with('subject')->where('class_wise_subject.class_code', $activity->classes->class_code)->orderBy('class_wise_subject.subject_code', 'asc')->get();
            $comsubjects = collect($comsubjects->groupBy('parent_subject'));
            $groupsubjects = ClassWiseSubject::where('class_wise_subject.active', 1)

                ->join('subjects', 'subjects.id', '=', 'class_wise_subject.subject_id')
                ->where('group_id', $activity->group_id)
                ->select('subjects.*', 'class_wise_subject.subject_code')
                ->where('subject_type', 2)->where('class_wise_subject.class_code', $activity->classes->class_code)->orderBy('class_wise_subject.subject_code', 'asc')->get();

            $groupsubjects = collect($groupsubjects->groupBy('parent_subject'));

            $optionalsubjects = ClassWiseSubject::where('class_wise_subject.active', 1)
                ->join('classes', 'classes.class_code', '=', 'class_wise_subject.class_code')
                ->join('subjects', 'subjects.id', '=', 'class_wise_subject.subject_id')
                ->where('group_id', $activity->group_id)
                ->select('subjects.*', 'class_wise_subject.subject_code')
                ->where('subject_type', 3)->where('class_wise_subject.class_code', $activity->classes->class_code)->orderBy('class_wise_subject.serial', 'asc')->get();

            $optionalsubjects = collect($optionalsubjects->groupBy('parent_subject'));

            $fourthsubjects = ClassWiseSubject::where('class_wise_subject.active', 1)
                ->join('classes', 'classes.class_code', '=', 'class_wise_subject.class_code')
                ->join('subjects', 'subjects.id', '=', 'class_wise_subject.subject_id')
                ->where('group_id', $activity->group_id)
                ->select('subjects.*', 'class_wise_subject.subject_code');
            if ($activity->version_id == 2 && $activity->group_id == 3) {
                $fourthsubjects = $fourthsubjects->whereNotIn('subject_id', [73, 74]);
            } elseif ($activity->version_id == 2) {
                $fourthsubjects = $fourthsubjects->whereNotIn('subject_code', [123, 124]);
            }

            $fourthsubjects = $fourthsubjects->where('subject_type', 4)->where('class_wise_subject.class_code', $activity->classes->class_code)->orderBy('class_wise_subject.serial', 'asc')->get();
            //dd($groupsubjects);
            $fourthsubjects = collect($fourthsubjects->groupBy('parent_subject'));

            $student_third_subject = DB::table('student_subject')
                ->join('subjects', 'subjects.id', '=', 'student_subject.subject_id')
                ->join('class_wise_subject', 'class_wise_subject.subject_id', '=', 'student_subject.subject_id')
                ->where('student_subject.session_id', $activity->session_id)
                ->where('student_subject.student_code', $activity->student_code)
                ->where('is_fourth_subject', 2)
                ->select('subjects.*', 'class_wise_subject.subject_code')
                ->get();
            $student_third_subject = collect($student_third_subject->groupBy('parent_subject'));

            $student_fourth_subject = DB::table('student_subject')
                ->join('subjects', 'subjects.id', '=', 'student_subject.subject_id')
                ->join('class_wise_subject', 'class_wise_subject.subject_id', '=', 'student_subject.subject_id')
                ->where('student_subject.session_id', $activity->session_id)
                ->where('student_subject.student_code', $activity->student_code)
                ->where('is_fourth_subject', 1)
                ->select('subjects.*', 'class_wise_subject.subject_code')
                ->get();
            $student_fourth_subject = collect($student_fourth_subject->groupBy('parent_subject'));
        } else {
            $comsubjects = array();
            $groupsubjects = array();
            $optionalsubjects = array();
            $fourthsubjects = array();
            $student_third_subject = array();
            $student_fourth_subject = array();
        }

        if (isset($studentdata[0]->submit)) {
            $submit = $studentdata[0]->submit;
            $studentdata = $studentdata[0];
            $student = $studentdata;
        } else {
            $submit = $studentdata->submit;
            $student = $studentdata;
        }

        // dd($studentdata);



        if ($activity->classes->class_code == '11' && $submit != 2) {
            if (Auth::user()->group_id == 4) {
                return view('student.studentAdmissionNew', compact('sessions', 'houses', 'fourthsubjects', 'student_third_subject', 'student_fourth_subject', 'comsubjects', 'groupsubjects', 'optionalsubjects', 'studentdata', 'groups', 'versions', 'shifts', 'categories', 'districts', 'sections', 'classes', 'student', 'activity', 'id'));
            } else {
                return view('student.studentAdmissionNewAdmin', compact('sessions', 'houses', 'fourthsubjects', 'student_third_subject', 'student_fourth_subject', 'comsubjects', 'groupsubjects', 'optionalsubjects', 'studentdata', 'groups', 'versions', 'shifts', 'categories', 'districts', 'sections', 'classes', 'student', 'activity', 'id'));
            }
        } elseif ($activity->classes->class_code == '11' || $activity->classes->class_code == '12') {
            if (Auth::user()->group_id == 4) {
                return view('student.studentAdmissionNew', compact('sessions', 'houses', 'fourthsubjects', 'student_third_subject', 'student_fourth_subject', 'comsubjects', 'groupsubjects', 'optionalsubjects', 'studentdata', 'groups', 'versions', 'shifts', 'categories', 'districts', 'sections', 'classes', 'student', 'activity', 'id'));
            } else {
                return view('student.studentAdmissionNewAdmin', compact('sessions', 'houses', 'fourthsubjects', 'student_third_subject', 'student_fourth_subject', 'comsubjects', 'groupsubjects', 'optionalsubjects', 'studentdata', 'groups', 'versions', 'shifts', 'categories', 'districts', 'sections', 'classes', 'student', 'activity', 'id'));
            }
        } else if ($activity->classes->class_code >= 0 && $activity->classes->class_code <= 10 && $submit != 2) {

            if (Auth::user()->group_id == 4) {
                return view('student.student_update_kg', compact('sessions', 'houses', 'fourthsubjects', 'student_third_subject', 'student_fourth_subject', 'comsubjects', 'groupsubjects', 'optionalsubjects', 'studentdata', 'groups', 'versions', 'shifts', 'categories', 'districts', 'sections', 'classes', 'student', 'activity', 'id'));
            } else {
                return view('student.student_update_kg_admin', compact('sessions', 'houses', 'fourthsubjects', 'student_third_subject', 'student_fourth_subject', 'comsubjects', 'groupsubjects', 'optionalsubjects', 'studentdata', 'groups', 'versions', 'shifts', 'categories', 'districts', 'sections', 'classes', 'student', 'activity', 'id'));
            }
        } else {
            if (Auth::user()->group_id == 4) {
                return view('student.student_update', compact('sessions', 'houses', 'fourthsubjects', 'student_third_subject', 'student_fourth_subject', 'comsubjects', 'groupsubjects', 'optionalsubjects', 'studentdata', 'groups', 'versions', 'shifts', 'categories', 'districts', 'sections', 'classes', 'student', 'activity', 'id'));
            } else {
                return view('student.student_update_admin', compact('sessions', 'houses', 'fourthsubjects', 'student_third_subject', 'student_fourth_subject', 'comsubjects', 'groupsubjects', 'optionalsubjects', 'studentdata', 'groups', 'versions', 'shifts', 'categories', 'districts', 'sections', 'classes', 'student', 'activity', 'id'));
            }
        }


        //return view('student.student_update_kg', compact('sessions', 'houses', 'fourthsubjects', 'student_third_subject', 'student_fourth_subject', 'comsubjects', 'groupsubjects', 'optionalsubjects', 'studentdata', 'groups', 'versions', 'shifts', 'categories', 'districts', 'sections', 'classes', 'student', 'activity', 'id'));
    }
    public function isOneDimensional(array $array): bool
    {
        foreach ($array as $element) {
            if (is_array($element)) {
                return false;
            }
        }
        return true;
    }
    public function storePreview(Request $request)
    {

        $id = $request->id;
        $fourth_subject = $request->fourth_subject;
        $third_subject = $request->third_subject;
        $mainsubject = $request->mainsubject;
        $student_code = $request->student_code;
        if ($id) {
            $data = $request->except(['_token', 'student_code', 'id', 'fourth_subject', 'third_subject', 'mainsubject']);


            Student::where('id', $id)->update($data);
            $sessions = Sessions::where('active', 1)->first();

            $activity = StudentActivity::where('student_code', $student_code)->where('active', 1)->orderBy('id', 'desc')->first();



            $userdata = User::where('ref_id', $student_code)->first();
            //dd($userdata);
            if ($userdata) {
                $userdata->is_admission = 1;
                $userdata->is_profile_update = 1;
                $userdata->save();
            }
            if (Auth::user()->group_id == 2 || Auth::user()->group_id == 5) {
                return redirect()->route('students.index')->with('success', 'Student Update sucsessfull');
            }
            return redirect()->route('dashboard')->with('success', 'Admission process is sucsessfull');
        }
        return redirect()->route('StudentProfile/0')->with('error', 'Data Not Found');
    }
    public function studentConfirm($id)
    {
        $student = Student::find($id);
        $student->submit = 2;
        $student->save();
        $userdata = User::where('ref_id', $student->student_code)->first();
        //dd($userdata);
        if ($userdata) {
            $userdata->is_admission = 1;
            $userdata->is_profile_update = 1;
            $userdata->save();
        }

        return redirect()->route('dashboard')->with('success', 'Admission process is sucsessfull');
    }
    public function studentpreview(Request $request)
    {
        // dd($request->all());


        $session = Sessions::where('active', 1)->first();
        $student = Student::where('student_code', $request->studentcode)->with(['present', 'permanent', 'studentActivity'])->first();
        $activity = StudentActivity::with(['classes', 'session', 'version', 'shift', 'group', 'section', 'category', 'house'])
            ->where('student_code', $student->student_code)
            ->where('session_id', $student->studentActivity->session_id)
            ->orderBy('id', 'desc')->first();

        $studentdata = array();
        $classes = Classes::where('session_id', $activity->class_id)
            ->get();
        $sections = Sections::where('class_id', $activity->class_id)->get();


        Session::put('activemenu', 'profile');
        Session::put('activesubmenu', 'sc');
        $sessions = Sessions::where('active', 1)->get();
        $versions = Versions::where('active', 1)->get();
        $shifts = Shifts::where('active', 1)->get();
        $districts = DB::table('districts')->get();
        $groups = DB::table('academygroups')->get();
        $houses = DB::table('houses')->get();

        $categories = Category::where('active', 1)->where('type', 2)->get();

        if (!empty($activity->classes->class_code) && $activity->classes->class_code == '11') {

            $comsubjects = ClassWiseSubject::where('class_wise_subject.active', 1)
                ->join('classes', 'classes.id', '=', 'class_wise_subject.class_id')
                ->join('subjects', 'subjects.id', '=', 'class_wise_subject.subject_id')
                ->select('subjects.*', 'class_wise_subject.subject_code')
                ->where('subject_type', 1)->with('subject')->where('class_wise_subject.class_code', $activity->classes->class_code)->orderBy('class_wise_subject.subject_code', 'asc')->get();
            $comsubjects = collect($comsubjects->groupBy('parent_subject'));
            $groupsubjects = ClassWiseSubject::where('class_wise_subject.active', 1)
                ->join('classes', 'classes.id', '=', 'class_wise_subject.class_id')
                ->join('subjects', 'subjects.id', '=', 'class_wise_subject.subject_id')
                ->where('group_id', $activity->group_id)
                ->select('subjects.*', 'class_wise_subject.subject_code')
                ->where('subject_type', 2)->where('class_wise_subject.class_code', $activity->classes->class_code)->orderBy('class_wise_subject.subject_code', 'asc')->get();

            $groupsubjects = collect($groupsubjects->groupBy('parent_subject'));


            $student_third_subject = DB::table('student_subject')
                ->join('subjects', 'subjects.id', '=', 'student_subject.subject_id')
                ->join('class_wise_subject', 'class_wise_subject.subject_id', '=', 'student_subject.subject_id')
                ->where('student_subject.session_id', $activity->session_id)
                ->where('student_subject.student_code', $activity->student_code)
                ->where('is_fourth_subject', 2)
                ->select('subjects.*', 'class_wise_subject.subject_code')
                ->get();
            $student_third_subject = collect($student_third_subject->groupBy('parent_subject'));
            $student_fourth_subject = DB::table('student_subject')
                ->join('subjects', 'subjects.id', '=', 'student_subject.subject_id')
                ->join('class_wise_subject', 'class_wise_subject.subject_id', '=', 'student_subject.subject_id')
                ->where('student_subject.session_id', $activity->session_id)
                ->where('student_subject.student_code', $activity->student_code)
                ->where('is_fourth_subject', 1)
                ->select('subjects.*', 'class_wise_subject.subject_code')
                ->get();
            $student_fourth_subject = collect($student_fourth_subject->groupBy('parent_subject'));
        } else {
            $comsubjects = array();
            $groupsubjects = array();
            $student_fourth_subject = array();
            $student_third_subject = array();
        }
        // dd($activity->student_code);
        // dd($student_third_subject,$student_fourth_subject);
        // $subjects=collect($subjects)->groupBy('subject_type');
        // dd($subjects);
        //return view('student.details_view_student',compact('sessions','houses','fourthsubjects','student_third_subject','student_fourth_subject','comsubjects','groupsubjects','optionalsubjects','studentdata','groups','versions','shifts','categories','districts','sections','classes','student','activity','id'));
        return view('student.preview', compact('sessions', 'houses', 'student_third_subject', 'student_fourth_subject', 'comsubjects', 'groupsubjects', 'studentdata', 'groups', 'versions', 'shifts', 'categories', 'districts', 'sections', 'classes', 'student', 'activity'));
    }
    public function studentPrint($id)
    {

        if ($id != 0) {

            // dd($id);

            $student = Student::where('id', $id)->first();
            if (empty($student)) {
                $student = Student::where('student_code', $id)->first();
            }
            $activity = StudentActivity::with(['classes', 'session', 'version', 'shift', 'group', 'section', 'category', 'house'])->where('student_code', $student->student_code)->orderBy('id', 'desc')->first();
            $studentdata = array();
            $classes = Classes::where('session_id', $activity->session_id)
                ->where('shift_id', $activity->shift_id)
                ->where('version_id', $activity->version_id)->get();
            $sections = Sections::where('class_id', $activity->class_id)->get();
        } else {

            // $student=Student::where('local_guardian_mobile',Auth::user()->phone)->get();

            $studentdata = DB::select('SELECT * FROM `students` WHERE `studet_code` LIKE "' . Auth::user()->ref_id . '" order by id desc');

            if (count($studentdata) >= 1) {
                $student = $studentdata;
            }
            $activity = StudentActivity::where('student_code', $studentdata[0]->student_code)->orderBy('id', 'desc')->first();

            $classes = Classes::where('session_id', $activity->session_id)
                ->where('shift_id', $activity->shift_id)
                ->where('version_id', $activity->version_id)->get();
            $sections = Sections::where('class_id', $activity->class_id)->get();
        }

        Session::put('activemenu', 'profile');
        Session::put('activesubmenu', 'sc');
        $sessions = Sessions::where('active', 1)->get();
        $versions = Versions::where('active', 1)->get();
        $shifts = Shifts::where('active', 1)->get();
        $districts = DB::table('districts')->get();
        $groups = DB::table('academygroups')->get();

        $categories = Category::where('active', 1)->where('type', 2)->get();
        //dd($activity,$student);
        if ($activity->classes->class_code == '11') {

            $comsubjects = ClassWiseSubject::where('class_wise_subject.active', 1)
                ->join('classes', 'classes.id', '=', 'class_wise_subject.class_id')
                ->join('subjects', 'subjects.id', '=', 'class_wise_subject.subject_id')
                ->select('subjects.*', 'class_wise_subject.subject_code')
                ->where('subject_type', 1)->with('subject')->where('class_wise_subject.class_code', $activity->classes->class_code)->orderBy('class_wise_subject.subject_code', 'asc')->get();
            $comsubjects = collect($comsubjects->groupBy('parent_subject'));
            $groupsubjects = ClassWiseSubject::where('class_wise_subject.active', 1)
                ->join('classes', 'classes.id', '=', 'class_wise_subject.class_id')
                ->join('subjects', 'subjects.id', '=', 'class_wise_subject.subject_id')
                ->where('group_id', $activity->group_id)
                ->select('subjects.*', 'class_wise_subject.subject_code')
                ->where('subject_type', 2)->where('class_wise_subject.class_code', $activity->classes->class_code)->orderBy('class_wise_subject.subject_code', 'asc')->get();
            $groupsubjects = collect($groupsubjects->groupBy('parent_subject'));
            $optionalsubjects = ClassWiseSubject::where('class_wise_subject.active', 1)
                ->join('classes', 'classes.id', '=', 'class_wise_subject.class_id')
                ->join('subjects', 'subjects.id', '=', 'class_wise_subject.subject_id')
                ->where('group_id', $activity->group_id)
                ->select('subjects.*', 'class_wise_subject.subject_code')
                ->whereIn('subject_type', [3, 4])->where('class_wise_subject.class_code', $activity->classes->class_code)->orderBy('class_wise_subject.subject_code', 'asc')->get();
            //dd($groupsubjects);
            $optionalsubjects = collect($optionalsubjects->groupBy('parent_subject'));

            $student_third_subject = DB::table('student_subject')
                ->join('subjects', 'subjects.id', '=', 'student_subject.subject_id')
                ->join('class_wise_subject', 'class_wise_subject.subject_id', '=', 'student_subject.subject_id')
                ->where('student_subject.session_id', $activity->session_id)
                ->where('student_subject.student_code', $activity->student_code)
                ->where('is_fourth_subject', 2)
                ->select('subjects.*', 'class_wise_subject.subject_code')
                ->get();
            $student_third_subject = collect($student_third_subject->groupBy('parent_subject'));
            $student_fourth_subject = DB::table('student_subject')
                ->join('subjects', 'subjects.id', '=', 'student_subject.subject_id')
                ->join('class_wise_subject', 'class_wise_subject.subject_id', '=', 'student_subject.subject_id')
                ->where('student_subject.session_id', $activity->session_id)
                ->where('student_subject.student_code', $activity->student_code)
                ->where('is_fourth_subject', 1)
                ->select('subjects.*', 'class_wise_subject.subject_code')
                ->get();
            $student_fourth_subject = collect($student_fourth_subject->groupBy('parent_subject'));
        } else {
            $comsubjects = array();
            $groupsubjects = array();
            $optionalsubjects = array();
            $student_third_subject = array();
            $student_fourth_subject = array();
        }

        // $subjects=collect($subjects)->groupBy('subject_type');
        // dd($subjects);
        ini_set('max_execution_time', '300');
        ini_set("pcre.backtrack_limit", "5000000");

        $pdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'default_font_size' => 16,
        ]);


        $pdf->WriteHTML('');
        $no_footer = 0;
        if (!$no_footer) {
            $footer = view('print.pdf_footer', []);
            $pdf->setHTMLFooter($footer, 'O');
            $pdf->setHTMLFooter($footer, 'E');
        }
        // $pdf->SetWatermarkImage(
        //     'https://bafsd.edu.bd/public/frontend/uploads/school_content/logo/front_logo-608ff44a5f8f07.35255544.png',
        //     1,
        //     '',
        //     [160, 10]
        // );
        $pdf->showWatermarkImage = true;
        $view = 'print.details_view_student_print';
        $data = compact('sessions', 'student_third_subject', 'student_fourth_subject', 'comsubjects', 'groupsubjects', 'optionalsubjects', 'studentdata', 'groups', 'versions', 'shifts', 'categories', 'districts', 'sections', 'classes', 'student', 'activity', 'id');
        $html = view($view, $data);
        $pdf->WriteHTML($html);
        return  $pdf->Output();
        //return view('student.details_view_student_print',compact('sessions','student_third_subject','student_fourth_subject','comsubjects','groupsubjects','optionalsubjects','studentdata','groups','versions','shifts','categories','districts','sections','classes','student','activity','id'));
    }
    public function getidcardd()
    {
        $student = Student::where('student_code', Auth::user()->ref_id)->first();
        //	DB::select('SELECT * FROM `students` WHERE `student_code` = "' . Auth::user()->ref_id . '"');
        if ($student->submit != 2) {
            return response()->json(['message' => 'Please Submit Your Admission Form First'], 404);
        }
        Student::where('id', $student->id)->update(['is_idcard_download' => 1]);
        // dd($studentdata);
        $studentdata[0] = $student;
        $key = 0;
        //foreach ($studentdata as $key => $student) {
        $studentdata[$key]->activity = StudentActivity::where('student_code', $student->student_code)
            ->with(['session', 'version', 'classes', 'section', 'group'])
            ->where('active', 1)->first();
        $studentdata[$key]->qrCode   = QrCode::size(100)->style('round')->generate($student->student_code . '-' . $student->first_name);
        //}

        //dd($studentdata[0]->activity->version->version_name);

        ini_set('max_execution_time', '300');
        ini_set("pcre.backtrack_limit", "5000000");

        $pdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => [85.6, 114],
            'default_font_size' => 9,
        ]);


        $pdf->WriteHTML('');
        $no_footer = 0;
        if (!$no_footer) {
            $footer = view('print.pdf_footer', []);
            // $pdf->setHTMLFooter($footer,'O');
            //$pdf->setHTMLFooter($footer,'E');
        }
        // $pdf->SetWatermarkImage(
        //     'https://bafsd.edu.bd/public/frontend/uploads/school_content/logo/front_logo-608ff44a5f8f07.35255544.png',
        //     1,
        //     '',
        //     [160, 10]
        // );
        $pdf->showWatermarkImage = true;
        $view = 'student.cardD';
        $data = compact('studentdata');
        $html = view($view, $data);
        $pdf->WriteHTML($html);
        $pdf->Output($student->first_name . '.pdf', 'D');
    }
    public function studentPrintD($id)
    {

        if ($id != 0) {

            $student = Student::where('student_code', $id)->first();

            $activity = StudentActivity::with(['classes', 'session', 'version', 'shift', 'group', 'section', 'category', 'house'])->where('student_code', $student->student_code)->orderBy('id', 'desc')->first();
            $studentdata = array();
            $classes = Classes::where('session_id', $activity->session_id)
                ->where('shift_id', $activity->shift_id)
                ->where('version_id', $activity->version_id)->get();
            $sections = Sections::where('class_id', $activity->class_id)->get();
        } else {

            // $student=Student::where('local_guardian_mobile',Auth::user()->phone)->get();

            $studentdata = DB::select('SELECT * FROM `students` WHERE `local_guardian_mobile` LIKE "' . Auth::user()->phone . '" order by id desc');

            if (count($studentdata) >= 1) {
                $student = $studentdata;
            }
            $activity = StudentActivity::where('student_code', $studentdata[0]->student_code)->orderBy('id', 'desc')->first();

            $classes = Classes::where('session_id', $activity->session_id)
                ->where('shift_id', $activity->shift_id)
                ->where('version_id', $activity->version_id)->get();
            $sections = Sections::where('class_id', $activity->class_id)->get();
        }

        Session::put('activemenu', 'profile');
        Session::put('activesubmenu', 'sc');
        $sessions = Sessions::where('active', 1)->get();
        $versions = Versions::where('active', 1)->get();
        $shifts = Shifts::where('active', 1)->get();
        $districts = DB::table('districts')->get();
        $groups = DB::table('academygroups')->get();

        $categories = Category::where('active', 1)->where('type', 2)->get();
        //dd($activity,$student);
        if ($activity->classes->class_code == '11') {

            $comsubjects = ClassWiseSubject::where('class_wise_subject.active', 1)
                ->join('classes', 'classes.id', '=', 'class_wise_subject.class_id')
                ->join('subjects', 'subjects.id', '=', 'class_wise_subject.subject_id')
                ->select('subjects.*', 'class_wise_subject.subject_code')
                ->where('subject_type', 1)->with('subject')->where('class_code', $activity->classes->class_code)->orderBy('class_wise_subject.subject_code', 'asc')->get();
            $comsubjects = collect($comsubjects->groupBy('parent_subject'));
            $groupsubjects = ClassWiseSubject::where('class_wise_subject.active', 1)
                ->join('classes', 'classes.id', '=', 'class_wise_subject.class_id')
                ->join('subjects', 'subjects.id', '=', 'class_wise_subject.subject_id')
                ->where('group_id', $activity->group_id)
                ->select('subjects.*', 'class_wise_subject.subject_code')
                ->where('subject_type', 2)->where('class_code', $activity->classes->class_code)->orderBy('class_wise_subject.subject_code', 'asc')->get();
            $groupsubjects = collect($groupsubjects->groupBy('parent_subject'));
            $optionalsubjects = ClassWiseSubject::where('class_wise_subject.active', 1)
                ->join('classes', 'classes.id', '=', 'class_wise_subject.class_id')
                ->join('subjects', 'subjects.id', '=', 'class_wise_subject.subject_id')
                ->where('group_id', $activity->group_id)
                ->select('subjects.*', 'class_wise_subject.subject_code')
                ->whereIn('subject_type', [3, 4])->where('class_code', $activity->classes->class_code)->orderBy('class_wise_subject.subject_code', 'asc')->get();
            //dd($groupsubjects);
            $optionalsubjects = collect($optionalsubjects->groupBy('parent_subject'));

            $student_third_subject = DB::table('student_subject')
                ->join('subjects', 'subjects.id', '=', 'student_subject.subject_id')
                ->join('class_wise_subject', 'class_wise_subject.subject_id', '=', 'student_subject.subject_id')
                ->where('student_subject.session_id', $activity->session_id)
                ->where('student_subject.student_code', $activity->student_code)
                ->where('is_fourth_subject', 2)
                ->select('subjects.*', 'class_wise_subject.subject_code')
                ->get();
            $student_third_subject = collect($student_third_subject->groupBy('parent_subject'));
            $student_fourth_subject = DB::table('student_subject')
                ->join('subjects', 'subjects.id', '=', 'student_subject.subject_id')
                ->join('class_wise_subject', 'class_wise_subject.subject_id', '=', 'student_subject.subject_id')
                ->where('student_subject.session_id', $activity->session_id)
                ->where('student_subject.student_code', $activity->student_code)
                ->where('is_fourth_subject', 1)
                ->select('subjects.*', 'class_wise_subject.subject_code')
                ->get();
            $student_fourth_subject = collect($student_fourth_subject->groupBy('parent_subject'));
        } else {
            $comsubjects = array();
            $groupsubjects = array();
            $optionalsubjects = array();
        }

        // $subjects=collect($subjects)->groupBy('subject_type');
        // dd($subjects);
        ini_set('max_execution_time', '300');
        ini_set("pcre.backtrack_limit", "5000000");

        $pdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'default_font_size' => 16,
        ]);


        $pdf->WriteHTML('');
        $no_footer = 0;
        if (!$no_footer) {
            $footer = view('print.pdf_footer', []);
            $pdf->setHTMLFooter($footer, 'O');
            $pdf->setHTMLFooter($footer, 'E');
        }
        // $pdf->SetWatermarkImage(
        //     'https://bafsd.edu.bd/public/frontend/uploads/school_content/logo/front_logo-608ff44a5f8f07.35255544.png',
        //     1,
        //     '',
        //     [160, 10]
        // );
        $pdf->showWatermarkImage = true;
        $view = 'print.details_view_student_print';
        $data = compact('sessions', 'student_third_subject', 'student_fourth_subject', 'comsubjects', 'groupsubjects', 'optionalsubjects', 'studentdata', 'groups', 'versions', 'shifts', 'categories', 'districts', 'sections', 'classes', 'student', 'activity', 'id');
        $html = view($view, $data);
        $pdf->WriteHTML($html);
        $pdf->Output($student->first_name . '.pdf', 'D');
        //return view('student.details_view_student_print',compact('sessions','student_third_subject','student_fourth_subject','comsubjects','groupsubjects','optionalsubjects','studentdata','groups','versions','shifts','categories','districts','sections','classes','student','activity','id'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (Auth::user()->group_id != 2 || Auth::user()->is_view_user != 0) {
            abort(403, 'You do not have permission to access this resource.');
        }
        echo 1;
        die;
        try {
            $student = Student::find($id);
            StudentActivity::where('student_code', $student->student_code)->delete();
            User::where('ref_id', $student->student_code)->delete();
            $student->delete();
            return 1;
        } catch (Exception $e) {
            return $e;
        }
    }

    // public function studentInactive(Request $request, $id)
    // {
    //     // dd($request->all(), $id);
    //     try {
    //         // Find the student
    //         $student = Student::find($id);
    //         if (!$student) {
    //             return response()->json(['message' => 'Student not found'], 404);
    //         }

    //         // Get current date
    //         $date = Carbon::now()->format('Y-m-d');

    //         // Get the reason from request
    //         $reason = $request->input('reason', 'Inactive from account');

    //         // Get the authenticated user name (or ID if preferred)
    //         $updatedBy = Auth::user()->name ?? 'System'; // Use 'System' if no user is logged in

    //         // Construct the new remark entry with <p> tags
    //         $newRemark = "<p>$date - $reason (Updated by: $updatedBy)</p>";

    //         // Append to existing remarks (if any), ensuring the previous remarks are wrapped in <p> tags
    //         $updatedRemark = $student->remark ? $student->remark . $newRemark : $newRemark;

    //         // dd($updatedRemark);

    //         // Update the student record
    //         $student->update([
    //             'active' => 0,
    //             'remark' => $updatedRemark,
    //             'updated_by' => Auth::user()->id,
    //             'updated_at' => Carbon::now()
    //         ]);

    //         return response()->json([
    //             'message' => 'Student make as inactive',
    //             'remark' => $updatedRemark
    //         ], 200);
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => $e->getMessage()], 500);
    //     }
    // }

    public function studentInactive(Request $request, $id)
    {
        if (Auth::user()->group_id != 2 || Auth::user()->is_view_user != 0) {
            return 1;
        }
        try {
            // Find the student
            $student = Student::find($id);
            if (!$student) {
                return response()->json(['message' => 'Student not found'], 404);
            }

            // Current date
            $date = Carbon::now()->format('Y-m-d');

            // Reason from request
            $reason = $request->input('reason', 'Inactive from account');

            // Purpose: 2 for Inactive (1 for TC, 2 for Inactive based on your logic)
            $purpose = 2;

            // Status: 1 (active in tc_inactives)
            $status = 1;

            // Authenticated user
            $updatedBy = Auth::user();
            $userId = $updatedBy->id ?? null;
            $userName = $updatedBy->name ?? 'System';

            // Construct the new remark
            $newRemark = "<p>$date - $reason (Updated by: $userName)</p>";
            $updatedRemark = $student->remark ? $student->remark . $newRemark : $newRemark;

            // Update student
            $student->update([
                'active' => 0,
                'remark' => $updatedRemark,
                'updated_by' => $userId,
                'updated_at' => Carbon::now()
            ]);

            // Insert into tc_inactives
            TcInactive::create([
                'student_code'  => $student->student_code,
                'reason'        => $reason,
                'date'          => $date,
                'purpose'       => $purpose,
                'status'        => $status,
                'generated_by'  => $userId,
                'created_at'    => now(),
                'updated_at'    => now(),
                'created_by'    => $userId,
                'updated_by'    => $userId,
            ]);

            return response()->json([
                'message' => 'Student marked as inactive and logged in tc_inactives.',
                'remark' => $updatedRemark
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function studentActive(Request $request, $id)
    {
        // dd($request->all(), $id);
        if (Auth::user()->group_id != 2 || Auth::user()->is_view_user != 0) {
            return 1;
        }
        try {
            // Find the student
            $student = Student::find($id);
            if (!$student) {
                return response()->json(['message' => 'Student not found'], 404);
            }

            // Get current date
            $date = Carbon::now()->format('Y-m-d');

            // Get the reason from request
            $reason = $request->input('reason', 'Active from account');

            // Get the authenticated user name (or ID if preferred)
            $updatedBy = Auth::user()->name ?? 'System'; // Use 'System' if no user is logged in

            // Construct the new remark entry with <p> tags
            $newRemark = "<p>$date - $reason (Updated by: $updatedBy)</p>";

            // Append to existing remarks (if any), ensuring the previous remarks are wrapped in <p> tags
            $updatedRemark = $student->remark ? $student->remark . $newRemark : $newRemark;

            // dd($updatedRemark);

            // Update the student record
            $student->update([
                'active' => 1,
                'remark' => $updatedRemark,
                'updated_by' => Auth::user()->id,
                'updated_at' => Carbon::now()
            ]);

            return response()->json([
                'message' => 'Student make as active',
                'remark' => $updatedRemark
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function studentPid(Request $request, $id)
    {
        // dd($request->all(), $id);
        try {
            // Find the student
            $student = Student::find($id);
            if (!$student) {
                return response()->json(['message' => 'Student not found'], 404);
            }


            // dd($updatedRemark);

            // Update the student record
            $student->update([
                'PID' => $request->pid,
                'updated_by' => Auth::user()->id,
                'updated_at' => Carbon::now()
            ]);

            return response()->json([
                'message' => 'Student Payment id updated',
                'PID' => $request->pid
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function studentInactiveList(Request $request)
    {
        Session::put('activemenu', 'student');
        Session::put('activesubmenu', 'isl');

        $sessions = Sessions::get();
        $versions = Versions::where('active', 1)->get();
        $shifts = Shifts::where('active', 1)->get();
        $classes = Classes::where('active', 1)
            ->when($request->session_id, fn($query, $session_id) => $query->where('session_id', $session_id))
            ->when($request->shift_id, fn($query, $shift_id) => $query->where('shift_id', $shift_id))
            ->when($request->version_id, fn($query, $version_id) => $query->where('version_id', $version_id))
            ->get();

        $sections = Sections::where('active', 1)
            ->when($request->class_code, fn($query, $class_code) => $query->where('class_code', $class_code))
            ->when($request->version_id, fn($query, $version_id) => $query->where('version_id', $version_id))
            ->when($request->shift_id, fn($query, $shift_id) => $query->where('shift_id', $shift_id))
            ->get();

        // Initialize filter variables
        $sessionID = $request->session_id;
        $versionID = $request->version_id;
        $shiftID = $request->shift_id;
        $classCode = $request->class_code;
        $sectionID = $request->section_id;
        $page_size = $request->get('page_size', 50); // Default 50 if not provided

        // Start the query with the default condition (inactive students)
        $studentsQuery = Student::join('student_activity', 'students.student_code', '=', 'student_activity.student_code')
            ->where('students.active', 0)
            ->where('student_activity.active', 1)
            ->select('students.*', 'student_activity.section_id', 'student_activity.roll', 'student_activity.class_code', 'student_activity.active', 'student_activity.session_id', 'student_activity.version_id', 'student_activity.shift_id')
            ->orderBy('students.updated_at', 'desc'); // Order by latest updated

        // Apply filters if any filter values exist
        if ($request->hasAny(['session_id', 'version_id', 'shift_id', 'class_code', 'section_id', 'text_search', 'search'])) {
            if ($sectionID) {
                $studentsQuery->where('student_activity.section_id', $sectionID);
            }

            if ($sessionID) {
                $studentsQuery->where('student_activity.session_id', $sessionID);
            }

            if ($versionID) {
                $studentsQuery->where('student_activity.version_id', $versionID);
            }

            if ($shiftID) {
                $studentsQuery->where('student_activity.shift_id', $shiftID);
            }

            if ($classCode == '0') {
                $studentsQuery->where('student_activity.class_code', 0)->where('students.submit', 2);
            } elseif ($classCode) {
                $studentsQuery->where('student_activity.class_code', $classCode);
            }

            if ($request->text_search) {
                $studentsQuery->where(function ($query) use ($request) {
                    $query->where('students.first_name', 'like', '%' . $request->text_search . '%')
                        ->orWhere('students.student_code', 'like', '%' . $request->text_search . '%')
                        ->orWhere('students.mobile', 'like', '%' . $request->text_search . '%')
                        ->orWhere('students.email', 'like', '%' . $request->text_search . '%')
                        ->orWhere('students.sms_notification', 'like', '%' . $request->text_search . '%');
                });
            }
        }

        // Fetch paginated results
        $students = $studentsQuery->paginate($page_size);
        $createdBy = Auth::user()->name;

        if ($request->ajax()) {
            return view('student.inactive_pagination', compact('students'))->render();
        }

        return view('student.student_inactive', compact('students', 'sessions', 'versions', 'shifts', 'classes', 'sections', 'createdBy'));
    }




    // public function studentAttendance()
    // {
    //     Session::put('activemenu', 'attendance');
    //     Session::put('activesubmenu', 'ta');
    //     $session = Sessions::get();
    //     $endDate = Carbon::now();
    //     $startDate = Carbon::now()->subDays(30);
    //     $attendanceData = Attendance::where('student_code', Auth::user()->ref_id)
    //         ->whereBetween('attendance_date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
    //         ->orderBy('attendance_date', 'asc')->get();
    //     $student = Student::where('student_code', Auth::user()->ref_id)->first();

    //     return view('student.attandancereport', [
    //         'studentName' => $student->first_name,
    //         'attendanceData' => $attendanceData,
    //         'startDate' => $startDate->format('Y-m-d'),
    //         'endDate' => $endDate->format('Y-m-d')
    //     ]);
    // }

    public function studentAttendance()
    {
        Session::put('activemenu', 'attendance');
        Session::put('activesubmenu', 'ta');

        $studentCode = Auth::user()->ref_id;
        $student = Student::where('student_code', $studentCode)->first();

        $selectedMonth = Carbon::now()->format('m'); // Current month

        // Get first and last day of selected month
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();

        $attendanceData = Attendance::where('student_code', $studentCode)
            ->whereBetween('attendance_date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
            ->orderBy('attendance_date', 'asc')
            ->get();

        $months = collect(range(1, 12))->mapWithKeys(function ($month) {
            return [$month => Carbon::create()->month($month)->format('F')];
        });

        return view('student.attandancereport', [
            'studentName' => $student->first_name,
            'studentCode' => $studentCode,
            'attendanceData' => $attendanceData,
            'startDate' => $startDate->format('Y-m-d'),
            'endDate' => $endDate->format('Y-m-d'),
            'selectedMonth' => $selectedMonth,
            'months' => $months
        ]);
    }


    public function studentFee()
    {
        $session = Sessions::where('active', 1)->first();
        $student = Student::with('studentActivity.shift')->where('student_code', Auth::user()->ref_id)->first();
        $months = array(
            "01",
            "02",
            "03",
            "04",
            "05",
            "06",
            "07",
            "08",
            "09",
            "10",
            "11",
            "12"
        );
        $monthvalue = array();
        foreach ($months as $key => $month) {
            $monthvalue[$month] = array();
            $monthvalue[$month]['tutionfee'] = StudentHeadWiseFee::where('student_code', Auth::user()->ref_id)
                ->where('session_id', $session->id)
                ->where('head_id', 'like', '%,1%')
                ->where('month', 'like', '%' . $month . '%')
                ->first();
            $monthvalue[$month]['tutionfeesatus'] = StudentFeeTansaction::where('student_code', Auth::user()->ref_id)
                ->where('session_id', $session->id)
                ->where('fee_for', 1)
                ->where('month', 'like', '%' . $month . '%')
                ->first();
            $monthvalue[$month]['latefee'] = StudentFeeTansaction::where('student_code', Auth::user()->ref_id)
                ->where('session_id', $session->id)
                ->where('head_id', 66)
                ->where('month', 'like', '%' . $month . '%')
                ->first();

            $monthvalue[$month]['sessioncharge'] = StudentFeeTansaction::where('student_code', Auth::user()->ref_id)
                ->where('session_id', $session->id)
                ->where('month', 'like', '%' . $month . '%')
                ->where('fee_for', 2)
                ->first();
        }

        $othersfee = StudentFeeTansaction::with('headdata')->where('student_code', Auth::user()->ref_id)
            ->where('session_id', $session->id)
            ->whereIn('head_id', [3, 35, 36, 37, 39, 38, 40, 32, 33, 31, 41, 42, 43, 5, 4, 44, 45, 47])
            ->get();
        $othersfee = collect($othersfee)->groupBy('head_id');
        $othersfeehead = Fee::whereIn('id', [3, 35, 36, 37, 39, 38, 40, 32, 33, 31, 41, 42, 43, 5, 4, 44, 45, 47])
            ->get();
        //dd($othersfee);

        $fees = Fee::where('head_type', 1)->get();
        $fees = collect($fees)->groupBy('id');
        Session::put('activemenu', 'finance');
        //Session::put('activesubmenu', 'sf');
        // return view('student.studentFee', compact('othersfeehead', 'othersfee', 'fees', 'student', 'monthvalue'));
        Session::put('activesubmenu', 'sf');
        return view('under-development', ['name' => 'E File']);
    }
    public function studentNotice()
    {
        Session::put('activemenu', 'academic');
        Session::put('activesubmenu', 'notice');
        $notices = Notice::with('type')->where('type_id', 1)->get();
        return view('student.notice', compact('notices'));
    }

    public function studentRouten()
    {
        Session::put('activemenu', 'Class');
        Session::put('activesubmenu', '');

        Session::put('activemenu', 'academic');
        Session::put('activesubmenu', 'routine');

        $section = StudentActivity::where('student_code', Auth::user()->ref_id)->where('active', 1)->first();

        $section_id = $section->section_id;
        //$employee=Employee::where('mobile',Auth::user()->phone)->first();

        $session = Sessions::where('session_name', date('Y'))->first();

        $routine = EmployeeActivity::with(['employee', 'subject', 'version', 'shift', 'classes', 'section'])
            ->where('section_id', $section_id)
            ->where('session_id', $session->id)
            ->whereNotNull('day_name')->distinct('start_time')->orderBy('start_time')
            ->selectRaw("employee_activity.*,
                case day_name
                when 'Mon' then 3
                when 'Tue' then 4
                when 'Wed' then 5
                when 'Thu' then 6
                when 'Fri' then 7
                when 'Sat' then 1
                when 'Sun' then 2
                end as day_nr
                ")
            ->get();
        $class_name = $routine[0]->classes->class_name ?? '';
        $section_name = $routine[0]->section->section_name ?? '';
        $shift_name = $routine[0]->shift->shift_name ?? '';
        $version_name = $routine[0]->version->version_name ?? '';
        $routine = collect($routine)->sortBy('day_nr');
        $routine = collect($routine)->groupBy(['day_name', 'start_time']);

        $routinetime = EmployeeActivity::select('start_time', 'end_time')
            ->where('section_id', $section_id)
            ->where('session_id', $session->id)
            ->whereNotNull('day_name')->distinct('start_time')->orderBy('start_time')->get();



        return view('employee.teacherSectionRoutine', compact('routinetime', 'routine', 'shift_name', 'version_name', 'class_name', 'section_name'));
    }
    public function studentXlUpload()
    {
        if (Auth::user()->group_id != 2 || Auth::user()->is_view_user != 0) {
            return 1;
        }
        Session::put('activemenu', 'student');
        Session::put('activesubmenu', 'sxu');
        $sessions = Sessions::orderBy('id', 'desc')->get();
        $shifts = Shifts::where('active', 1)->get();
        $versions = Versions::where('active', 1)->get();
        return view('student.studentXlUpload', compact('sessions', 'shifts', 'versions'));
    }
    public function studentBasicInfoXlUpload()
    {
        if (Auth::user()->group_id != 2 || Auth::user()->is_view_user != 0) {
            return 1;
        }
        Session::put('activemenu', 'student');
        Session::put('activesubmenu', 'sbixu');
        $sessions = Sessions::orderBy('id', 'desc')->get();
        $shifts = Shifts::where('active', 1)->get();
        $versions = Versions::where('active', 1)->get();
        return view('student.studentBasicInofXlUpload', compact('sessions', 'shifts', 'versions'));
    }
    public function studentSubjectXlUpload()
    {
        if (Auth::user()->group_id != 2 || Auth::user()->is_view_user != 0) {
            return 1;
        }
        Session::put('activemenu', 'student');
        Session::put('activesubmenu', 'ssxu');
        $sessions = Sessions::orderBy('id', 'desc')->get();
        $shifts = Shifts::where('active', 1)->get();
        $versions = Versions::where('active', 1)->get();
        return view('student.studentSubjectXlUpload', compact('sessions', 'shifts', 'versions'));
    }
    public function studentPIDUpload()
    {
        if (Auth::user()->group_id != 2 || Auth::user()->is_view_user != 0) {
            return 1;
        }
        Session::put('activemenu', 'student');
        Session::put('activesubmenu', 'spu');
        $sessions = Sessions::orderBy('id', 'desc')->get();
        $shifts = Shifts::where('active', 1)->get();
        $versions = Versions::where('active', 1)->get();
        return view('student.studentPIDUpload', compact('sessions', 'shifts', 'versions'));
    }
    public function boardResult()
    {
        if (Auth::user()->group_id != 2 || Auth::user()->is_view_user != 0) {
            return 1;
        }
        Session::put('activemenu', 'admission');
        Session::put('activesubmenu', 'brxu');
        $sessions = Sessions::orderBy('id', 'desc')->get();
        $shifts = Shifts::where('active', 1)->get();
        $versions = Versions::where('active', 1)->get();
        return view('student.boardResult', compact('sessions', 'shifts', 'versions'));
    }
    public function getBoardResults(Request $request)
    {
        if (Auth::user()->group_id != 2) {
            return 1;
        }
        $request->validate([
            'exam_type' => 'required|in:1,2',
        ]);

        $results = BoardResult::where('exam_type', $request->exam_type)
            ->where('passing_year', $request->passing_year)
            ->with('student')
            ->select('id', 'student_code', 'roll_number', 'registration_number', 'passing_year', 'gpa', 'grade')
            ->get();

        return response()->json($results);
    }

    // public function studentXluploadsave(Request $request)
    // {

    //     if ($request->hasFile('file')) {
    //         $destinationPath = 'studentfile';
    //         $myimage = $request->class_id . $request->file->getClientOriginalName();
    //         $request->file->move(public_path($destinationPath), $myimage);
    //         $file = public_path($destinationPath) . '/' . $myimage;
    //         $this->saveXLList($file, $request->all());
    //         //Excel::import(new StudentsImports, $file);
    //     }
    //     return redirect()->route('studentXlUpload')->with('success', 'XL Import Success');
    // }
    public function studentBasicInfoXlUploadSave(StudentStoreRequest $request)
    {
        if (Auth::user()->group_id != 2 || Auth::user()->is_view_user != 0) {
            return 1;
        }
        try {
            if ($request->hasFile('studentXl')) {
                $destinationPath = 'studentfile';
                $fileName = $request->class_id . '_' . $request->studentXl->getClientOriginalName();
                $filePath = public_path($destinationPath);

                $request->studentXl->move($filePath, $fileName);

                // Call saveXLList to process the file
                $this->saveBasicInfoXLList($filePath . '/' . $fileName, $request->all());

                return redirect()->route('studentBasicInfoXlUpload')->with('success', 'XL Import Success');
            } else {
                return redirect()->route('studentBasicInfoXlUpload')->with('error', 'No file uploaded.');
            }
        } catch (\Exception $e) {
            return redirect()->route('studentBasicInfoXlUpload')->with('error', 'Error uploading file: ' . $e->getMessage());
        }
    }
    public function studentXlUploadSave(StudentStoreRequest $request)
    {
        if (Auth::user()->group_id != 2 || Auth::user()->is_view_user != 0) {
            return 1;
        }
        try {
            if ($request->hasFile('studentXl')) {
                $destinationPath = 'studentfile';
                $fileName = $request->class_id . '_' . $request->studentXl->getClientOriginalName();
                $filePath = public_path($destinationPath);

                $request->studentXl->move($filePath, $fileName);

                // Call saveXLList to process the file
                $this->saveXLList($filePath . '/' . $fileName, $request->all());

                return redirect()->route('studentXlUpload')->with('success', 'XL Import Success');
            } else {
                return redirect()->route('studentXlUpload')->with('error', 'No file uploaded.');
            }
        } catch (\Exception $e) {
            return redirect()->route('studentXlUpload')->with('error', 'Error uploading file: ' . $e->getMessage());
        }
    }
    public function studentPIDUploadSave(StudentStoreRequest $request)
    {
        if (Auth::user()->group_id != 2 || Auth::user()->is_view_user != 0) {
            return 1;
        }
        try {
            if ($request->hasFile('studentXl')) {
                $destinationPath = 'studentfile';
                $fileName = $request->class_id . '_' . $request->studentXl->getClientOriginalName();
                $filePath = public_path($destinationPath);

                $request->studentXl->move($filePath, $fileName);

                // Call saveXLList to process the file
                $this->savePIDList($filePath . '/' . $fileName, $request->all());

                return redirect()->route('studentPIDUpload')->with('success', 'XL Import Success');
            } else {
                return redirect()->route('studentPIDUpload')->with('error', 'No file uploaded.');
            }
        } catch (\Exception $e) {
            return redirect()->route('studentPIDUpload')->with('error', 'Error uploading file: ' . $e->getMessage());
        }
    }
    public function studentSujectUploadSave(StudentStoreRequest $request)
    {
        // echo 1;
        // die;
        if (Auth::user()->group_id != 2 || Auth::user()->is_view_user != 0) {
            return 1;
        }
        try {
            if ($request->hasFile('studentXl')) {
                $destinationPath = 'studentfile';
                $fileName = $request->session_id . '' . $request->class_id . '_subject_' . $request->studentXl->getClientOriginalName();
                $filePath = public_path($destinationPath);

                $request->studentXl->move($filePath, $fileName);

                // Call saveXLList to process the file
                $this->saveSubjectList($filePath . '/' . $fileName, $request->all());

                return redirect()->route('studentSubjectXlUpload')->with('success', 'XL Import Success');
            } else {
                return redirect()->route('studentSubjectXlUpload')->with('error', 'No file uploaded.');
            }
        } catch (\Exception $e) {
            return redirect()->route('studentSubjectXlUpload')->with('error', 'Error uploading file: ' . $e->getMessage());
        }
    }

    public function boardResulXlUploadSave(Request $request)
    {
        if (Auth::user()->group_id != 2 || Auth::user()->is_view_user != 0) {
            return 1;
        }
        try {

            $request->validate([
                'boardResultesultXL' => 'required|mimes:xls,xlsx|max:512', // Accept only .xls and .xlsx files with a max size of 512 KB (500 KB rounded up)
            ], [
                'boardResultesultXL.required' => 'Please upload an Excel file.',
                'boardResultesultXL.mimes' => 'Only Excel files (.xls, .xlsx) are allowed.',
                'boardResultesultXL.max' => 'The file size must not exceed 500 KB.',
            ]);

            if ($request->hasFile('boardResultesultXL')) {
                $destinationPath = 'boardresultfile';
                $fileName = $request->class_id . '_' . $request->boardResultesultXL->getClientOriginalName();
                $filePath = public_path($destinationPath);

                $request->boardResultesultXL->move($filePath, $fileName);

                // Call saveXLList to process the file
                $this->saveBoardResulXL($filePath . '/' . $fileName, $request->all());

                return redirect()->route('boardResult')->with('success', 'XL Import Success');
            } else {
                return redirect()->route('boardResult')->with('error', 'No file uploaded.');
            }
        } catch (\Exception $e) {
            return redirect()->route('boardResult')->with('error', 'Error uploading file: ' . $e->getMessage());
        }
    }

    public function saveBoardResulXL($file, $input)
    {
        if (Auth::user()->group_id != 2 || Auth::user()->is_view_user != 0) {
            return 1;
        }
        Excel::import(new BoardResultImport, $file);
    }

    public function savePIDList($file, $input)
    {
        if (Auth::user()->group_id != 2 || Auth::user()->is_view_user != 0) {
            return 1;
        }
        Excel::import(new StudentsPIDImports, $file);
    }
    public function saveXLList($file, $input)
    {
        if (Auth::user()->group_id != 2 || Auth::user()->is_view_user != 0) {
            return 1;
        }
        Excel::import(new StudentsImports, $file);
    }
    public function saveBasicInfoXLList($file, $input)
    {
        if (Auth::user()->group_id != 2 || Auth::user()->is_view_user != 0) {
            return 1;
        }
        Excel::import(new StudentBasicInfoUpload, $file);
    }
    public function saveSubjectList($file, $input)
    {
        if (Auth::user()->group_id != 2 || Auth::user()->is_view_user != 0) {
            return 1;
        }
        Excel::import(new StudentsSubjectImports, $file);
    }

    public function studentSyllabus()
    {
        Session::put('activemenu', 'academic');
        Session::put('activesubmenu', 'syllabus');
        $student_code = Auth::user()->ref_id;



        $activity = StudentActivity::where('student_code', $student_code)->orderBy('id', 'desc')->first();

        // dd($activity->class_code, $activity->session_id, $activity->version_id);

        $syllabuses = Syllabus::with(['session', 'version', 'classes', 'employee', 'subject'])
            ->where('class_code', $activity->class_code)
            ->where('session_id', $activity->session_id)
            ->where('version_id', $activity->version_id)
            ->get();

        // dd($syllabuses);

        return view('student.studentSyllabus', compact('syllabuses'));
    }


    public function getLastRollAdmission(Request $request)
    {
        return DB::table('student_activity')
            ->where('session_id', $request->session_id)
            ->where('shift_id', $request->shift_id)
            ->where('version_id', $request->version_id)
            ->where('class_code', $request->class_id)
            ->whereRaw('CHAR_LENGTH(roll) < 5') // Ensure the roll is not 5 digits
            ->max('roll') + 1;
    }

    public function getClassWiseSections(Request $request)
    {

        if (isset($request->shift_id) || isset($request->version_id)) {
            $sections = Sections::where('active', 1)
                ->select('sections.*');

            if (isset($request->shift_id)) {
                $sections = $sections->where('shift_id', $request->shift_id);
            }

            if (isset($request->version_id)) {
                $sections = $sections->where('version_id', $request->version_id);
            }

            if (isset($request->group_id)) {
                $sections = $sections->where('group_id', $request->group_id);
            }

            $sections = $sections->where('class_code', $request->class_id)
                ->get();
        } else {
            $sections = Sections::where('active', 1)
                ->select('sections.*')
                ->where('class_code', $request->class_id)
                ->get();
        }

        // if (Auth::user()->group_id == 3) {
        //     $employee = Employee::where('id', Auth::user()->ref_id)->first();
        //     $sections = EmployeeActivity::join('classes', 'classes.class_code', '=', 'employee_activity.class_code')
        //         ->join('sections', 'sections.id', '=', 'employee_activity.section_id')
        //         ->where('employee_id', $employee->id)
        //         ->where('is_class_teacher', 1)
        //         //->where('employee_activity.session_id', $request->session_id)
        //         ->where('employee_activity.class_code', $request->class_id)
        //         //->where('employee_activity.version_id', $request->version_id)
        //         //->where('employee_activity.shift_id', $request->shift_id)
        //         ->select('sections.id', 'section_name')
        //         ->with(['version', 'shift'])
        //         ->DISTINCT('section_name')
        //         ->orderBy('id', 'desc')
        //         ->groupBy('sections.id')
        //         ->groupBy('section_name')
        //         ->get();
        // }

        return view('student.classWiseSection', compact('sections'));
    }
    public function getClassWiseSessions(Request $request)
    {

        $sessions = null;
        if (isset($request->class_code) && $request->class_code > 10) {
            $sessions = Sessions::where('active', 0)->pluck('college_session', 'session_code');
        } else {
            $sessions = Sessions::pluck('session_name', 'session_code');
        }

        return view('student.ajaxsession', compact('sessions'));
    }
    public function excelDownload(Request $request)
    {
        // Get the request parameters
        $shift = $request->shift_id;
        $version = $request->version_id;
        $classCode = $request->class_code;

        // Initialize filename components
        $filenameParts = [];

        // Map the version_id to corresponding names
        if ($version) {
            $versionName = $version == 1 ? 'Bangla' : 'English';
            $filenameParts[] = $versionName;
        }

        // Map the shift_id to corresponding names
        if ($shift) {
            $shiftName = $shift == 1 ? 'Morning' : 'Day';
            $filenameParts[] = $shiftName;
        }

        // Map class_code to corresponding names
        if ($classCode !== null) {
            $className = [
                0 => 'KG',
                1 => 'One',
                2 => 'Two',
                3 => 'Three',
                4 => 'Four',
                5 => 'Five',
                6 => 'Six',
                7 => 'Seven',
                8 => 'Eight',
                9 => 'Nine',
                10 => 'Ten',
                11 => 'Eleven',
                12 => 'Twelve',
            ];

            // Add the class name if classCode is valid
            if (isset($className[$classCode])) {
                $filenameParts[] = $className[$classCode];
            }
        }

        // If no parameters are provided, only use the date in the filename
        if (empty($filenameParts)) {
            $fileName = now()->format('Y-m-d') . '.xlsx';
        } else {
            // Join the parts with an underscore and add the date
            $fileName = implode('_', $filenameParts) . '_' . now()->format('Y-m-d') . '.xlsx';
        }

        // Return the Excel download
        return Excel::download(new StudentsExport($request->all()), $fileName);
    }

    public function pidExcelFormatDownload(Request $request)
    {

        $fileName = 'Student_PID_Import_Format_' . now()->format('Y-m-d') . '.xlsx';

        // Return the Excel download
        return Excel::download(new PidFormatExport($request->all()), $fileName);
    }

    public function studentfileupload()
    {
        if (Auth::user()->group_id != 2 || Auth::user()->is_view_user != 0) {
            return 1;
        }
        $students = DB::select("SELECT photo
        FROM `students`
        WHERE photo IS NOT NULL AND photo != '' limit 500 offset 3501");
        //dd($students);

        foreach ($students as $image) {
            $photo = str_replace("https://bafsd.edu.bd/", "", $image->photo);
            $photoarray = explode('/', $photo);
            //dd($photoarray);
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            $savepath = '';
            echo '<pre>';
            $i = 0;
            foreach ($photoarray as $folderorfile) {
                $extension = strtolower(pathinfo($folderorfile, PATHINFO_EXTENSION));

                // Check if the extension is allowed
                if (in_array($extension, $allowedExtensions)) {

                    try {

                        // Get the image content
                        $imagefile = str_replace("https://bafsd.edu.bd/", "http://156.67.29.124/plesk-site-preview/shahintech.org/https/156.67.29.124/", $image->photo);

                        $imageContent = file_get_contents(str_replace("https://bafsd.edu.bd/", "http://156.67.29.124/plesk-site-preview/shahintech.org/https/156.67.29.124/", $image->photo));



                        if (!is_dir($savepath)) {
                            // Create the folder
                            mkdir($savepath, 0777, true);
                        }
                        $savepath = base_path($savepath);

                        if ($imageContent === false) {
                            throw new Exception("Failed to fetch image content.");
                        }

                        // Save the image content to a file
                        file_put_contents($savepath . '/' . $folderorfile, $imageContent);
                    } catch (Exception $e) {
                        // dd($e);
                        // print_r($e);
                        echo $image->photo . '\n';
                        $i++;
                    }
                } else {
                    //echo $folderorfile;
                    $savepath .= $folderorfile . '/';
                    //echo "File extension is not allowed.";
                }
            }
        }
    }

    // public function getClassWiseSubjects(Request $request)
    // {

    //     $subjects = DB::table('class_wise_subject')
    //         ->when($request->group_id, function ($q) use ($request) {
    //             return $q->where('group_id', $request->group_id);
    //         })
    //         ->where('class_code', $request->class_id)
    //         ->join('subjects', 'subjects.id', '=', 'class_wise_subject.subject_id')
    //         ->select('subjects.*')
    //         ->distinct('subjects.id')
    //         ->orderBy('subjects.id', 'asc')
    //         ->get();

    //     return view('student.class_wise_subjects', compact('subjects'));
    // }

    public function getClassWiseSubjects(Request $request)
    {
        // dd($request->all());

        $subjects = DB::table('class_wise_subject')
            ->when($request->filled('group_id'), function ($q) use ($request) {
                // include rows that match the chosen group_id OR have no group at all
                $q->where(function ($q) use ($request) {
                    $q->where('group_id', $request->group_id)
                        ->orWhereNull('group_id');
                });
            })
            ->where('class_code', $request->class_id)
            ->join('subjects', 'subjects.id', '=', 'class_wise_subject.subject_id')
            ->select('subjects.*')
            ->where('class_wise_subject.subject_type', '!=', 3)

            /* ✨ new rule — hide 38 & 39 only for class 0-2 + version 1 */
            ->when(
                in_array((int) $request->class_id, [0, 1, 2], true) && (int) $request->version_id === 1,
                fn($q) => $q->whereNotIn('class_wise_subject.subject_id', [38, 39, 104])
            )

            ->distinct('subjects.id')
            ->orderBy('subjects.serial', 'asc')
            ->get();

        return view('student.class_wise_subjects', compact('subjects'));
    }



    public function studentIDCards(Request $request)
    {
        Session::put('activemenu', 'studentidcard');
        $sessions = Sessions::get();
        $versions = Versions::where('active', 1)->get();
        $shifts = Shifts::where('active', 1)->get();
        $classes = Classes::where('active', 1)
            ->when($request->session_id, function ($query, $session_id) {
                return $query->where('session_id', $session_id);
            })
            ->when($request->shift_id, function ($query, $shift_id) {
                return $query->where('shift_id', $shift_id);
            })
            ->when($request->version_id, function ($query, $version_id) {
                return $query->where('version_id', $version_id);
            })
            ->get();

        $sections = Sections::where('active', 1)
            ->when($request->class_code, function ($query, $class_code) {
                return $query->where('class_code', $class_code);
            })
            ->when($request->version_id, function ($query, $version_id) {
                return $query->where('version_id', $version_id);
            })
            ->when($request->shift_id, function ($query, $shift_id) {
                return $query->where('shift_id', $shift_id);
            })
            ->get();

        return view('student.studentIdCard', compact('sessions', 'versions', 'shifts', 'classes', 'sections'));
    }

    public function getStudentIDCards(Request $request)
    {
        // Initialize variables for filters
        $sessionID = $request->session_id;
        $versionID = $request->version_id;
        $shiftID = $request->shift_id;
        $classCode = $request->class_code;
        $sectionID = $request->section_id;

        $students = collect(); // Default empty collection

        if ($request->hasAny(['session_id', 'version_id', 'shift_id', 'class_code', 'section_id', 'text_search', 'search'])) {

            // Start building the student query
            $studentsQuery = Student::join('student_activity', 'students.student_code', '=', 'student_activity.student_code')
                ->where('students.active', 1)
                ->where('student_activity.active', 1)
                ->select('students.*', 'student_activity.section_id', 'student_activity.roll', 'student_activity.class_code', 'student_activity.active', 'student_activity.session_id', 'student_activity.version_id', 'student_activity.shift_id');

            // Apply filters step by step
            if ($sectionID) {
                $studentsQuery->where('student_activity.section_id', $sectionID);
            }

            if ($sessionID) {
                $studentsQuery->where('student_activity.session_id', $sessionID);
            }

            if ($versionID) {
                $studentsQuery->where('student_activity.version_id', $versionID);
            }

            if ($shiftID) {
                $studentsQuery->where('student_activity.shift_id', $shiftID);
            }

            if ($classCode == '0') {
                $studentsQuery->where('student_activity.class_code', 0)->where('students.submit', 2);
            } elseif ($classCode) {
                $studentsQuery->where('student_activity.class_code', $classCode);
            }

            // Apply text search filter
            if ($request->text_search) {
                $studentsQuery->where(function ($query) use ($request) {
                    $query->where('students.first_name', 'like', '%' . $request->text_search . '%')
                        ->orWhere('students.student_code', 'like', '%' . $request->text_search . '%')
                        ->orWhere('students.mobile', 'like', '%' . $request->text_search . '%')
                        ->orWhere('students.email', 'like', '%' . $request->text_search . '%')
                        ->orWhere('students.sms_notification', 'like', '%' . $request->text_search . '%');
                });
            }

            // Fetch all filtered data without pagination
            $students = $studentsQuery->orderBy('student_activity.roll', 'asc')->get();
        }

        return view('student.studentIdCardPrint', compact('students'));
    }
}
