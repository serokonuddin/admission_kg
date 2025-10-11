<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\ClassCategoryHeadFee;
use App\Models\Settings\Category;
use Illuminate\Support\Facades\DB;

class CategoryWiseHeadFeeExport implements FromCollection, WithHeadings
{
    protected $head_id;
    protected $session_id;
    protected $version_id;
    protected $class_code;
    protected $category_id;
    protected $month;

    protected $head;
    protected $session;
    protected $version;
    protected $classes;
    protected $category;
    protected $effective_from;
    protected $is_male_female;
    protected $xlname;

    public function __construct($head_id, $head, $effective_from, $session_id, $version_id, $class_code, $category_id, $is_male_female, $session, $version, $classes, $category, $xlname)
    {
        $this->month = date('m', strtotime($effective_from));
        $this->head_id = $head_id;
        $this->head = $head;
        $this->session_id = $session_id;
        $this->version_id = $version_id;
        $this->class_code = $class_code;
        $this->category_id = $category_id;
        $this->is_male_female = $is_male_female;

        $this->session = $session;
        $this->version = $version;
        $this->classes = $classes;
        $this->category = $category;
        $this->effective_from = $effective_from;
        $this->xlname = $xlname;
    }

    public function headings(): array
    {
        if ($this->is_male_female == 0) {
            return [
                'Head ID', 'Session', 'Version', 'Class Code', 'Category', 'Head', 'Amount', 'Effective From'
            ];
        } else {
            return [
                'Head ID', 'Session', 'Version', 'Class Code', 'Category', 'Head', 'Gender', 'Amount', 'Effective From'
            ];
        }
    }

    public function twelvemonth($index)
    {
        $months = [
            "01" => 'January',
            "02" => 'February',
            "03" => 'March',
            "04" => 'April',
            "05" => 'May',
            "06" => 'June',
            "07" => 'July',
            "08" => 'August',
            "09" => 'September',
            "10" => 'October',
            "11" => 'November',
            "12" => 'December'
        ];
        return $months[$index] ?? 'Unknown';
    }

    public function collection()
    {
        if ($this->is_male_female == 0) {
            $categories = DB::table('Category')
                ->where('type', 2)
                ->selectRaw("{$this->head_id} AS id, NULL AS session, NULL AS version, NULL AS class_code, category_name AS category, '{$this->head}' AS head_name, NULL AS amount, NULL AS effective_from")
                ->where('active', 1)
                ->get();
        } else {
            $sql = "
            WITH male AS (
                SELECT {$this->head_id} AS id,
                       NULL AS session,
                       NULL AS version,
                       NULL AS class_code,
                       category_name AS category,
                       '{$this->head}' AS head_name,
                       'Male' AS gender,
                       NULL AS amount,
                       NULL AS effective_from
                FROM Category
                WHERE type = 2 AND active = 1
            ),
            female AS (
                SELECT {$this->head_id} AS id,
                       NULL AS session,
                       NULL AS version,
                       NULL AS class_code,
                       category_name AS category,
                       '{$this->head}' AS head_name,
                       'Female' AS gender,
                       NULL AS amount,
                       NULL AS effective_from
                FROM Category
                WHERE type = 2 AND active = 1
            )
            SELECT * FROM male
            UNION
            SELECT * FROM female";
            $categories = DB::select($sql);
        }

        $query = ClassCategoryHeadFee::selectRaw("head_id AS id, '{$this->session}' AS session, '{$this->version}' AS version, '{$this->classes}' AS class_code, '{$this->category}' AS category, '{$this->head}' AS head_name, amount, '{$this->effective_from}' AS effective_from")
            ->join('fee_head', 'fee_head.id', '=', 'class_category_wise_head_fee.head_id')
            ->where('session_id', $this->session_id)
            ->where('version_id', $this->version_id)
            ->where('class_code', $this->class_code);

        if ($this->is_male_female != 0) {
            $query->addSelect('gender');
        }

        if ($this->category_id) {
            $query->where('category_id', $this->category_id);
        }

        if ($this->head_id) {
            $query->where('head_id', $this->head_id);
        }
        if ($this->effective_from) {
            $query->where('effective_from', $this->effective_from);
        }

        $data = $query->get();

        if ($data->isEmpty()) {
            foreach ($categories as $key => $category) {
                $categories[$key]->session = $this->session;
                $categories[$key]->version = $this->version;
                $categories[$key]->class_code = $this->class_code;
                $categories[$key]->head_name = $this->head;
                $categories[$key]->amount = null;
                $categories[$key]->effective_from = $this->effective_from;
            }
            return collect($categories);
        } else {
            return $data;
        }
    }
}
