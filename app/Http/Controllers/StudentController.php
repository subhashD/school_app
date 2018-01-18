<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\UserRegistered;
use App\Student;
use App\State;
use Session;
use Excel;
use Auth;
use Mail;

class StudentController extends Controller
{
	public function saveStudent(Request $request)
	{
		$this->validate($request,array(
		 'name'=>'required|regex:/^[\pL\s]+$/u|min:3',
         'dob'=>'nullable',
         'gender'=>'required',
         'standard'=>'required',
         'address'=>'min:3',
		));

		if($request->student_id=="")
		{
			Student::create([
				'full_name'=>$request->name,
		        'dob'=>date('Y-m-d',strtotime($request->dob)),
		        'gender'=>$request->gender,
		        'standard'=>$request->standard,
		        'address'=>$request->address,
		        'state'=>$request->state,
			]);
			Session::flash('success','Student Added Successfully');
		}
		else
		{
			Student::where('id',$request->student_id)->update([
				'full_name'=>$request->name,
		        'dob'=>date('Y-m-d',strtotime($request->dob)),
		        'gender'=>$request->gender,
		        'standard'=>$request->standard,
		        'address'=>$request->address,
		        'state'=>$request->state,
			]);
			Session::flash('success','Student updated Successfully');
		}
		return back();
	}
    
    public function editStudent($id)
    {
    	$student  = Student::find($id);
    	return json_encode($student);
    }

    public function deleteStudent($id)
    {
    	$student  = Student::find($id);
    	$s = $student->delete();
    	if($s)
    		return 1;
    	return 0;
    }

    public function studentFilter(Request $request)
    {
      $states=State::all();
      $students = Student::when($request->search_gender,function($query) use ($request){
		if($request->search_gender != "")
          $query->where('gender',$request->search_gender);
        })
		->when($request->search_state,function($query) use ($request){
		if($request->search_state != "")
          $query->where('state',$request->search_state);
        })
        ->when($request->search_standard,function($query) use ($request){
          $query->where('standard',$request->search_standard);
        })
        ->when($request->birth_date,function($query) use ($request){
          $query->whereDate('dob','=',date('Y-m-d',strtotime($request->birth_date)));
        })->get();
        
      return view('admin.students',compact('students','states'));
    }

     public function importStudent(Request $request)
     {
       if($request->file('import_student'))
      {
	    $path = $request->file('import_student')->getRealPath();
	    $data = Excel::load($path, function($reader)
  		{})->get();
          // return $data;
          if(!empty($data) && $data->count())
          {
            foreach ($data->toArray() as $row)
            {
              if(!empty($row))
              {
                $dataArray[] =
                [
		            'full_name'=>$row['name'],
			        'dob'=>date('Y-m-d',strtotime($row['dob'])),
			        'gender'=>$row['gender'],
			        'standard'=>$row['standard'],
			        'address'=>$row['address'],
			        'state'=>$row['state'],
                ];
              }
            }
          if(!empty($dataArray))
          {
             Student::insert($dataArray);
             return back();
           }
         }
       }
       Session::flash('error','Import Failed');
       return back();
     }

    public function exportStudent()
    {
      $students = Student::select('full_name','dob','standard','gender','address','state')->get();

      $studentArray = [];
      $studentArray[] = ['name','dob','standard','gender','address',
        'state'];
      foreach ($students as $student) {
          $studentArray[] = $student->toArray();
      }
      // Generate and return the spreadsheet
      Excel::create('Students', function($excel) use ($studentArray) {
          $excel->setTitle('Students');
          $excel->setCreator('Subhash')->setCompany('Maatwebsite');
          $excel->setDescription('Students list');
          // Build the spreadsheet, passing in the payments array
          $excel->sheet('Students', function($sheet) use ($studentArray) {
              $sheet->fromArray($studentArray, null, 'A1', false, false);
          });	
      })->download('xlsx');

    }
}
