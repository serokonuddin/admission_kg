<?php

use App\Http\Controllers\PromotionController;
use App\Http\Controllers\TabulationController;
use App\Http\Controllers\SubjectMarkTermController;
use App\Http\Controllers\SubjectMarkController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\ExamTimeSheduleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExamFeeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\CoachingFeeController;
use App\Http\Controllers\ConveyanceFeeController;
use App\Http\Controllers\ClassesController;
use App\Http\Controllers\ClassRoutineController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\GalleryTypeController;
use App\Http\Controllers\AcademySectionController;
use App\Http\Controllers\ClassWiseSubjectController;
use App\Http\Controllers\DegreeController;
use App\Http\Controllers\HouseController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\NoticeTypeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RfidController;
use App\Http\Controllers\SectionsController;
use App\Http\Controllers\DisciplineController;
use App\Http\Controllers\SpecializationController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SyllabusController;
use App\Http\Controllers\LeasonPlanController;

use App\Http\Controllers\SessionsController;
use App\Http\Controllers\ShiftsController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\StudentSessionController;
use App\Http\Controllers\SubjectsController;
use App\Http\Controllers\TeacherSessionController;
use App\Http\Controllers\VersionsController;
use App\Http\Controllers\YearCalendarController;
use App\Http\Controllers\WebsiteController;
use App\Http\Controllers\FeeController;
use App\Http\Controllers\FineController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\ReAdmissionController;
use App\Http\Controllers\SessionChargeController;
use App\Http\Controllers\StudentWelfareController;
use App\Http\Controllers\GovernmentChargeController;
use App\Http\Controllers\InactiveFineController;
use App\Http\Controllers\BoardFeeController;
use App\Http\Controllers\EmisChargeController;
use App\Http\Controllers\TutionFeeController;
use App\Http\Controllers\ZoomController;
use App\Http\Controllers\SslCommerzPaymentController;
use App\Http\Controllers\AdmissionController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\PasswordChangeController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\CollegeStudentController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\QRcodeGenerateController;
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\SSLController;
use App\Http\Controllers\SMSController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApprovalStageController;
use App\Http\Controllers\CategoryWiseLeaveBalanceController;
use App\Http\Controllers\DocumentController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/clear-cache', function () {
    // Clear all caches
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('event:clear');

    return response()->json(['message' => 'Cache cleared successfully']);
});

Route::group(['namespace' => 'App\Http\Controllers'], function () {
    /**
     * Home Routes
     */

    Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'permission']], function () {
        // Route::group(['middleware' => ['auth', 'permission']], function() {
        /**
         * Logout Routes
         */
        // Route::get('/logout', 'LogoutController@perform')->name('logout.perform');

        /**
         * User Routes
         */
    });
});


Route::post('/password-reset/verify', [ForgotPasswordController::class, 'verify'])->name('password.reset.verify');
Route::get('/password-reset-form', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset.customForm');
Route::post('/password-reset', [ForgotPasswordController::class, 'resetPassword'])->name('password.reset.custom');


// // Route to display change password form
// Route::get('/change-password', [PasswordChangeController::class, 'showChangePasswordForm'])->name('password.change')->middleware('auth');

// // Route to update password (use PUT method)
// Route::put('/change-password', [PasswordChangeController::class, 'changePassword'])->name('password.update')->middleware('auth');

Route::get('/cache', function () {
    Artisan::call('route:cache');
    Artisan::call('config:cache');
});

Route::get('/linkstorage', function () {
    Artisan::call('storage:link');
});
Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});
// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/new', [WebsiteController::class, 'index']);
Route::get('/', [WebsiteController::class, 'indexnew']);
Route::get('pages/clubs', [WebsiteController::class, 'clubs']);
Route::get('details/{id}', [WebsiteController::class, 'details']);
Route::get('from-campus', [WebsiteController::class, 'fromCampus']);
Route::get('student-corner', [WebsiteController::class, 'studentCorner']);
Route::get('admissionview', [WebsiteController::class, 'admissionview'])->name('admissionview');
Route::get('admissionviewxi', [WebsiteController::class, 'admissionviewxi'])->name('admissionviewxi');
Route::get('admissionviewkg', [WebsiteController::class, 'admissionviewkg'])->name('admissionviewkg');

