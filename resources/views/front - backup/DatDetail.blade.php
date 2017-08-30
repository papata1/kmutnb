<!DOCTYPE html>
<!-- Template Name: Clip-One - Responsive Admin Template build with Twitter Bootstrap 3.x Version: 1.4 Author: ClipTheme -->
<!--[if IE 8]><html class="ie8 no-js" lang="en"><![endif]-->
<!--[if IE 9]><html class="ie9 no-js" lang="en"><![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->
<!-- start: HEAD -->
<head>
	<title>EA DOCUMENT REPOSITORY</title>
	<!-- start: META -->
	<meta charset="utf-8" />
	<!--[if IE]><meta http-equiv='X-UA-Compatible' content="IE=edge,IE=9,IE=8,chrome=1" /><![endif]-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta content="" name="description" />
	<meta content="" name="author" />
	<!-- end: META -->
	<!-- start: MAIN CSS -->
	<link rel="stylesheet" href="{{ URL::asset('css/theme/plugins/bootstrap/css/bootstrap.min.css') }}" >
	<link rel="stylesheet" href="{{ URL::asset('css/theme/plugins/font-awesome/css/font-awesome.min.css') }}" >
	<link rel="stylesheet" href="{{ URL::asset('css/theme/fonts/style.css') }}" >
	<link rel="stylesheet" href="{{ URL::asset('css/theme/css/main.css') }}" >
	<link rel="stylesheet" href="{{ URL::asset('css/theme/css/main-responsive.css') }}" >
	<link rel="stylesheet" href="{{ URL::asset('css/theme/plugins/iCheck/skins/all.css') }}" >
	<link rel="stylesheet" href="{{ URL::asset('css/theme/plugins/bootstrap-colorpalette/css/bootstrap-colorpalette.css') }}" >
	<link rel="stylesheet" href="{{ URL::asset('css/theme/plugins/perfect-scrollbar/src/perfect-scrollbar.css') }}" >
	<link rel="stylesheet" href="{{ URL::asset('css/theme/css/theme_light.css') }}" >
	<link rel="stylesheet" href="{{ URL::asset('css/theme/css/print.css') }}" >
		<!--[if IE 7]>
		<link rel="stylesheet" href="assets/plugins/font-awesome/css/font-awesome-ie7.min.css">
		<![endif]-->
		<!-- end: MAIN CSS -->
		<!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->
		<!-- end: CSS REQUIRED FOR THIS PAGE ONLY -->
	</head>
	<!-- end: HEAD -->
	<!-- start: BODY -->
	<body>
		<div class="page-container container">
			<div class="form-group">
				<center>{!! Html::image('images\banner.jpg') !!}</center>
			</div>
			<div style="text-align:center">
@include('front.topnav')
				</div> 
				<!-- start: MAIN CONTAINER -->
				<div class="main-container">
					<div class="navbar-content">
@include('front.leftnav')
					</div>
					<!-- start: PAGE -->
					<div class="main-content">
						<!-- /.modal -->
						<!-- end: SPANEL CONFIGURATION MODAL FORM -->
						<div class="container">

							<!-- start: PAGE CONTENT -->
							<div class="row">
								<div class="col-md-12">
									<!-- start: RESPONSIVE TABLE PANEL -->
									<div class="panel panel-default">
<?php $typee=""; ?>
														@foreach($model as $modell)
<?php switch ($modell->type) {
	case '1':
		$typee = 'ข้อมูลฐานข้อมูลกลาง';
		break;
	case '2':
		$typee = 'ข้อมูลฐานข้อมูลอื่น';
		break;
	case '3':
		$typee = 'ข้อมูลอิเล็กทรอนิกส์ไฟล์';
		break;
	case '4':
		$typee = 'ข้อมูลเอกสาร';
		break;

}?>
										<div class="panel-heading">
											{{ $modell->name }}
										</div>
										<div class="panel-body">
											<div class="table-responsive">
												<!-- Start: table content -->
				<table class="table table-bordered table-hover" id="sample-table-1">
					<tr><td width="200">รหัส</td><td>{{ $modell->id }}</td></tr>
					<tr><td width="200">ชื่อ</td><td>{{ $modell->name }}</td></tr>
					<tr><td width="200">ประเภท</td><td><?php echo$typee; ?></td></tr>
					<tr><td width="200">ข้อเสนอแนะ</td><td>{{ $modell->remark }}</td></tr>
					<tr><td colspan="2">

					<a class="button btn btn-success" 

						<?php if($modell->data!=NULL){
							echo 'onclick="dload()"';
						}?>

						<?php if($modell->data==NULL){
							echo 'onclick="nothing()"';
						}?>
						>ER-Dictionary</a>

					<a class="button btn btn-success" 

						<?php if($modell->data_dic!=NULL){
							echo 'onclick="d2load()"';
						}?>

						<?php if($modell->data_dic==NULL){
							echo 'onclick="nothing()"';
						}?>
						>Data Dictionary</a>
						</td></tr>

					@endforeach
				</table>
<script>
function nothing() {
    alert("ไม่พบข้อมูล");
}
</script>
<script>
function dload() {
    window.location="{{ asset('/downloaddat/'.$modell->data) }}";
}
</script>
<script>
function d2load() {
    window.location="{{ asset('/downloaddat/'.$modell->data_dic) }}";
}
</script>
												<!-- End: table content -->
											</div>
										</div>
									</div>
									<!-- end: RESPONSIVE TABLE PANEL -->
								</div>
							</div>
							<!-- end: PAGE CONTENT-->
						</div>
					</div>
					<!-- end: PAGE -->
				</div>
				<!-- end: MAIN CONTAINER -->
			</div>
			<!-- start: MAIN JAVASCRIPTS -->
			<script src="{{ URL::asset('css/theme/plugins/jQuery-lib/2.0.3/jquery.min.js') }}"></script>
			<!--<![endif]-->
			<script src="{{ URL::asset('css/theme/plugins/jquery-ui/jquery-ui-1.10.2.custom.min.js') }}"></script>
			<script src="{{ URL::asset('css/theme/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
			<script src="{{ URL::asset('css/theme/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js') }}"></script>
			<script src="{{ URL::asset('css/theme/plugins/blockUI/jquery.blockUI.js') }}"></script>
			<script src="{{ URL::asset('css/theme/plugins/iCheck/jquery.icheck.min.js') }}"></script>
			<script src="{{ URL::asset('css/theme/plugins/perfect-scrollbar/src/jquery.mousewheel.js') }}"></script>
			<script src="{{ URL::asset('css/theme/plugins/perfect-scrollbar/src/perfect-scrollbar.js') }}"></script>
			<script src="{{ URL::asset('css/theme/plugins/less/less-1.5.0.min.js') }}"></script>
			<script src="{{ URL::asset('css/theme/plugins/jquery-cookie/jquery.cookie.js') }}"></script>
			<script src="{{ URL::asset('css/theme/plugins/bootstrap-colorpalette/js/bootstrap-colorpalette.js') }}"></script>
			<script src="{{ URL::asset('css/theme/js/main.js') }}"></script>

			<!-- end: MAIN JAVASCRIPTS -->
			<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
			<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
			<script>
				jQuery(document).ready(function() {
					Main.init();
				});
			</script>
		</body>
		<!-- end: BODY -->
		</html>
