<?php

use App\Models\ClassCategoryHeadFee;
use Illuminate\Support\Facades\DB;

function getStudent($groupby, $select, $common_array)
{

    $sql = "
    with studentdata as (select sa.id,sa.student_code
    ,sa.first_name
    ,sa.last_name
    ,sa.bangla_name
    ,sa.mobile
    ,sa.email
    ,sa.photo
    ,sa.sms_notification
    ,sa.birthdate
    ,s.session_name
    ,v.version_name
    ,sh.shift_name
    ,c.class_name
    ,c.class_code
    ,c.class_for
    ,sc.section_name
    ,ca.category_name
    ,sa.category_id
    ,a.session_id
    ,a.version_id
    ,a.shift_id
    ,a.class_id
    ,a.section_id
    ,a.roll
    ,sa.active
    ,a.active as student_activity_active
    from students sa
        join student_activity a on a.student_code=sa.student_code
        left join Category ca on ca.id=sa.category_id
        left join sessions s on s.id=a.session_id
        left join versions v on v.id=a.version_id
        left join shifts sh on sh.id=a.shift_id
        left join classes c on c.class_code=a.class_code
        left join sections sc on sc.id=a.section_id
        )
    select " . $select . " from studentdata
    where active=1 and student_activity_active=1
    ";
    // if (isset($common_array['class_for']) && $common_array['class_for']) {
    //     $sql .= " and class_for=" . $common_array['class_for'];
    // }
    if (isset($common_array['session_id'])  && $common_array['session_id']) {
        if (isset($common_array['class_code']) && $common_array['class_code'] >= 11 && date('m') <= 6) {
            $sql .= " and session_id=" . ($common_array['session_id'] - 1);
        } else {
            $sql .= " and session_id=" . $common_array['session_id'];
        }
    }
    if (isset($common_array['version_id'])  && $common_array['version_id']) {
        $sql .= " and version_id=" . $common_array['version_id'];
    }
    if (isset($common_array['shift_id'])  && $common_array['shift_id']) {
        $sql .= " and shift_id=" . $common_array['shift_id'];
    }
    if (isset($common_array['class_id'])  && $common_array['class_id']) {
        $sql .= " and class_id=" . $common_array['class_id'];
    }
    if (isset($common_array['class_code'])  && $common_array['class_code']) {
        $sql .= " and class_code=" . $common_array['class_code'];
    }
    if (isset($common_array['section_id'])  && $common_array['section_id']) {
        $sql .= " and section_id=" . $common_array['section_id'];
    }
    if (isset($common_array['student_code'])  && $common_array['student_code']) {
        $sql .= " and student_code=" . $common_array['student_code'];
    }

    if (isset($common_array['name'])) {

        if (substr($common_array['name'], 0, 2) == '01') {
            $sql .= " and mobile like '%" . $common_array['name'] . "%'";
        } elseif (is_numeric($common_array['name'])) {
            $sql .= " and student_code=" . $common_array['name'];
        } elseif (strpos($common_array['name'], '@', 1) != 0) {
            $sql .= " and email=" . $common_array['name'];
        } else {
            $sql .= " and first_name like '%" . $common_array['name'] . "%'";
        }
    }

    if ($groupby) {
        $sql .= " group by " . $groupby . " ";
    }
    $sql .= " order by ";
    $sql .= ($groupby) ? $groupby : " roll" . " asc";
    // dd($sql);
    return DB::select($sql);
}