Route::post('getCategoryView', [WebsiteController::class, 'getCategoryView'])->name('getCategoryView');
Route::post('admissionstore', [WebsiteController::class, 'admissionstore'])->name('admissionstore');
Route::post('admissionupdate', [AdmissionController::class, 'admissionupdate'])->name('admissionupdate');
Route::post('sendSmsForTemporaryID', [AdmissionController::class, 'sendSmsForTemporaryID'])->name('sendSmsForTemporaryID');
Route::post('admissionsearch', [WebsiteController::class, 'admissionsearch'])->name('admissionsearch');
Route::get('admissionSearchByNumber/{number}', [WebsiteController::class, 'admissionSearchByNumber'])->name('admissionSearchByNumber');
Route::get('admissionPrint/{number}/{download}', [WebsiteController::class, 'admissionPrint'])->name('admissionPrint');
Route::post('admissionData', [WebsiteController::class, 'admission'])->name('admissionData');
Route::post('admissionDatakg', [WebsiteController::class, 'admissionDatakg'])->name('admissionDatakg');
Route::get('/sslredirect', [WebsiteController::class, 'sslredirect'])->name('sslredirect');
Route::post('/payment', [WebsiteController::class, 'payment'])->name('payment');
Route::post('/usernamecheck', [WebsiteController::class, 'usernamecheck'])->name('usernamecheck');
Route::get('page/{slug}', [WebsiteController::class, 'page']);
Route::get('gallarydetails/{id}', [WebsiteController::class, 'gallarydetails']);
Route::get('detiales/{id}', [WebsiteController::class, 'detiales']);
Route::get('notice/{id}', [WebsiteController::class, 'detiales']);
//Route::post('checkadmissionstatus', [WebsiteController::class,'checkadmissionstatus'])->name('checkadmissionstatus');
Route::post('checkRollRegistrationNumber', [WebsiteController::class, 'checkRollRegistrationNumber'])->name('checkRollRegistrationNumber');
Route::post('checkTemporaryId', [WebsiteController::class, 'checkTemporaryId'])->name('checkTemporaryId');


Route::get('/qrcode', [QRcodeGenerateController::class, 'qrcode']);
// SSLCOMMERZ Start
Route::get('/example1', [SslCommerzPaymentController::class, 'exampleEasyCheckout']);
Route::get('/example2', [SslCommerzPaymentController::class, 'exampleHostedCheckout']);
Route::get('/validate-transaction/{transactionId}', [SslCommerzPaymentController::class, 'validateTransaction']);


Route::get('/paymentnow/{id}', [SslCommerzPaymentController::class, 'paymentnow'])->name('paymentnow');
Route::post('/pay', [SslCommerzPaymentController::class, 'index']);
Route::post('/pay-via-ajax', [SslCommerzPaymentController::class, 'payViaAjax']);

Route::post('/success', [SslCommerzPaymentController::class, 'success'])->name('success');
Route::post('/fail', [SslCommerzPaymentController::class, 'fail'])->name('fail');
Route::post('/cancel', [SslCommerzPaymentController::class, 'cancel'])->name('cancel');

