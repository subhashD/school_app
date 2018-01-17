@extends('layouts.masterLayout')

@section('title')
  All Students
@endsection

@section('body-content')


<div class="card bg-white animated slideInRight" id="divTable">
  <div class="card-header bg-primary-lighter text-white">
    <div class="row">
      <div class="pull-right">
          <a href="/export_student" class="btn btn-primary btn-sm "><i class="fa fa-download"></i> Export</a>
          <a href="#importModal" data-toggle="modal" id="addMoreAddress" class="btn btn-primary btn-sm"><i class="fa fa-upload"></i> Import</a>
          <a href="#addStudent" id="add" data-toggle="modal" class="btn btn-primary btn-sm"><i class="fa fa-plus-circle"></i> Add Students </a>
      </div>
    </div>
  </div>
  <div class="card-block">
    <div class="row">
      <form action="/student_filter" method="POST">
          {{ csrf_field() }}

            <div class="col-sm-3">
              <input type="text" name="birth_date" class="form-control" data-provide="datepicker" placeholder="Birth Date">
            </div>

            <div class="col-sm-3">
              <select data-placeholder="Select" name="search_gender" style="width: 100%;" class="form-control">
                  <option selected="" disabled="" value="">--Select Gender--</option>
                  <option value="MALE">MALE</option>
                  <option value="FEMALE">FEMALE</option>
                </select>
            </div>

            <div class="col-sm-2">
              <select data-placeholder="Select" name="search_standard" style="width: 100%;" class="place form-control">
                  <option selected="" disabled="" value="">--Select Standard--</option>
                  @foreach($students as $standard)
                  <option value="{{$standard->standard}}">{{$standard->standard}}</option>
                  @endforeach
                </select>
            </div>

            <div class="col-sm-3">
              <select data-placeholder="Select" name="search_state" class=" form-control" style="width: 100%;">
              <option selected="" disabled="" value="">--Select State--</option>
              @foreach($states as $state)
                <option value="{{$state->state_name}}" name="state_name">{{$state->state_name}}</option>
              @endforeach
            </select>
            </div>

          <div class="visible-xs visible-sm"><br><br></div>
          <div class="col-md-1  col-xs-12">
              <button class="btn btn-primary btn-block">
              <i class="fa fa-search" aria-hidden="true"></i>
              </button>
          </div>
        </form>
      </div>
      <br/>
     <div class="table-responsive" id="table_wrapper">
       <table id="student_table" class="table datatable table-bordered table-condensed table-striped m-b-0">
         <thead class="text-center">
           <tr class="text-center">
             <th>#</th>
             <th>Name</th>
             <th>D.O.B</th>
             <th>Gender</th>
             <th>Standard</th>
             <th>Address</th>
             <th>Admission Date</th>
             <th style="width: 100px;">Action</th>
           </tr>
         </thead>

         <tbody>
           <?php $count=1;?>
           <?php $count=(@$_GET['page']?(intVal(@$_GET['page'])==1?1:intVal(@$_GET['page'])*10-9):1) ?>
             @foreach ($students as $student)
                <tr class="text-center">
                 <td>{{ $count++ }}</td>
                 <td>{{ $student->full_name }}</td>
                 <td>{{ date('d M, Y',strtotime($student->dob)) }}</td>
                 <td>{{ $student->gender }}</td>
                 <td>{{ $student->standard }}</td>
                 <td>{{ $student->address." ".$student->state }}</td>
                 <td>{{ date("d M, Y",strtotime($student->created_at)) }}</td>
                 <td>
                    <div class="row">
                      <div class="col-xs-3">
                        <button data-target="#addStudent" data-toggle="modal" onclick="Edit({{$student->id}})" title="Edit Student" class="btn btn-xs"><i class="fa fa-pencil text-primary"></i></button>
                      </div>
                      <div class="col-xs-1">&nbsp;</div>
                      <div class="col-xs-3">
                        <button class="btn btn-xs deleteStudent" title="Delete Student" id="{{$student->id}}"><i class="fa fa-trash text-danger"></i>
                        </button>
                      </div>
                   </div>
                </td>
               </tr>
             @endforeach
         </tbody>
       </table>
     </div>
    </div>
  </div>
</div>


