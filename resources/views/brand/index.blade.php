@extends('admin.layouts.template')
@section('page_heading')
@section('content')
{!! Html::style('/packages/dropzone/dropzone.css') !!}
<div class="row">
    <div class="col-lg-10">
<div class="form-group"><h1 style="font-size:38px;">ข้อมูลหลัก</h1></div>
<div class="panel panel-default" >
    <div class="panel-heading">
        เมนู
    </div>
    <!-- /.panel-heading -->
    <div class="panel-body" style="margin-right:20px;">
        <div class="form-group"><h4 >โปรดเลือกหน้าที่ต้องการ</h4></div>
        <select id="master" name="master" class="form-control info">
            <option value="b" href="{{ url ('de') }}">หน่วยงานที่เกี่ยวข้อง</option>
            <option value="a" href="{{ url ('brand') }}"  selected=\"selected\">ยี่ห้อ</option>
            <option value="d" href="{{ url ('coll') }}">ประเภทการเก็บข้อมูล</option>
            <option value="r" href="{{ url ('lang') }}">ภาษาที่ใช้พัฒนา</option>
            <option value="q" href="{{ url ('place') }}">สถานที่ตั้ง</option>
            <option value="w" href="{{ url ('proc') }}">ประเภทกระบวนการ</option>
            <option value="g" href="{{ url ('ud') }}">ฐานข้อมูลที่ใช้</option>
            <option value="" href="{{ url ('InApp') }}" >ตัวย่อระบบสารสนเทศ</option>
            <option value="" href="{{ url ('InDat') }}">ตัวย่อข้อมูล</option>
        </select>
    </div></div>
    </div>
    <!-- /.panel-body -->
</div>
<class="container">
  			<div class="form-group"><h1 style="font-size:38px;">ยี่ห้อ</h1></div>

    <div class="row">
        <div class="col-lg-5">
            <div class="panel panel-default" >
                <div class="panel-heading">
                    <button id="import" class="btn btn-default">นำเข้าข้อมูล</button>
                </div>
                <div class="panel-body1" style="margin-right:20px;">
    <form action="brandImport" method = "post" enctype="multipart/form-data"  >
                <input type="hidden" name="_token" value="{{csrf_token()}}" >
        <p class="file">
            <input type="file" name="file" id="file" />
            <label for="file">Upload your excel</label>
        </p>
        <!--<input type="input" id="uploadFile" disabled="disabled" class="a"/>-->
        <div class="file">
            <input type="submit" value="Import" >
            <label for="submit">submit</label>
        </div>
            </form>
            </div></div></div>

    <div class="col-lg-5">
        <div class="panel panel-default" >
            <div class="panel-heading">
                <button id="download" class="btn btn-default ">Download Template</button>
            </div>
            <div class="panel-body2" style="margin-right:20px;"><br><br>

               <a href="{{url('download')}}" class="btn btn-primary">Download</a>
                <br><br><br>
            </div>
        </div>
    </div>
</div>
    @if(Session::has('message'))
<div class="alert alert-success">{{ Session::get('message') }}</div>
@endif
<p>
</p><br>
<div class="bs-example" data-example-id="bordered-table">
    <div class="row">
        <div class="col-lg-10">
<div class="panel panel-default" >
    <div class="panel-heading">
       <div class="col-lg-2"> ตารางยี่ห้อ</div><div class="col-lg-9"></div>{{ link_to_route('brand.create','เพิ่มยี่ห้อ',null,['class'=>'btn btn-success']) }}
    </div>
    <!-- /.panel-heading -->
    <div class="panel-body" style="margin-right:20px;">
        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
          <thead>
            <tr>
                <th>ชื่อ</th>
                <th>จัดการ</th>

            </tr>
              </thead>
              <tbody>
                @foreach($brand1 as $brand)
                <tr>
                     <td>{{ $brand->name}}  </td>
                         <td>
                           {!! Form::open(array('route'=>['brand.destroy',$brand->id],'method'=>'DELETE')) !!}
                        {{ link_to_route('brand.edit','แก้ไข',[$brand->id],['class'=>'btn btn-primary','id'=>'a']) }}
                           {!! Form::button('ลบ',['class'=>'btn btn-danger del','type'=>'submit']) !!}
                           {!! Form::close() !!}
                         </td>
                 </tr>
                @endforeach
              </tbody>
        </table>
    </div>
</div>
    </div>
    <!-- /.panel-body -->
</div>
<!-- /.panel -->

</div>
    <script src="{{asset('/assets/bower_components/jquery/dist/jquery.min.js')}}"></script>
    <script>
        $(document).ready(function() {
            document.getElementById('master').onchange = function() {
                window.location.href = this.children[this.selectedIndex].getAttribute('href');
                // alert('4');
            };
            document.getElementById("file").onchange = function () {
                document.getElementById("uploadFile").value = this.value;
            };
        });

    </script>
@stop