Route::post('/sslipnurl', [SslCommerzPaymentController::class, 'ipn']);
//SSLCOMMERZ END
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');
Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function () {



    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('users', UserController::class);
    Route::get('customlogout', [UserController::class, 'logout'])->name('customlogout');

    /**
     * User Routes
     */

    Route::get('/change-password', [PasswordChangeController::class, 'showChangePasswordForm'])->name('change.password.form')->middleware('auth');
    Route::post('/change-password', [PasswordChangeController::class, 'changePassword'])->name('change.password')->middleware('auth');

    Route::resource('roles', RolesController::class);
    Route::resource('permissions', PermissionsController::class);



    Route::resource('/zoom', ZoomController::class);
    Route::resource('/version', VersionsController::class);
    Route::resource('/category', CategoryController::class);
    Route::resource('/session', SessionsController::class);
    Route::resource('/branch', BranchController::class);
    Route::resource('/shift', ShiftsController::class);
    Route::resource('/classes', ClassesController::class);
    Route::post('/getTypeWiseClass', [ClassesController::class, 'getTypeWiseClass'])->name('getTypeWiseClass');
    Route::post('/getClass', [ClassesController::class, 'getClass'])->name('getClass');
    Route::resource('/group', AcademySectionController::class);
    Route::resource('/discipline', DisciplineController::class);
    Route::post('/getDiscipline', [DisciplineController::class, 'getDiscipline'])->name('getDiscipline');
    Route::post('/getSpecialization', [SpecializationController::class, 'getSpecialization'])->name('getSpecialization');
    Route::resource('/specialization', SpecializationController::class);
    Route::resource('/degree', DegreeController::class);
    Route::resource('/house', HouseController::class);
    Route::resource('/subject', SubjectsController::class);
    Route::resource('/subjectmapping', ClassWiseSubjectController::class);
    Route::resource('/section', SectionsController::class);
    Route::get('/sectionWiseMapping', [SectionsController::class, 'sectionWiseMapping'])->name('sectionWiseMapping');
    Route::post('/sectionMappingStore', [SectionsController::class, 'sectionMappingStore'])->name('sectionMappingStore');
    Route::get('/sectionWiseStudent', [SectionsController::class, 'sectionWiseStudent'])->name('sectionWiseStudent');
    Route::get('/subjectWiseStudent', [SectionsController::class, 'subjectWiseStudent'])->name('subjectWiseStudent');
    Route::resource('/designation', DesignationController::class);
    Route::get('/admissionstatus', [DashboardController::class, 'admissionstatus'])->name('admissionstatus');
    Route::get('/attendanceDashboard', [DashboardController::class, 'attendanceDashboard'])->name('attendanceDashboard');
    Route::get('/attendanceDashboardDetails/{type_for}', [DashboardController::class, 'attendanceDashboardDetails'])->name('attendanceDashboardDetails');
    Route::get('/attendanceDashboardDetailsEmployee/{type_for}', [DashboardController::class, 'attendanceDashboardDetailsEmployee'])->name('attendanceDashboardDetails');
    Route::get('/classDashboard', [DashboardController::class, 'classDashboard'])->name('classDashboard');
    Route::get('/classDashboardSecond/{for}', [DashboardController::class, 'classDashboardSecond'])->name('classDashboardSecond');
    Route::get('/classDashboardDetails/{shift_id}/{version_id}', [DashboardController::class, 'classDashboardDetails'])->name('classDashboardDetails');
    Route::get('/classDashboardOngoingDetails/{shift_id}/{version_id}/{type}', [DashboardController::class, 'classDashboardOngoingDetails'])->name('classDashboardOngoingDetails');
    Route::get('/classDashboardDetailsRoutine/{shift_id}/{version_id}/{type}', [DashboardController::class, 'classDashboardDetailsRoutine'])->name('classDashboardDetailsRoutine');
    Route::get('/academyDashboard', [DashboardController::class, 'academyDashboard'])->name('academyDashboard');
    Route::get('/sylabusDashboard', [DashboardController::class, 'sylabusDashboard'])->name('sylabusDashboard');
    Route::get('/lessonPlanDashboard', [DashboardController::class, 'lessonPlanDashboard'])->name('lessonPlanDashboard');
    Route::get('/calendarDashboard', [DashboardController::class, 'calendarDashboard'])->name('calendarDashboard');
    Route::get('/calendarDashboard/{type}', [DashboardController::class, 'calendarDashboardType'])->name('calendarDashboardType');
    Route::get('/studentsDashboard', [DashboardController::class, 'studentsDashboard'])->name('studentsDashboard');
    Route::get('/studentGetTypeStudent/{type}', [DashboardController::class, 'studentGetTypeStudent'])->name('studentGetTypeStudent');
    Route::get('/studentClassWise/{shift_id}/{type}/{version_id}', [DashboardController::class, 'studentClassWise'])->name('studentClassWise');
    Route::get('/studentClassWiseSection/{shift_id}/{type}/{version_id}/{class_id}', [DashboardController::class, 'studentClassWiseSection'])->name('studentClassWiseSection');
    Route::get('/studentList/{shift_id}/{type}/{version_id}/{class_id}/{section_id}', [DashboardController::class, 'studentList'])->name('studentList');
    Route::get('/employeesDashboard', [DashboardController::class, 'employeesDashboard'])->name('employeesDashboard');
    Route::get('/getTeacherList/{for}', [DashboardController::class, 'getTeacherList'])->name('getTeacherList');
    Route::get('/getTeacherFor/{type}', [DashboardController::class, 'getTeacherFor'])->name('getTeacherFor');
    Route::get('/feesDashboard', [DashboardController::class, 'feesDashboard'])->name('feesDashboard');
    Route::resource('/fees', FeeController::class);
    Route::get('/feeClassWiseUpdate/{head_id}', [FeeController::class, 'feeClassWiseUpdate'])->name('feeClassWiseUpdate');
    Route::get('/studentXLFeeUpload', [FeeController::class, 'studentXLFeeUpload'])->name('studentXLFeeUpload');
    Route::post('/feeclasswiseUpdateSave', [FeeController::class, 'feeClassWiseUpdateSave'])->name('feeclasswiseUpdateSave');
    Route::post('/feeClassWiseUpdateStudent', [FeeController::class, 'feeClassWiseUpdateStudent'])->name('feeClassWiseUpdateStudent');
    Route::get('/feeClassWiseUpdate/{head_id}', [FeeController::class, 'feeClassWiseUpdate'])->name('feeClassWiseUpdate');
    Route::get('/feeSutdentWiseUpdate/{head_id}', [FeeController::class, 'feeSutdentWiseUpdate'])->name('feeSutdentWiseUpdate');
    Route::get('/feeSutdentWiseEntry/{head_id}', [FeeController::class, 'feeSutdentWiseEntry'])->name('feeSutdentWiseEntry');
    Route::post('/feeclasswiseEntrySave', [FeeController::class, 'feeclasswiseEntrySave'])->name('feeclasswiseEntrySave');
    Route::get('/feeHeadAmountView', [FeeController::class, 'feeHeadAmountView'])->name('feeHeadAmountView');
    Route::get('/feeCollection', [FeeController::class, 'feeCollection'])->name('feeCollection');
    Route::get('/outstandingTuitionFee', [FeeController::class, 'outstandingTuitionFee'])->name('outstandingTuitionFee');
    Route::get('/outstandingDue', [FeeController::class, 'outstandingDue'])->name('outstandingDue');
    Route::get('/outstandingTuitionFeeSummary', [FeeController::class, 'outstandingTuitionFeeSummary'])->name('outstandingTuitionFeeSummary');
    //Route::post('/feeCollection', [FeeController::class,'feeCollection'])->name('feeCollection');
    Route::resource('/fine', FineController::class);
    Route::resource('/evaluation', EvaluationController::class);
    Route::resource('/readmission', ReAdmissionController::class);
    Route::resource('/sessionCharge', SessionChargeController::class);
    Route::resource('/tutionFee', TutionFeeController::class);
    Route::resource('/studentWlfare', StudentWelfareController::class);
    Route::resource('/emisCharge', EmisChargeController::class);
    Route::resource('/examfee', ExamFeeController::class);
    Route::resource('/boardFee', BoardFeeController::class);
    Route::resource('/coachingFee', CoachingFeeController::class);
    Route::resource('/conveyanceFee', ConveyanceFeeController::class);
    Route::resource('/miscFee', MiscFeeController::class);
    Route::resource('/governmentCharge', GovernmentChargeController::class);
    Route::resource('/inactiveFine', InactiveFineController::class);
    Route::resource('/sms', SMSController::class);

    Route::get('/send_password', [SMSController::class, 'sendPassword'])->name('send_password');
    Route::post('/get-user-data', [SMSController::class, 'getUserDataByRole'])->name('getUserDataByRole');
    Route::post('/send-data', [SMSController::class, 'sendData'])->name('sendData');


    Route::post('/getAdmissionPhoneWithClass', [SMSController::class, 'getAdmissionPhoneWithClass'])->name('getAdmissionPhoneWithClass');
    Route::resource('/ssl', SSLController::class);
    Route::post('/feeHead', [FeeController::class, 'feeHead'])->name('feeHead');
    Route::get('/feeHeadamount', [FeeController::class, 'feeHeadamount'])->name('feeHeadamount');
    Route::post('/getCategoryWiseHeadFeeExport', [FeeController::class, 'getCategoryWiseHeadFeeExport'])->name('getCategoryWiseHeadFeeExport');
    Route::post('/getHeadWiseStudentFeeExport', [FeeController::class, 'getHeadWiseStudentFeeExport'])->name('getHeadWiseStudentFeeExport');
    Route::post('/studentfeeHeadWise', [FeeController::class, 'studentfeeHeadWise'])->name('studentfeeHeadWise');
    Route::post('/StudentFeeStatusUpdate', [FeeController::class, 'StudentFeeStatusUpdate'])->name('StudentFeeStatusUpdate');
    Route::post('/ClassCategoryWiseHeadFeeImport', [FeeController::class, 'ClassCategoryWiseHeadFeeImport'])->name('ClassCategoryWiseHeadFeeImport');
    Route::get('/categorywiseheaddelete/{id}', [FeeController::class, 'categorywiseheaddelete'])->name('categorywiseheaddelete');
    Route::post('/feeHeadamountSave', [FeeController::class, 'feeHeadamountSave'])->name('feeHeadamountSave');
    Route::get('/studentFeeGenerate', [FeeController::class, 'studentFeeGenerate'])->name('studentFeeGenerate');
    Route::get('/monthlyfeeFine', [FeeController::class, 'monthlyfeeFine'])->name('monthlyfeeFine');
    Route::post('/studentFeeAutoGenerate', [FeeController::class, 'studentFeeAutoGenerate'])->name('studentFeeAutoGenerate');
    Route::get('/viewStudentFee/{id}', [FeeController::class, 'viewStudentFee'])->name('viewStudentFee');
    Route::get('/employeeSalary', [FeeController::class, 'employeeSalary'])->name('employeeSalary');
    Route::get('/employeeSalaryGenerate', [FeeController::class, 'employeeSalaryGenerate'])->name('employeeSalaryGenerate');
    Route::post('/employeeSalaryGenerateStore', [FeeController::class, 'employeeSalaryGenerateStore'])->name('employeeSalaryGenerateStore');
    Route::get('/teacherPayment', [EmployeeController::class, 'teacherPayment'])->name('teacherPayment');
    Route::resource('/pages', PageController::class);
    Route::resource('/slider', SliderController::class);
    Route::resource('/notice-type', NoticeTypeController::class);
    Route::resource('/notice', NoticeController::class);
    Route::resource('/gallery-type', GalleryTypeController::class);
    Route::resource('/gallery', GalleryController::class);
    Route::resource('exams', ExamController::class);
    Route::post('getExam', [ExamController::class, 'getExam'])->name('getExam');
    Route::get('admitcard', [ExamController::class, 'admitcard'])->name('admitcard');
    Route::post('ajaxadmitcard', [ExamController::class, 'ajaxadmitcard'])->name('ajaxadmitcard');
    Route::get('attendanceSheet', [ExamController::class, 'attendanceSheet'])->name('attendanceSheet');
    Route::post('ajaxattendanceSheet', [ExamController::class, 'ajaxattendanceSheet'])->name('ajaxattendanceSheet');
    Route::post('getExamTimeShedules', [ExamTimeSheduleController::class, 'getExamTimeShedules'])->name('getExamTimeShedules');
    Route::post('getSubjectMarkTerms', [SubjectMarkTermController::class, 'getSubjectMarkTerms'])->name('getSubjectMarkTerms');
    Route::post('getSubjectMarks', [SubjectMarkController::class, 'getSubjectMarks'])->name('getSubjectMarks');
    Route::post('getOthersSubjectMarks', [SubjectMarkController::class, 'getOthersSubjectMarks'])->name('getOthersSubjectMarks');
    Route::post('getSubjectMarksBlank', [SubjectMarkController::class, 'getSubjectMarksBlank'])->name('getSubjectMarksBlank');
    Route::get('avarageMark', [SubjectMarkController::class, 'avarageMark'])->name('avarageMark');
    Route::post('saveAvarageMarks', [SubjectMarkController::class, 'saveAvarageMarks'])->name('saveAvarageMarks');
    Route::post('getAvarageMarks', [SubjectMarkController::class, 'getAvarageMarks'])->name('getAvarageMarks');
    Route::get('meritPosition', [SubjectMarkController::class, 'meritPosition'])->name('meritPosition');
    Route::get('AutoSection', [SubjectMarkController::class, 'AutoSection'])->name('AutoSection');
    Route::post('saveAddSection', [SubjectMarkController::class, 'saveAddSection'])->name('saveAddSection');
    Route::post('saveStudentSubjectMark', [SubjectMarkController::class, 'saveStudentSubjectMark'])->name('saveStudentSubjectMark');
    Route::post('getAddSection', [SubjectMarkController::class, 'getAddSection'])->name('getAddSection');
    Route::post('saveMeritPosition', [SubjectMarkController::class, 'saveMeritPosition'])->name('saveMeritPosition');
    Route::post('saveMeritSecondTimePosition', [SubjectMarkController::class, 'saveMeritSecondTimePosition'])->name('saveMeritSecondTimePosition');
    Route::post('getMeritPosition', [SubjectMarkController::class, 'getMeritPosition'])->name('getMeritPosition');
    Route::resource('exam-time-shedules', ExamTimeSheduleController::class);
    Route::resource('/subject_mark_terms', SubjectMarkTermController::class);
    Route::resource('subject_marks', SubjectMarkController::class);
    Route::get('subject_marks_ct_upload', [SubjectMarkController::class, 'subject_marks_ct_upload'])->name('subject_marks_ct_upload');
    Route::post('subject_marks_ct_upload_xl', [SubjectMarkController::class, 'subject_marks_ct_upload_xl'])->name('subject_marks_ct_upload_xl');
    Route::get('other_subject_marks', [SubjectMarkController::class, 'other_subject_marks'])->name('other_subject_marks');
    Route::get('subject_marks_others', [SubjectMarkController::class, 'subject_marks_others'])->name('subject_marks_others');
    Route::resource('/students', StudentController::class);
    Route::resource('/college-students', CollegeStudentController::class);
    Route::post('/student-inactive/{id}', [StudentController::class, 'studentInactive'])->name('studentInactive');
    Route::get('/studentfileupload', [StudentController::class, 'studentfileupload'])->name('studentfileupload');
    // Define the route for AJAX request to fetch subjects
    Route::get('/fetch-subjects', [CollegeStudentController::class, 'getSubjectsData'])->name('fetch.subjects');
    Route::get('/studentXlUpload', [StudentController::class, 'studentXlUpload'])->name('studentXlUpload');
    Route::post('/studentXlUploadSave', [StudentController::class, 'studentXlUploadSave'])->name('studentXlUploadSave');
    Route::post('/studentUpdate', [StudentController::class, 'studentUpdate'])->name('studentUpdate');
    Route::post('/storePreview', [StudentController::class, 'storePreview'])->name('storePreview');
    Route::get('/studentPrint/{code}', [StudentController::class, 'studentPrint'])->name('studentPrint');
    Route::get('/studentPrintD/{code}', [StudentController::class, 'studentPrintD'])->name('studentPrintD');
    Route::get('/studentConfirm/{id}', [StudentController::class, 'studentConfirm'])->name('studentConfirm');
    Route::post('/studentpreview', [StudentController::class, 'studentpreview'])->name('studentpreview');
    Route::post('/college-student-preview', [CollegeStudentController::class, 'studentpreview'])->name('college.student.preview');
    Route::post('/getStudentDetails', [StudentController::class, 'getStudentDetails'])->name('getStudentDetails');
    Route::post('/admissionSave', [StudentController::class, 'admissionSave'])->name('admissionSave');
    Route::post('/college-admission-save', [CollegeStudentController::class, 'admissionCollegeSave'])->name('admission.college.save');
    Route::post('/checksection', [StudentController::class, 'checksection'])->name('checksection');
    Route::post('admin/studentSearchByClass', [StudentController::class, 'studentSearchByClass'])->name('studentSearchByClass');
    Route::get('/StudentProfile/{id}', [StudentController::class, 'StudentProfile'])->name('StudentProfile');
    Route::POST('/uploadimage', [StudentController::class, 'uploadimage'])->name('uploadimage');
    Route::POST('/uploadTeacherimage', [EmployeeController::class, 'uploadTeacherimage'])->name('uploadTeacherimage');
    Route::get('/getidcard', [StudentController::class, 'getidcard'])->name('getidcard');
    Route::get('/getidcardd', [StudentController::class, 'getidcardd'])->name('getidcardd');
    Route::get('/sAttendance', [StudentController::class, 'studentAttendance'])->name('studentAttendanceparentAttendance');
    Route::get('/studentRouten', [StudentController::class, 'studentRouten'])->name('studentRouten');
    Route::get('/studentSyllabus', [StudentController::class, 'studentSyllabus'])->name('studentSyllabus');
    Route::get('/studentNotice', [StudentController::class, 'studentNotice'])->name('studentNotice');
    Route::get('/studentFee', [StudentController::class, 'studentFee'])->name('studentFee');
    Route::post('/getTeacherDetails', [EmployeeController::class, 'getTeacherDetails'])->name('getTeacherDetails');
    Route::get('/employeeUser', [EmployeeController::class, 'employeeUser'])->name('employeeUser');
    Route::get('/parentUserCreate', [EmployeeController::class, 'parentUserCreate'])->name('parentUserCreate');
    Route::post('/parentUser', [EmployeeController::class, 'parentUser'])->name('parentUser');
    Route::get('/import', [StudentController::class, 'import']);
    Route::get('/employeeImport', [EmployeeController::class, 'employeeImport']);
    Route::post('/saveEmployee', [EmployeeController::class, 'store'])->name('saveEmployee');
    Route::post('/saveEducation', [EmployeeController::class, 'saveEducation'])->name('saveEducation');
    Route::post('/employeeSalary', [EmployeeController::class, 'employeeSalary'])->name('employeeSalary');
    Route::post('/getEmployeeHeadDetails', [EmployeeController::class, 'getEmployeeHeadDetails'])->name('getEmployeeHeadDetails');
    Route::post('/getEmployeeDetails', [EmployeeController::class, 'getEmployeeDetails'])->name('getEmployeeDetails');
    Route::get('/teacherProfile', [EmployeeController::class, 'teacherProfile'])->name('teacherProfile');
    Route::get('/teacherRouten', [EmployeeController::class, 'teacherRouten'])->name('teacherRouten');
    Route::get('/teacherSectionRoutine/{sectionid}', [EmployeeController::class, 'teacherSectionRoutine'])->name('teacherSectionRoutine');
    Route::get('/teacherClass', [EmployeeController::class, 'teacherClass'])->name('teacherClass');
    Route::get('/teacherSyllabus', [EmployeeController::class, 'teacherSyllabus'])->name('teacherSyllabus');
    Route::get('/teacherLessonplan', [EmployeeController::class, 'teacherLessonplan'])->name('teacherLessonplan');
    Route::get('/teacherYearCalender', [EmployeeController::class, 'teacherYearCalender'])->name('teacherYearCalender');
    Route::get('/teacherStudentAttendance', [EmployeeController::class, 'teacherStudentAttendance'])->name('teacherStudentAttendance');
    Route::get('/teacherStudentAttendanceReport', [EmployeeController::class, 'teacherStudentAttendanceReport'])->name('teacherStudentAttendanceReport');
    Route::get('/getStudentsAttendanceStatusWithDate', [EmployeeController::class, 'getStudentsAttendanceStatusWithDate'])->name('getStudentsAttendanceStatusWithDate');
    Route::get('/getidcardByTeacher/{id}', [EmployeeController::class, 'getidcardd'])->name('getidcardByTeacher');
    Route::get('/teacherStudentResult', [EmployeeController::class, 'teacherStudentResult'])->name('teacherStudentResult');
    Route::resource('/employees', EmployeeController::class);
    Route::resource('/attendance', AttendanceController::class);

    Route::post('/get-students', [AttendanceController::class, 'getStudentsExamAttendence'])->name('getStudentsExamAttendence');
    Route::post('/store-attendence', [AttendanceController::class, 'storeAttendance'])->name('storeAttendance');
    Route::get('/student-attendence', [AttendanceController::class, 'studentAttendence'])->name('studentAttendence');

    Route::get('/showCertificateList', [AttendanceController::class, 'showCertificateList'])->name('showCertificateList');
    Route::get('/transfer-certificate', [AttendanceController::class, 'showCertificateForm'])->name('transferCertificate');
    Route::post('/transfer-certificate/generate', [AttendanceController::class, 'generateTransferCertificate'])->name('generateCertificate');
    Route::get('/getCertificate/{student_code}', [AttendanceController::class, 'getTransferCertificate'])->name('getCertificate');


    Route::resource('/year-calendar', YearCalendarController::class);
    Route::get('/studentAttendance', [AttendanceController::class, 'studentAttendance'])->name('studentAttendance');
    Route::post('/getAttendanceByDate', [AttendanceController::class, 'getAttendanceByDate'])->name('getAttendanceByDate');
    Route::get('/studentAttendanceReport', [AttendanceController::class, 'studentAttendanceReport'])->name('studentAttendanceReport');
    Route::post('/studentAttendanceStore', [AttendanceController::class, 'studentAttendanceStore'])->name('studentAttendanceStore');
    Route::post('/teacherAttendanceStore', [AttendanceController::class, 'teacherAttendanceStore'])->name('teacherAttendanceStore');
    Route::post('/staffAttendanceStore', [AttendanceController::class, 'staffAttendanceStore'])->name('staffAttendanceStore');
    Route::post('/getSections', [AttendanceController::class, 'getSections'])->name('getSections');
    Route::post('/getSectionsForSMS', [AttendanceController::class, 'getSectionsForSMS'])->name('getSectionsForSMS');
    Route::post('/getStudentOrTeacherData', [AttendanceController::class, 'getStudentOrTeacherData'])->name('getStudentOrTeacherData');
    Route::get('/getStudents', [AttendanceController::class, 'getStudents'])->name('getStudents');
    Route::get('/getStudentByClass', [AttendanceController::class, 'getStudentByClass'])->name('getStudentByClass');
    Route::get('/getStudentsReport', [AttendanceController::class, 'getStudentsReport'])->name('getStudentsReport');
    Route::get('/getTeachers', [AttendanceController::class, 'getTeachers'])->name('getTeachers');
    Route::get('/getStaffs', [AttendanceController::class, 'getStaffs'])->name('getStaffs');
    Route::get('/getStaffsReport', [AttendanceController::class, 'getStaffsReport'])->name('getStaffsReport');
    Route::get('/allteacherAttendance', [AttendanceController::class, 'teacherAttendance'])->name('allteacherAttendance');
    Route::get('/teacherAttendance', [EmployeeController::class, 'teacherAttendance'])->name('teacherAttendance');
    Route::get('/teacherStudent', [EmployeeController::class, 'teacherStudent'])->name('teacherStudent');
    Route::get('/teacherAttendanceReport', [AttendanceController::class, 'teacherAttendanceReport'])->name('teacherAttendanceReport');
    Route::get('/staffAttendance', [AttendanceController::class, 'staffAttendance'])->name('staffAttendance');
    Route::get('/staffAttendanceReport', [AttendanceController::class, 'staffAttendanceReport'])->name('staffAttendanceReport');
    Route::get('/tabulationSection', [TabulationController::class, 'tabulationSection'])->name('tabulationSection');
    Route::get('/academicTranscript', [TabulationController::class, 'academicTranscript'])->name('academicTranscript');
    Route::get('/passlistTeacher', [TabulationController::class, 'passlistTeacher'])->name('passlistTeacher');
    Route::get('/faillistTeacher', [TabulationController::class, 'faillistTeacher'])->name('faillistTeacher');
    Route::get('/tabulationSectionTeacher', [TabulationController::class, 'tabulationSectionTeacher'])->name('tabulationSectionTeacher');
    Route::post('/getTabulationSection', [TabulationController::class, 'getTabulationSection'])->name('getTabulationSection');
    Route::post('/getTabulation', [TabulationController::class, 'getTabulation'])->name('getTabulation');
    Route::resource('/routine', ClassRoutineController::class);
    Route::post('/routineXlUpload', [ClassRoutineController::class, 'routineXlUpload'])->name('routineXlUpload');
    Route::resource('/tabulation', TabulationController::class);

    Route::get('/merit_list', [TabulationController::class, 'merit_list'])->name('merit_list');
    Route::get('/meritlistTeacher', [TabulationController::class, 'meritlistTeacher'])->name('meritlistTeacher');
    Route::post('/getMeritList', [TabulationController::class, 'getMeritList'])->name('getMeritList');


    Route::get('/pass_list', [TabulationController::class, 'pass_list'])->name('pass_list');
    Route::post('/getPassList', [TabulationController::class, 'getPassList'])->name('getPassList');
    Route::post('/getFailList', [TabulationController::class, 'getFailList'])->name('getFailList');
    Route::get('/fail_list', [TabulationController::class, 'fail_list'])->name('fail_list');
    Route::get('/getTime', [ClassRoutineController::class, 'getTime'])->name('getTime');
    Route::post('/getSubject', [ClassRoutineController::class, 'getSubject'])->name('getSubject');
    Route::post('/getSubjects', [ClassRoutineController::class, 'getSubjects'])->name('getSubjects');
    Route::post('/getOtherSubjects', [ClassRoutineController::class, 'getOtherSubjects'])->name('getOtherSubjects');
    Route::post('/getTeachersByPost', [ClassRoutineController::class, 'getTeachers'])->name('getTeachersByPost');
    Route::get('/getTeachersReport', [AttendanceController::class, 'getTeachersReport'])->name('getTeachersReport');
    Route::get('/getRoutine', [ClassRoutineController::class, 'getRoutine'])->name('getRoutine');
    Route::resource('/rfid', RfidController::class);
    Route::resource('/teacherassign', TeacherSessionController::class);
    Route::resource('/studentPromot', StudentSessionController::class);

    Route::resource('syllabus', SyllabusController::class);
    Route::resource('lessonplan', LeasonPlanController::class);
    Route::get('lessonPlanStudent', [LeasonPlanController::class, 'lessonPlanStudent'])->name('lessonPlanStudent');
    Route::resource('articles', ArticleController::class);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/common/{table}/{condision}', [DashboardController::class, 'common'])->name('common');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('/admissionlist', AdmissionController::class);
    Route::get('/passwordRecovery/{code}/{phone}', [AdmissionController::class, 'passwordRecovery'])->name('passwordRecovery');
    Route::get('/admissionXl/{classid}/{sectionid}', [AdmissionController::class, 'admissionXl'])->name('admissionXl');
    Route::get('/admissionXlFemale/{classid}/{sectionid}', [AdmissionController::class, 'admissionXlFemale'])->name('admissionXlFemale');
    Route::get('/admissionXlMale/{classid}/{sectionid}', [AdmissionController::class, 'admissionXlMale'])->name('admissionXlMale');
    Route::get('/admissionXlTotal/{classid}', [AdmissionController::class, 'admissionXlTotal'])->name('admissionXlTotal');
    Route::get('/admissionXlTotalFemale/{classid}', [AdmissionController::class, 'admissionXlTotalFemale'])->name('admissionXlTotalFemale');
    Route::get('/admissionXlTotalMale/{classid}', [AdmissionController::class, 'admissionXlTotalMale'])->name('admissionXlTotalMale');
    Route::get('/duplicateTemporaryID', [AdmissionController::class, 'duplicateTemporaryID'])->name('duplicateTemporaryID');
    Route::get('/getTotalStudentBySectionSubject/{section_id}/{subject}', [AdmissionController::class, 'getTotalStudentBySectionSubject'])->name('getTotalStudentBySectionSubject');
    Route::get('/getTotalStudentBySubjectGroup/{subject}/{group_id}', [AdmissionController::class, 'getTotalStudentBySubjectGroup'])->name('getTotalStudentBySubjectGroup');
    Route::get('/getTotalStudentBySubject/{subject}', [AdmissionController::class, 'getTotalStudentBySubject'])->name('getTotalStudentBySubject');
    Route::get('/admissionOpen', [AdmissionController::class, 'admissionOpen'])->name('admissionOpen');
    Route::get('/admissionIdCard', [AdmissionController::class, 'admissionIdCard'])->name('admissionIdCard');
    Route::get('/showStudentCounts', [AdmissionController::class, 'showStudentCounts'])->name('showStudentCounts');
    Route::get('/collegeAdmission', [AdmissionController::class, 'collegeAdmission'])->name('collegeAdmission');
    Route::get('/boardList', [AdmissionController::class, 'boardList'])->name('boardList');
    Route::get('/kgAdmitList', [AdmissionController::class, 'kgAdmitList'])->name('kgAdmitList');
    Route::get('/kgAdmitLottery', [AdmissionController::class, 'kgAdmitLottery'])->name('kgAdmitLottery');
    Route::post('/ajaxLottery', [AdmissionController::class, 'ajaxLottery'])->name('ajaxLottery');
    Route::post('/ajaxWinnerLottery', [AdmissionController::class, 'ajaxWinnerLottery'])->name('ajaxWinnerLottery');
    Route::post('/admission/update', [AdmissionController::class, 'updateKgAdmit'])->name('admission.update');
    Route::post('/admission/store', [AdmissionController::class, 'storeKgAdmit'])->name('admission.store');

    Route::get('/sectionupdate/{class_code}', [AdmissionController::class, 'sectionupdate'])->name('sectionupdate');
   
    Route::resource('studentPromotion', PromotionController::class);
    Route::post('studentPromotionxl', [PromotionController::class, 'studentPromotionxl'])->name('studentPromotionxl');
    Route::resource('approval_stage', ApprovalStageController::class);
    

    Route::resource('category_wise_leave_balance', CategoryWiseLeaveBalanceController::class);

    Route::resource('documents', DocumentController::class);

});



require __DIR__ . '/auth.php';