function getStudentByClassType($session_id)
{
    $sql = "SELECT
        session_id,
        CASE
            WHEN class_code BETWEEN 0 AND 5 THEN '1'
            WHEN class_code BETWEEN 6 AND 10 THEN '2'
            WHEN class_code BETWEEN 11 AND 12 THEN '3'
            ELSE 'Other'
        END AS class_type,
        COUNT(*) AS total
    FROM
        student_activity
    WHERE
        session_id = :session_id
    GROUP BY
        session_id,
        class_type
    ORDER BY
        class_type";

    return DB::select($sql, ['session_id' => $session_id]);
}
function getStudentByCollegeClassType($session_id)
{
    $sql = "SELECT
        session_id,
        CASE
            WHEN class_code BETWEEN 0 AND 5 THEN '1'
            WHEN class_code BETWEEN 6 AND 10 THEN '2'
            WHEN class_code BETWEEN 11 AND 12 THEN '3'
            ELSE 'Other'
        END AS class_type,
        COUNT(*) AS total
    FROM
        student_activity
    WHERE
        session_id = :session_id
    GROUP BY
        session_id,
        class_type
    ORDER BY
        class_type";

    return DB::select($sql, ['session_id' => $session_id]);
}




function getStudentAttandance($groupby, $select, $common_array)
{
    $sql = "
    with studentattendance as (select sa.student_code
    ,sa.first_name
    ,sa.last_name
    ,sa.bangla_name
    ,sa.mobile
    ,sa.email
    ,sa.photo
    ,sa.birthdate
    ,a.attendance_date
    ,a.status
    ,s.session_name
    ,v.version_name
    ,sh.shift_name
    ,c.class_name
    ,c.class_for
    ,sc.section_name
    ,ca.category_name
    ,sa.category_id
    ,a.session_id
    ,a.version_id
    ,a.shift_id
    ,a.class_id
    ,a.section_id
    ,sa.active
    from students sa
        left join attendances a on a.student_code=sa.student_code
        left join Category ca on ca.id=sa.category_id
        left join sessions s on s.id=a.session_id
        left join versions v on v.id=a.version_id
        left join shifts sh on sh.id=a.shift_id
        left join classes c on c.id=a.class_id
        left join sections sc on sc.id=a.section_id
        )
    select " . $select . " from studentattendance
    where active=1 and attendance_date between '" . $common_array['start_date'] . "' and '" . $common_array['end_date'] . "'
    ";

    if ($common_array['session_id']) {
        $sql .= " and session_id=" . $common_array['session_id'];
    }
    if ($common_array['version_id']) {
        $sql .= " and version_id=" . $common_array['version_id'];
    }
    if ($common_array['shift_id']) {
        $sql .= " and shift_id=" . $common_array['shift_id'];
    }
    if ($common_array['section_id']) {
        $sql .= " and section_id=" . $common_array['section_id'];
    }
    if ($common_array['student_code']) {
        $sql .= " and student_code=" . $common_array['student_code'];
    }
    if ($groupby) {
        $sql .= " group by " . $groupby;
    }
    $sql .= " order by " . $groupby . " asc";
    return DB::select($sql);
}




