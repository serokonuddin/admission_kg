<?php

use App\Http\Controllers\AcademyInfoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\BranchController;

use App\Http\Controllers\ClassesController;
use App\Http\Controllers\ClassRoutineController;

use App\Http\Controllers\DesignationController;

use App\Http\Controllers\AcademySectionController;
use App\Http\Controllers\ClassWiseSubjectController;

use App\Http\Controllers\HouseController;

use App\Http\Controllers\RfidController;
use App\Http\Controllers\SectionsController;

use App\Http\Controllers\CategoryController;


use App\Http\Controllers\SessionsController;
use App\Http\Controllers\ShiftsController;
use App\Http\Controllers\StudentSessionController;
use App\Http\Controllers\SubjectsController;
use App\Http\Controllers\TeacherSessionController;
use App\Http\Controllers\VersionsController;

use App\Http\Controllers\WebsiteController;
use App\Http\Controllers\FeeController;

use App\Http\Controllers\ReAdmissionController;

use App\Http\Controllers\SslCommerzPaymentController;
use App\Http\Controllers\AdmissionController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\PasswordChangeController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\CollegeStudentController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\QRcodeGenerateController;
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\Report\ReportController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\SSLController;
use App\Http\Controllers\SMSController;

use App\Http\Controllers\SendMailController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect('/');
})->name('logout.get');
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
Route::get('/attendanceDashboard', [DashboardController::class, 'attendanceDashboard'])->name('attendanceDashboard');

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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/session-expired', [WebsiteController::class, 'sessionexpired'])->name('session-expired');


