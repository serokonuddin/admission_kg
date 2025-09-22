<?php
$bang_month = array(
    '01'=>'জানুয়ারি', 
    '02'=>'ফেব্রুয়ারী', 
    '03'=>'মার্চ', 
    '04'=>'এপ্রিল', 
    '05'=>'মে',
    '06'=>'জুন', 
    '07'=>'জুলাই', 
    '08'=>'আগষ্ট', 
    '09'=>'সেপ্টেম্বর', 
    '10'=>'অক্টোবর',
    '11'=>'নভেম্বর',
    '12'=>'ডিসেম্বর');
$eng_month = array(
    '01'=>'January', 
    '02'=>'February', 
    '03'=>'March', 
    '04'=>'April', 
    '05'=>'May',
    '06'=>'June', 
    '07'=>'July', 
    '08'=>'August', 
    '09'=>'September', 
    '10'=>'October',
    '11'=>'November',
    '12'=>'December');
class numberformatClass{
    public function __construct($cc)
    {
        $this->cc=$cc;
    }
    public function numdash($n,$bracket=0,$d='--'){
       $v=$n?(Session::get('lan')=='en'?$n:$this->cc->en2bnNumber($n)):$d;
       return $bracket?"($v)":$v;
    }

}

?>



<!doctype html>
<html >
    <head>
        
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>BAF Shanheen College Dhaka</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
         <link rel="stylesheet" href="<?php echo e(asset('css/backend_css/bootstrap.min.css')); ?>" />
                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
   <style type="text/css">
    a {text-decoration: none}

    body {
       
        /*font-size: 14px !important;*/
     }
     tr.sectorvaluefonts td span{
        
       
    }

    @page {
      header: page-header;
      footer: page-footer;
      sheet-size: A4;
      margin:2.54cm 2.54cm 1.54cm 2.54cm;
     
    }
    table {
        
        border: none;
        border-collapse: collapse; 
        width: 100%;
        font-size: 13px;
    }

    th, td {
        padding: 1px !important;
        border: 1px solid #000;
        vertical-align: top;
    }

    th {
        text-align: center;
    }
    .fake{
        border: 0px;
        width: 0px!important;
        visibility: hidden;
        padding: 0px!important;
        font-size: 0px;
    }

    .no-subsector{
        border: 0px;
        visibility: hidden;
        padding: 0px!important;
        font-size: 0px!important;
        background-color: yellow;
    }

    div.fake{ display: none!important; ;  font-size: 0px!important; }


    .noboder{
        border: 0px;
        padding: 5px;
        font-weight: bold;
        font-size: 15px;
        
    }
    .sectorhide0{
        border: 0px;
        width: 0px!important;
        visibility: hidden;
        padding: 0px!important;
    }
    
    tr td{
      
    }
    .tdcenter{
        text-align: center!important;
    }
    .tdright{
        text-align: right!important;
    }
    .bordernone{
        border: none!important;
        height: 10px!important;
    }

    </style>
         <style>
             .table th, .table td {
                text-align: center!important;
                vertical-align: top!important;
                border-top: 1px solid #000!important;
                border-left: 1px solid #000!important;
            }
           .table td:last-child, .table th:last-child { border-right: 1px solid #000!important; }
           .table tr:last-child { border-bottom: 1px solid #000!important; }
            #projecttitle{
                text-align: left!important;
                padding-left: 5px!important;
            }
            .x-footer{
                width: 100%;
                border: 0 none!important;
                border-collapse: collapse;
            }
            .x-footer td{
                border: 0 none!important;
            }
            .nowrap{
                white-space: nowrap;
            }
            .head span{
                display: inline;
            }
            h3{
                font-size: 18px;
                font-weight: bold;
            }
    </style>

    </head>
    <?php
                    $totalban = 0;
                    $totaltotal = 0;
                    $totaleng = 0;
                    $totalict = 0;
                    $totalagr = 0;
                    $totalsta = 0;
                    $groupData = collect($groupData)->groupBy(['group_id', 'version_id']);
                    $groupsubject = [
                        1 => ['BAN', 'ENG', 'ICT', 'PHY', 'CHE', 'BIO', 'HMM', 'PSY', 'AGR', 'STA', '(EDS)'],
                        2 => ['BAN', 'ENG', 'ICT', 'ECO', 'LOG', 'GEO', '(IHC)', 'SOW', '(CGG)', 'PSY', 'AGR', 'STA'],
                        3 => ['BAN', 'ENG', 'ICT', 'ACC', '(BOM)', '(PMM)', '(FBI)', 'AGR', 'STA'],
                    ];
                    $grouprowspan = [];
                    $versionrowspan = [];
                    foreach ($groupData as $key => $data) {
                        $grouprowspan[$key] = 0;
                        foreach ($data as $key1 => $value) {
                            $grouprowspan[$key] += $value ? count($value) : 0;
                            $versionrowspan[$key][$key1] = $value ? count($value) : 0;
                        }
                    }
                    $version = ['1' => 'Bangla', '2' => 'English'];
                    $group = ['1' => 'Science', 2 => 'Humanities', 3 => 'Business studies'];
                ?>
    <body>
        <div class="flex-center position-ref full-height">
        <table  >
                <thead>
                    <tr>
                        <th class="tdcenter bordernone" colspan="2"><img src="<?php echo e(asset('public/logo/logo.png')); ?>" style="width: auto;height: 80px;"></th>
                        <th class="tdcenter bordernone" colspan="3">
                        <h2 style="color: rgb(0,173,239)">BAF Shaheen College Dhaka</h2>
                            <span>Dhaka Cantonmnet, Dhaka-1206</span>
                            <br/><span>Web: www.bafsd.edu.bd</span><br/>
                            <span>Email: info@bafsd.edu.bd</span>
                            <h3>Section Wise Students' List</h3>
                        </th>
                        <th colspan="2" class="bordernone">

                        </th>
                        
                    </tr>
				</thead>
			</table>
			
			<?php $__currentLoopData = $groupData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php

                            $i = 0;
                            $total = 0;
                            $total1 = 0;
                            $total2 = 0;
                            $total3 = 0;
                            $total4 = 0;
                            $total5 = 0;
                            $total6 = 0;
                            $total7 = 0;
                            $total8 = 0;
                            $total9 = 0;
                            $total10 = 0;
                            $total11 = 0;
                            $total12 = 0;
                            foreach ($groupsubject[$key] as $key2 => $subject) {
                                $total . ($subject = 0);
                            }

                        ?>
                        <table style="margin-top: 10px">


                            <tr>
                                <th style="width: 100px!important">Group</th>
                                <th style="width: 60px!important">Version</th>
                                <th style="width: 80px!important">Section</th>
                                <th style="width: 60px!important">Total Student</th>
                                <?php $__currentLoopData = $groupsubject[$key]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <th style="vertical-align: center"><?php echo e($s); ?></th>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tr>

                            <?php $__currentLoopData = $value; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key1 => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
							$j = 0;

                              
							?> 
							
                                <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key0 => $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <?php if($i == 0): ?>
                                            <td rowspan="<?php echo e($grouprowspan[$key]); ?>"><?php echo e($group[$key]); ?></td>
                                        <?php endif; ?>
                                        <?php if($j == 0): ?>
                                            <td rowspan="<?php echo e($versionrowspan[$key][$key1]); ?>"><?php echo e($version[$key1]); ?></td>
                                        <?php endif; ?>
                                        <td><?php echo e($section->section_name); ?></td>
                                        <td>
                                            <?php
                                                $totaltotal += (int) $section->total_student ?? 0;
                                                $total += (int) $section->total_student ?? 0;
                                            ?>
                                            <?php echo e($section->total_student); ?>


                                        </td>
                                        <?php $__currentLoopData = $groupsubject[$key]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key2 => $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php

                                                if ($subject == 'BAN') {
                                                    $totalban += $section->subject[$subject][0]->subject_number ?? 0;
                                                } elseif ($subject == 'ENG') {
                                                    $totaleng += $section->subject[$subject][0]->subject_number ?? 0;
                                                } elseif ($subject == 'ICT') {
                                                    $totalict += $section->subject[$subject][0]->subject_number ?? 0;
                                                } elseif ($subject == 'AGR') {
                                                    $totalagr += $section->subject[$subject][0]->subject_number ?? 0;
                                                } elseif ($subject == 'STA') {
                                                    $totalsta += $section->subject[$subject][0]->subject_number ?? 0;
                                                }

                                                if ($key2 == 0) {
                                                    $total1 += $section->subject[$subject][0]->subject_number ?? 0;
                                                } elseif ($key2 == 1) {
                                                    $total2 += $section->subject[$subject][0]->subject_number ?? 0;
                                                } elseif ($key2 == 2) {
                                                    $total3 += $section->subject[$subject][0]->subject_number ?? 0;
                                                } elseif ($key2 == 3) {
                                                    $total4 += $section->subject[$subject][0]->subject_number ?? 0;
                                                } elseif ($key2 == 4) {
                                                    $total5 += $section->subject[$subject][0]->subject_number ?? 0;
                                                } elseif ($key2 == 5) {
                                                    $total6 += $section->subject[$subject][0]->subject_number ?? 0;
                                                } elseif ($key2 == 6) {
                                                    $total7 += $section->subject[$subject][0]->subject_number ?? 0;
                                                } elseif ($key2 == 7) {
                                                    $total8 += $section->subject[$subject][0]->subject_number ?? 0;
                                                } elseif ($key2 == 8) {
                                                    $total9 += $section->subject[$subject][0]->subject_number ?? 0;
                                                } elseif ($key2 == 9) {
                                                    $total10 += $section->subject[$subject][0]->subject_number ?? 0;
                                                } elseif ($key2 == 10) {
                                                    $total11 += $section->subject[$subject][0]->subject_number ?? 0;
                                                } elseif ($key2 == 11) {
                                                    $total12 += $section->subject[$subject][0]->subject_number ?? 0;
                                                }
                                            ?>
                                            <td><a href="<?php echo e(url('admin/getTotalStudentBySectionSubject/' . $section->id . '/' . $subject)); ?>"
                                                    target="_blank"><?php echo e($section->subject[$subject][0]->subject_number ?? 0); ?></a>
                                            </td>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tr>
                                    <?php $j++; ?>
                                    <?php $i++; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td colspan="3" style="text-align: right;font-weight: bold">Total</td>
                                <td><?php echo e($total); ?></td>
                                <?php if($key == 1): ?>
                                    <td><a href="<?php echo e(url('admin/getTotalStudentBySubjectGroup/BAN/' . $key)); ?>"
                                            target="_blank"><?php echo e($total1); ?></a></td>
                                    <td><a href="<?php echo e(url('admin/getTotalStudentBySubjectGroup/ENG/' . $key)); ?>"
                                            target="_blank"><?php echo e($total2); ?></a></td>
                                    <td><a href="<?php echo e(url('admin/getTotalStudentBySubjectGroup/ICT/' . $key)); ?>"
                                            target="_blank"><?php echo e($total3); ?></a></td>
                                    <td><a href="<?php echo e(url('admin/getTotalStudentBySubjectGroup/PHY/' . $key)); ?>"
                                            target="_blank"><?php echo e($total4); ?></a></td>
                                    <td><a href="<?php echo e(url('admin/getTotalStudentBySubjectGroup/CHE/' . $key)); ?>"
                                            target="_blank"><?php echo e($total5); ?></a></td>
                                    <td><a href="<?php echo e(url('admin/getTotalStudentBySubjectGroup/BIO/' . $key)); ?>"
                                            target="_blank"><?php echo e($total6); ?></a></td>
                                    <td><a href="<?php echo e(url('admin/getTotalStudentBySubjectGroup/HMM/' . $key)); ?>"
                                            target="_blank"><?php echo e($total7); ?></a></td>
                                    <td><a href="<?php echo e(url('admin/getTotalStudentBySubjectGroup/PSY/' . $key)); ?>"
                                            target="_blank"><?php echo e($total8); ?></a></td>
                                    <td><a href="<?php echo e(url('admin/getTotalStudentBySubjectGroup/AGR/' . $key)); ?>"
                                            target="_blank"><?php echo e($total9); ?></a></td>
                                    <td><a href="<?php echo e(url('admin/getTotalStudentBySubjectGroup/STA/' . $key)); ?>"
                                            target="_blank"><?php echo e($total10); ?></a></td>
                                    <td><a href="<?php echo e(url('admin/getTotalStudentBySubjectGroup/(EDS)/' . $key)); ?>"
                                            target="_blank"><?php echo e($total11); ?></a></td>
                                <?php elseif($key == 2): ?>
                                    <td><a href="<?php echo e(url('admin/getTotalStudentBySubjectGroup/BAN/' . $key)); ?>"
                                            target="_blank"><?php echo e($total1); ?></a></td>
                                    <td><a href="<?php echo e(url('admin/getTotalStudentBySubjectGroup/ENG/' . $key)); ?>"
                                            target="_blank"><?php echo e($total2); ?></a></td>
                                    <td><a href="<?php echo e(url('admin/getTotalStudentBySubjectGroup/ICT/' . $key)); ?>"
                                            target="_blank"><?php echo e($total3); ?></a></td>
                                    <td><a href="<?php echo e(url('admin/getTotalStudentBySubjectGroup/ECO/' . $key)); ?>"
                                            target="_blank"><?php echo e($total4); ?></a></td>
                                    <td><a href="<?php echo e(url('admin/getTotalStudentBySubjectGroup/LOG/' . $key)); ?>"
                                            target="_blank"><?php echo e($total5); ?></a></td>
                                    <td><a href="<?php echo e(url('admin/getTotalStudentBySubjectGroup/GEO/' . $key)); ?>"
                                            target="_blank"><?php echo e($total6); ?></a></td>
                                    <td><a href="<?php echo e(url('admin/getTotalStudentBySubjectGroup/(IHC)/' . $key)); ?>"
                                            target="_blank"><?php echo e($total7); ?></a></td>
                                    <td><a href="<?php echo e(url('admin/getTotalStudentBySubjectGroup/SOW/' . $key)); ?>"
                                            target="_blank"><?php echo e($total8); ?></a></td>
                                    <td><a href="<?php echo e(url('admin/getTotalStudentBySubjectGroup/(CGG)/' . $key)); ?>"
                                            target="_blank"><?php echo e($total9); ?></a></td>
                                    <td><a href="<?php echo e(url('admin/getTotalStudentBySubjectGroup/PSY/' . $key)); ?>"
                                            target="_blank"><?php echo e($total10); ?></a></td>
                                    <td><a href="<?php echo e(url('admin/getTotalStudentBySubjectGroup/AGR/' . $key)); ?>"
                                            target="_blank"><?php echo e($total11); ?></a></td>
                                    <td><a href="<?php echo e(url('admin/getTotalStudentBySubjectGroup/STA/' . $key)); ?>"
                                            target="_blank"><?php echo e($total12); ?></a></td>
                                <?php else: ?>
                                    <td><a href="<?php echo e(url('admin/getTotalStudentBySubjectGroup/BAN/' . $key)); ?>"
                                            target="_blank"><?php echo e($total1); ?></a></td>
                                    <td><a href="<?php echo e(url('admin/getTotalStudentBySubjectGroup/ENG/' . $key)); ?>"
                                            target="_blank"><?php echo e($total2); ?></a></td>
                                    <td><a href="<?php echo e(url('admin/getTotalStudentBySubjectGroup/ICT/' . $key)); ?>"
                                            target="_blank"><?php echo e($total3); ?></a></td>
                                    <td><a href="<?php echo e(url('admin/getTotalStudentBySubjectGroup/ACC/' . $key)); ?>"
                                            target="_blank"><?php echo e($total4); ?></a></td>
                                    <td><a href="<?php echo e(url('admin/getTotalStudentBySubjectGroup/(BOM)/' . $key)); ?>"
                                            target="_blank"><?php echo e($total5); ?></a></td>
                                    <td><a href="<?php echo e(url('admin/getTotalStudentBySubjectGroup/(PMM)/' . $key)); ?>"
                                            target="_blank"><?php echo e($total6); ?></a></td>
                                    <td><a href="<?php echo e(url('admin/getTotalStudentBySubjectGroup/(FBI)/' . $key)); ?>"
                                            target="_blank"><?php echo e($total7); ?></a></td>
                                    <td><a href="<?php echo e(url('admin/getTotalStudentBySubjectGroup/AGR/' . $key)); ?>"
                                            target="_blank"><?php echo e($total8); ?></a></td>
                                    <td><a href="<?php echo e(url('admin/getTotalStudentBySubjectGroup/STA/' . $key)); ?>"
                                            target="_blank"><?php echo e($total9); ?></a></td>
                                <?php endif; ?>
                            </tr>

                        </table>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <?php if(count($groupData) > 0): ?>
                        <table style="margin-top: 10px">
                            <tr>
                                <td>Total Student</td>
                                <td>Total Student: <?php echo e($totaltotal); ?></td>
                                <td><a href="<?php echo e(url('admin/getTotalStudentBySubject/BAN')); ?>" target="_blank">BAN:
                                        <?php echo e($totalban); ?></a></td>
                                <td><a href="<?php echo e(url('admin/getTotalStudentBySubject/ENG')); ?>" target="_blank">ENG:
                                        <?php echo e($totaleng); ?></a></td>
                                <td><a href="<?php echo e(url('admin/getTotalStudentBySubject/ICT')); ?>" target="_blank">ICT:
                                        <?php echo e($totalict); ?></a></td>
                                <td><a href="<?php echo e(url('admin/getTotalStudentBySubject/AGR')); ?>" target="_blank">AGR:
                                        <?php echo e($totalagr); ?></a></td>
                                <td><a href="<?php echo e(url('admin/getTotalStudentBySubject/STA')); ?>" target="_blank">STA:
                                        <?php echo e($totalsta); ?></a></td>
                            </tr>
                        </table>
        			<?php endif; ?>
            
            <style type="text/css">
                .cc,.cc td{
                    border: 0px solid #fff!important;
                    padding: 1px!important;
                    font-size: 16px!important;
                }
                .cc tr td:nth-child(3n+3) {
                    display: none!important;
                    width: 0px!important;
                    border: 0px solid #fff!important;
                    padding: 0px;
                }
                .cc-serial{
                    width: 10px!important;
                    padding: 2px!important;
                    text-align: right!important;
                    border: 0px solid #fff!important;
                }
            </style>
            
            
            
        </div>
        <htmlpagefooter name="page-footer">
          <table class="x-footer">
              
              <tr>
                  <td style="width: 50%;text-align: left;"><?php echo e(date('d-m-Y H:s')); ?></td>
                  <td style="text-align: right;"><?php echo app('translator')->get('Page'); ?> ({PAGENO}/{nb})</td>
              </tr>

          </table>

        
        </htmlpagefooter>
    </body>
</html>
<?php /**PATH /var/www/vhosts/bafsdadmission.com/httpdocs/resources/views/print/subject_wise_student.blade.php ENDPATH**/ ?>