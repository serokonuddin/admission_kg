namespace App\Exports;

use App\Models\Student\Student;
use Maatwebsite\Excel\Concerns\FromCollection;

class AdmissionExport implements FromCollection
{
    protected $class_id;
    protected $section_id;

    public function __construct($class_id, $section_id)
    {
        $this->class_id = $class_id;
        $this->section_id = $section_id;
    }
    public function collection()
    {
        dd($this->class_id);
        return Student::join('student_activity','student_activity.student_code','=','students.student_code')
                ->where('class_id',$this->class_id)
                ->where('section_id',$this->section_id)
                ->get();
    }
}