Route::get('/', [WebsiteController::class, 'admissionview']);
Route::get('admissionview', [WebsiteController::class, 'admissionview'])->name('admissionview');
Route::get('admissionviewxi', [WebsiteController::class, 'admissionviewxi'])->name('admissionviewxi');
Route::get('admissionviewkg', [WebsiteController::class, 'admissionviewkg'])->name('admissionviewkg');
Route::post('/getSections', [AttendanceController::class, 'getSections'])->name('getSections');
Route::post('getCategoryView', [WebsiteController::class, 'getCategoryView'])->name('getCategoryView');
Route::post('admissionstore', [WebsiteController::class, 'admissionstore'])->name('admissionstore');
Route::post('admissionupdate', [AdmissionController::class, 'admissionupdate'])->name('admissionupdate');
Route::get('sendSmsForKGAdmission', [AdmissionController::class, 'sendSmsForKGAdmission'])->name('sendSmsForKGAdmission');
Route::post('sendSmsForTemporaryID', [AdmissionController::class, 'sendSmsForTemporaryID'])->name('sendSmsForTemporaryID');
Route::post('/getSections', [AttendanceController::class, 'getSections'])->name('getSections');
Route::post('admissionsearch', [WebsiteController::class, 'admissionsearch'])->name('admissionsearch');
Route::get('admissionSearchByNumber/{number}', [WebsiteController::class, 'admissionSearchByNumber'])->name('admissionSearchByNumber');
Route::get('admissionPrint/{number}/{download}', [WebsiteController::class, 'admissionPrint'])->name('admissionPrint');
Route::post('admissionData', [WebsiteController::class, 'admission'])->name('admissionData');
Route::post('admissionDatakg', [WebsiteController::class, 'admissionDatakg'])->name('admissionDatakg');
Route::get('/sslredirect', [WebsiteController::class, 'sslredirect'])->name('sslredirect');
Route::post('/payment', [WebsiteController::class, 'payment'])->name('payment');
Route::post('/usernamecheck', [WebsiteController::class, 'usernamecheck'])->name('usernamecheck');
Route::get('page/{slug}', [WebsiteController::class, 'page']);
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
// Route::get('/success/{id}', [SslCommerzPaymentController::class, 'success1'])->name('successWithId');

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
    Route::resource('/sendmail', SendMailController::class);

    Route::resource('users', UserController::class);
    Route::get('sendSmsUser', [UserController::class, 'sendSmsUser'])->name('sendSmsUser');
    Route::get('reset-password/{id}', [UserController::class, 'resetPassword'])->name('users.resetPassword');
    Route::get('customlogout', [UserController::class, 'logout'])->name('customlogout');
    Route::get('updatePassword', [UserController::class, 'updatePassword'])->name('updatePassword');

    /**
     * User Routes
     */

    Route::get('/change-password', [PasswordChangeController::class, 'showChangePasswordForm'])->name('change.password.form')->middleware('auth');
    Route::post('/change-password', [PasswordChangeController::class, 'changePassword'])->name('change.password')->middleware('auth');

    Route::resource('roles', RolesController::class);
    Route::resource('permissions', PermissionsController::class);




    Route::resource('/version', VersionsController::class);
    Route::resource('/category', CategoryController::class);
    Route::resource('/session', SessionsController::class);
    Route::resource('/branch', BranchController::class);
    Route::resource('/shift', ShiftsController::class);
    Route::resource('/classes', ClassesController::class);
    Route::post('/getTypeWiseClass', [ClassesController::class, 'getTypeWiseClass'])->name('getTypeWiseClass');
    Route::post('/getClass', [ClassesController::class, 'getClass'])->name('getClass');
    Route::resource('/group', AcademySectionController::class);

    Route::resource('/house', HouseController::class);
    Route::resource('/subject', SubjectsController::class);
    Route::resource('/subjectmapping', ClassWiseSubjectController::class);
    Route::resource('/section', SectionsController::class);
    Route::get('/sectionWiseMapping', [SectionsController::class, 'sectionWiseMapping'])->name('sectionWiseMapping');
    Route::post('/sectionMappingStore', [SectionsController::class, 'sectionMappingStore'])->name('sectionMappingStore');
    Route::delete('/sectionmappingDestroy/{id}', [SectionsController::class, 'sectionmappingDestroy'])->name('sectionmappingDestroy');

    Route::get('/sectionWiseStudent', [SectionsController::class, 'sectionWiseStudent'])->name('sectionWiseStudent');
    Route::get('/subjectWiseStudent', [SectionsController::class, 'subjectWiseStudent'])->name('subjectWiseStudent');
    Route::resource('/designation', DesignationController::class);
    Route::get('/admissionstatus', [DashboardController::class, 'admissionstatus'])->name('admissionstatus');


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

    //Route::post('/feeCollection', [FeeController::class,'feeCollection'])->name('feeCollection');

    Route::resource('/readmission', ReAdmissionController::class);


    Route::resource('/sms', SMSController::class);

    Route::get('/send_password', [SMSController::class, 'sendPassword'])->name('send_password');
    Route::post('/get-user-data', [SMSController::class, 'getUserDataByRole'])->name('getUserDataByRole');
    Route::post('/send-data', [SMSController::class, 'sendData'])->name('sendData');


    Route::post('/getAdmissionPhoneWithClass', [SMSController::class, 'getAdmissionPhoneWithClass'])->name('getAdmissionPhoneWithClass');
    Route::resource('/ssl', SSLController::class);
    Route::post('/feeHead', [FeeController::class, 'feeHead'])->name('feeHead');





    Route::resource('/students', StudentController::class);
    Route::post('saveDisciplinaryIssues', [StudentController::class, 'saveDisciplinaryIssues'])->name('saveDisciplinaryIssues');
    Route::post('/getAttendanceByDate', [AttendanceController::class, 'getAttendanceByDate'])->name('getAttendanceByDate');
    Route::post('/student-inactive/{id}', [StudentController::class, 'studentInactive'])->name('studentInactive');
    Route::post('/student-pid/{id}', [StudentController::class, 'studentPid'])->name('studentPid');
    Route::get('/student-id-card', [StudentController::class, 'studentIDCards'])->name('studentIDCards');
    Route::get('/get-student-id-card', [StudentController::class, 'getStudentIDCards'])->name('getStudentIDCards');
    Route::post('/getLastRoll', [StudentController::class, 'getLastRoll'])->name('getLastRoll');
    Route::resource('/college-students', CollegeStudentController::class);
    // Define the route for AJAX request to fetch subjects
    Route::get('/fetch-subjects', [CollegeStudentController::class, 'getSubjectsData'])->name('fetch.subjects');

    Route::get('/boardResult', [StudentController::class, 'boardResult'])->name('boardResult');
    Route::get('/getBoardResults', [StudentController::class, 'getBoardResults'])->name('getBoardResults');
    Route::post('/studentBasicInfoXlUploadSave', [StudentController::class, 'studentBasicInfoXlUploadSave'])->name('studentBasicInfoXlUploadSave');
    Route::post('/studentSujectUploadSave', [StudentController::class, 'studentSujectUploadSave'])->name('studentSujectUploadSave');
    Route::post('/boardResulXlUploadSave', [StudentController::class, 'boardResulXlUploadSave'])->name('boardResulXlUploadSave');
    Route::post('/studentUpdate', [StudentController::class, 'studentUpdate'])->name('studentUpdate');
    Route::get('/studentfileupload', [StudentController::class, 'studentfileupload'])->name('studentfileupload');
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
    Route::post('/parentUser', [EmployeeController::class, 'parentUser'])->name('parentUser');
    Route::get('/import', [StudentController::class, 'import']);

    // Route::post('/employeeSalary', [EmployeeController::class, 'employeeSalary'])->name('employeeSalary');

    Route::get('/export', [StudentController::class, 'excelDownload'])->name('students.excel.export');
    Route::get('/pidformat-export', [StudentController::class, 'pidExcelFormatDownload'])->name('pidExcelFormatDownload');
    Route::get('/createStudentUser', [UserController::class, 'createStudentUser'])->name('students.createStudentUser');
    Route::get('/employee/export', [EmployeeController::class, 'excelDownload'])->name('employee.excel.export');
    Route::post('/get-students', [AttendanceController::class, 'getStudentsExamAttendence'])->name('getStudentsExamAttendence');


    // Attendace Reconciliation ends here
    // Attendance Report for specific student starts here





    Route::post('/get-class-wise-sections', [StudentController::class, 'getClassWiseSections'])->name('class-wise-sections');
    Route::post('/get-class-wise-session', [StudentController::class, 'getClassWiseSessions'])->name('class-wise-session');
    Route::post('/getLastRollAdmission', [StudentController::class, 'getLastRollAdmission'])->name('getLastRollAdmission');
    Route::post('/get-class-wise-employees', [EmployeeController::class, 'getClassWiseEmployees'])->name('getClassWiseEmployees');
    Route::post('/get-class-wise-subjects', [StudentController::class, 'getClassWiseSubjects'])->name('getClassWiseSubjects');
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

    // Attendance of a specific student report




    // Student Academic Reports
    Route::resource('academyinfos', AcademyInfoController::class);
    Route::get('/student/academicTranscript', [AcademyInfoController::class, 'index'])->name('student.academicTranscript');
    Route::post('/student/get/academicTranscript', [AcademyInfoController::class, 'getAcademicTranscript'])->name('student.getAcademicTranscript');


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
    Route::get('/boardList', [AdmissionController::class, 'boardList'])->name('boardList');
    Route::get('/kgAdmitList', [AdmissionController::class, 'kgAdmitList'])->name('kgAdmitList');
    Route::get('/kgAdmitLottery', [AdmissionController::class, 'kgAdmitLottery'])->name('kgAdmitLottery');
    Route::get('/collegeAdmission', [AdmissionController::class, 'collegeAdmission'])->name('collegeAdmission');


    Route::post('/CollegeAdmisionByTeacher', [AdmissionController::class, 'CollegeAdmisionByTeacher'])->name('CollegeAdmisionByTeacher');
    Route::get('/showStudentCounts', [AdmissionController::class, 'showStudentCounts'])->name('showStudentCounts');
    Route::post('/ajaxLottery', [AdmissionController::class, 'ajaxLottery'])->name('ajaxLottery');
    Route::post('/ajaxWinnerLottery', [AdmissionController::class, 'ajaxWinnerLottery'])->name('ajaxWinnerLottery');
    Route::post('/admission/update', [AdmissionController::class, 'updateKgAdmit'])->name('admission.update');
    Route::post('/admission/store', [AdmissionController::class, 'storeKgAdmit'])->name('admission.store');

    Route::get('/sectionupdate/{class_code}', [AdmissionController::class, 'sectionupdate'])->name('sectionupdate');
});



require __DIR__ . '/auth.php';