function getEmployee($groupby, $select, $common_array)
{

    $sql = "select " . $select . " from employees em
    left join Category ea on ea.id=em.category_id
    left join designations d on d.id=em.designation_id
    where em.active =1 and category_id is not null and category_id!=2 and employee_for is not null and employee_for!=4
    ";
    if (isset($common_array['category_id']) && $common_array['category_id']) {
        $sql .= " and category_id=" . $common_array['category_id'];
    }
    if (isset($common_array['designation_id']) && $common_array['designation_id']) {
        $sql .= " and designation_id=" . $common_array['designation_id'];
    }
    if (isset($common_array['subject_id']) && $common_array['subject_id']) {
        $sql .= " and subject_id=" . $common_array['subject_id'];
    }


    if (isset($common_array['name']) && $common_array['name']) {

        if (substr($common_array['name'], 0, 2) == '01') {
            $sql .= " and mobile like '%" . $common_array['name'] . "%'";
        } elseif (is_numeric($common_array['name'])) {
            $sql .= " and emp_id=" . $common_array['name'];
        } elseif (strpos($common_array['name'], '@', 1) != 0) {
            $sql .= " and email=" . $common_array['name'];
        } else {
            $sql .= " and employee_name like '%" . $common_array['name'] . "%'";
        }
    }
    if (isset($common_array['employee_for']) && $common_array['employee_for']) {
        $sql .= " and employee_for=" . $common_array['employee_for'];
    }

    if ($groupby) {
        $sql .= " group by " . $groupby . " order by " . $groupby . " asc";
    }

    return DB::select($sql);
}
function getClassWiseAdmissionFee($class_code, $version_id, $fee_for)
{
    // dd($class_code,$fee_for);
    $session = DB::table('sessions')->where('active', 1)->first();
    return ClassCategoryHeadFee::where('class_category_wise_head_fee.class_code', $class_code)
        ->where('class_category_wise_head_fee.session_id', $session->id)
        ->where('version_id', $version_id)
        ->where('fee_for', $fee_for)
        ->where('is_admission', 1)
        //->where('effective_from','<=','(SELECT max(effective_from) from class_category_wise_head_fee join classes on classes.id=class_category_wise_head_fee.class_id where session_id='.$session->id.' and fee_for='.$fee_for.' and class_code='.$class_code.' and effective_from<='.date("Y-m-d").')')
        ->select('class_category_wise_head_fee.*')
        ->sum('amount');
    //dd($session);
}
function getEmployeeAttandance($groupby, $select, $common_array)
{
    $sql = "with employeeattandane as(
        select distinct employees.id
        ,employees.employee_name
        ,employees.employee_name_bn
        ,employees.email
        ,employees.sms_notification_number
        ,employees.gender
        ,employees.employee_for
        ,employees.blood
        ,at.time
        ,at.attendance_date
        ,at.status
        ,su.subject_name
        ,s.session_name
        ,v.version_name
        ,sh.shift_name
        ,c.class_name
        ,c.class_for
        ,sc.section_name
        ,ca.category_name
        ,employees.category_id
        ,at.session_id
        ,at.version_id
        ,at.shift_id
        ,at.class_id
        ,at.section_id
        ,at.subject_id
        from employees
        left join attendances_teacher at on at.employee_id=employees.id
        left join Category ca on ca.id=employees.category_id
        left join sessions s on s.id=at.session_id
        left join versions v on v.id=at.version_id
        left join shifts sh on sh.id=at.shift_id
        left join classes c on c.id=at.class_id
        left join sections sc on sc.id=at.section_id
        left join subjects su on su.id=at.subject_id
        where employees.active=1
      )
      select " . $select . " from employeeattandane where 1=1 ";
    if ($common_array['session_id']) {
        $sql .= " and session_id=" . $common_array['session_id'];
    }
    if ($common_array['category_id']) {
        $sql .= " and category_id=" . $common_array['category_id'];
    }
    if ($common_array['version_id']) {
        $sql .= " and version_id=" . $common_array['version_id'];
    }
    if ($common_array['shift_id']) {
        $sql .= " and shift_id=" . $common_array['shift_id'];
    }
    if ($common_array['section_id']) {
        $sql .= " and section_id=" . $common_array['section_id'];
    }
    if ($common_array['emp_id']) {
        $sql .= " and emp_id=" . $common_array['emp_id'];
    }
    if ($groupby) {
        $sql .= " group by " . $groupby;
    }

    return DB::select($sql);
}

function getPercentage($total, $getdata)
{
    return round((($getdata * 100) / $total), 2) . '%';
}
function sms_send($numbers, $smsbody)
{
    
    $url = "http://bulksmsbd.net/api/smsapi";
    $api_key = "Jq3ZgLavRja3zxl85kby";
    $senderid = "BAFSD";
    $number = $numbers;
    $message = $smsbody;

    $data = [
        "api_key" => $api_key,
        "senderid" => $senderid,
        "number" => $number,
        "message" => $message
    ];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
}
if (!function_exists('random_float')) {
    function random_float($min, $max, $decimals = 2)
    {
        $scale = pow(10, $decimals);
        return mt_rand($min * $scale, $max * $scale) / $scale;
    }
}


function getRelativePath($url)
{
    $parsedUrl = parse_url($url);
    $relativePath = str_replace('/public/', '', $parsedUrl['path']);
    return $relativePath;
}