<div id="addStudent" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="modalTitle">Student Details</h4>
      </div>

      <form action="/saveStudent" method ="POST" id="modalForm">
          {{ csrf_field() }}
          <input type="hidden" name="student_id" id="student_id" value="">
          <div class="modal-body">
            <div class="row">
              <div class="form-group col-sm-2">
                <label for="text"><strong>Full Name:<i class="fa fa-asterisk text-danger"></i></strong></label>
              </div>
              <div class="form-group col-sm-10">
                <input type="text" class="form-control" name="name" id="name" placeholder="Full Name" required="">
              </div>
            </div>

          <div class="row" id="datediv">
            <div class="form-group col-sm-2">
                <label for="text"><strong>D.O.B -:<i class="fa fa-asterisk text-danger"></i></strong></label>
            </div>
            <div class="form-group col-sm-10">
              <input type="text" name="dob" id="dob" class="form-control" data-provide="datepicker" placeholder="mm/dd/yyy">
            </div>
          </div>

          <div class="row">
            <div class="form-group col-sm-2">
                <label for="text"><strong>Gender -:<i class="fa fa-asterisk text-danger"></i></strong></label>
            </div>
            <div class="form-group col-sm-10">
              <div class="cs-radio form-group" style="align-items: center;" >
                <input type="radio" id="g1" name="gender" value="MALE">
                <label for="g1">MALE</label>

                <input type="radio" id="g2" name="gender" checked="" value="FEMALE">
                <label for="g2">FEMALE</label>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="form-group col-sm-2">
                <label for="text"><strong>Standard -:<i class="fa fa-asterisk text-danger"></i></strong></label>
            </div>
            <div class="form-group col-sm-10">
              <input type="number" class="form-control" name="standard" id="standard" placeholder="7" >
            </div>
          </div>

          <div class="row">
            <div class="form-group col-sm-2">
                <label for="text"><strong> Address:<i class="fa fa-asterisk text-danger"></i></strong></label>
            </div>
            <div class="form-group col-sm-10">
              <textarea class="form-control" name="address" id="address" required="" placeholder="Address"></textarea>
            </div>
          </div>

          <div id="aadhar">
            <div class="row">
              <div class="form-group col-sm-2">
                <label for="text"><strong>State -:<i class="fa fa-asterisk text-danger"></i></strong></label>
              </div>
              <div class="form-group col-sm-10">
                <select data-placeholder="Select" id="state" name="state" class="form-control" style="width: 100%;" required="">
                  <option selected="" disabled="" value="">--Select State--</option>
                  @foreach($states as $state)
                    <option value="{{$state->state_name}}">{{$state->state_name}}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>

         </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary btn-icon" id="" >
            <i class="icon-cursor"></i> <span>Submit</span>
          </button>
        </div>
     </form>
    </div>
  </div>
</div>
<!-- Modal end-->


<div id="importModal" class="modal fade" role="dialog">
 <div class="modal-dialog">
<!-- Modal content-->
   <div class="modal-content">
     <div class="modal-header bg-primary">
       <button type="button" class="close" data-dismiss="modal">&times;</button>
       <h4 class="modal-title" id="modalTitle">Import Students</h4>
     </div>

     <form action="/import_student" method ="POST" id="modalForm" enctype="multipart/form-data">
       {{ csrf_field() }}
       <div class="modal-body">
        <div class="row alert">
          Content should be in the format given in below table.<br/>
          The first line of your CSV file should be the column headers as in the table example.
        </div>

        <div style="max-width:540px;overflow-x: scroll;">

          <table class="table table-bordered table-condensed">
            <thead class="text-center">
              <tr class="text-center">
                <th>Name</th>
                <th>DOB</th>
                <th>Gender</th>
                <th>Standard</th>
                <th>Address</th>
                <th>State</th>
              </tr>
            </thead>

            <tbody>
              <tr>
                <td>ABC</td>
                <td>1998-04-16</td>
                <td>male</td>
                <td>3</td>
                <td>Dreams the mall,Bhandup</td>
                <td>MAHARASHTRA</td>
              </tr>
              <tr>
                <td>ABC</td>
                <td>1998-04-16</td>
                <td>male</td>
                <td>3</td>
                <td>Dreams the mall,Bhandup</td>
                <td>MAHARASHTRA</td>
              </tr>
            </tbody>
          </table>

      </div>
        <div class="row">
          <div class="form-group">
            <div class="col-md-2">
                <label for="text"><strong> Select File (.csv):<i class="fa fa-asterisk text-danger"></i></strong></label>
            </div>
            <div class="col-md-10">
              <input type="file" name="import_student" class="form-control" required value="">
            </div>
          </div>
         </div>
        </div>
       <div class="modal-footer">
         <button type="submit" class="btn btn-primary btn-icon" id="" >
           <i class="icon-cursor"></i> <span>Submit</span>
         </button>
       </div>
    </form>

   </div>
 </div>
</div>

@endsection

@section('script-content')

<script>
  let Edit=(id)=>{ 
    $.ajax({
      url:'/editStudent/'+id,
      method:'GET'
    })
    .done(function(response){
      let data = JSON.parse(response);
      $('#student_id').val(data['id']);
      $('#name').val(data['full_name']);
      $('#dob').val(data['dob']);
      $('#standard').val(data['standard']);
      $('#address').val(data['address']);
      if(data['gender']=="MALE")
        $('#g1').attr('checked','checked');
      else 
        $('#g2').attr('checked','checked'); 
      $('#state').val(data['state']);
    })
    .fail(function(){
      swal("Cancelled", "Process can not be completed", "error");
    })
  }

  $(document).on('click','.deleteStudent',function(event) {
    var id=$(this).attr('id');
    swal({
      title: 'Are you sure?',
      text: 'You will not be able to recover this Data',
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#DD6B55',
      confirmButtonText: 'Yes,I want to delete it!',
      closeOnConfirm: false,
    }, function () {
         $.ajax({
            url:"/deleteStudent/"+id,
            method:"GET",
          })
         .done(function(response){
            if(response==1){
              swal('Deleted!', 'Student has been deleted!', 'success');
              $('#student_table').load('/ #student_table');
            }
          })
         .fail(function(){
          swal("Cancelled", "Process Failed", "error");
         });
    });
  });

  $(document).on('click','#add',function(){
    $('#modalForm').trigger('reset');
  })

</script>

@endsection
