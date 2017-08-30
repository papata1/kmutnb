<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\busRequest;
use App\Http\Requests\appRequest;
use App\Http\Requests\datRequest;
use App\Http\Requests\tecRequest;
use App\Business_layer;
use App\Application_layer;
use App\Data_layer;
use App\Technology_layer;
use App\business_relation;
use App\application_relation;
use App\data_relation;
use App\technology_relation;
use App\department;
use App\develop_language;
use App\devlopment_group;
use App\type_collection;
use App\brand;
use App\place_relation;
use App\place;
use App\use_data;
use Illuminate\Support\Facades\DB;
use Excel;

     
class frontendController extends Controller{
  public function viewBus(){
   $model = DB::select("
    SELECT
    bl.* , 
    bl.id AS blid ,
    bl.ids AS blids , 
    bl.name AS blname ,  
    bl.type AS bltype ,
    bl.department_id AS dpid , 
    typee.remark AS pfix ,
    typee.name AS typee
    FROM 
    business_layer AS bl , 
    type_process AS typee
    WHERE
    typee.id = bl.type
    ORDER BY
    bl.id
    ");
   $model2 = DB::select("
    SELECT
    bl.* , 
    al.* ,
    br.* , 
    bl.id AS blid ,   
    al.name AS alname ,
    br.business_layer_id AS compblid
    FROM 
    business_layer AS bl ,  
    application_layer AS al ,
    business_relation AS br
    WHERE
    al.id = br.comp_id AND
    bl.id = br.business_layer_id AND
    br.frag = 'a'
    ");
   $model3 = DB::select("
    SELECT 
    dp.name AS dpname , 
    dp.id AS dpid , 
    dr.id_bus AS drbusid , 
    dr.department_id AS drdpid
    FROM
    department AS dp , 
    bus_depart AS dr
    WHERE
    dp.id = dr.department_id
    ");
   if($model==NULL){
    return view('front.Nothing');
  }else{
    return view('front.Bus')->with(['model'=>$model,'model2'=>$model2,'model3'=>$model3]);
  }
}
public function viewBusdetail($id){
  $model = DB::select("
    SELECT
    bl.* , 
    bl.id AS blid ,
    bl.ids AS blids ,  
    bl.name AS blname ,  
    bl.type AS bltype ,
    bl.department_id AS dpid ,
    bl.remark AS blremark ,
    typee.remark AS pfix ,
    typee.name AS typee
    FROM 
    business_layer AS bl , 
    type_process AS typee
    WHERE
    typee.id = bl.type AND
    bl.id = ".$id);
  $model2 = DB::select("
    SELECT
    br.* , 
    al.* , 
    al.name AS alname , 
    al.id AS alid
    FROM
    business_relation AS br , application_layer AS al
    WHERE
    br.frag = 'a' AND
    br.comp_id = al.id AND
    br.business_layer_id = ".$id."
    ");
  $model3 = DB::select("
    SELECT
    br.* , 
    dl.* , 
    dl.name AS dlname , 
    dl.id AS dlid
    FROM
    business_relation AS br , data_layer AS dl
    WHERE
    br.frag = 'd' AND
    br.comp_id = dl.id AND
    br.business_layer_id = ".$id."
    ");
  $model4 = DB::select("
    SELECT 
    dp.name AS dpname , 
    dp.id AS dpid , 
    dr.id_bus AS drbusid , 
    dr.department_id AS drdpid
    FROM
    department AS dp , 
    bus_depart AS dr
    WHERE
    dp.id = dr.department_id
    ");
  return view('front.BusDetail')->with(['model'=>$model,'model2'=>$model2,'model3'=>$model3,'model4'=>$model4]);
}
public function viewApp(){
 $model = DB::select("
  SELECT
  al.* , 
  al.id AS alid , 
  al.name AS alname , 
  al.develop_language AS aldevl , 
  al.app_database AS alappdb ,
  al.getting_start_years AS algettingstartyear ,
  al.remark AS alremark , 
  pfix.initial AS pfix
  FROM 
  application_layer AS al , 
  initial AS pfix
  WHERE
  pfix.name = 'application'
  ORDER BY
  al.id
  ");
 $model2 = DB::select("
  SELECT
  al.* ,
  ar.* , 
  al.id AS alid ,   
  al.name AS alname ,
  ar.application_layer_id AS compalid
  FROM 
  application_layer AS al ,
  application_relation AS ar
  WHERE
  al.id = ar.comp_id AND
  ar.frag = 'a'
  ");
 $model3 = develop_language::all();
 $model4 = use_data::all();
 if($model==NULL){
  return view('front.Nothing');
}else{
  return view('front.App')->with(['model'=>$model,'model2'=>$model2,'model3'=>$model3,'model4'=>$model4]);
}

}
public function viewAppdetail($id){
  $model = DB::select("
    SELECT 
    al.* , 
    al.name AS alname , 
    al.id AS alid , 
    al.remark AS alremark ,
    pfix.initial AS pfix
    FROM 
    application_layer AS al , 
    initial AS pfix
    WHERE
    pfix.name = 'application' AND
    al.id = ".$id."
    ");
  $model2 = DB::select("
    SELECT
    ar.* , 
    al.* , 
    al.name AS alname , 
    al.id AS alid
    FROM
    application_relation AS ar , application_layer AS al
    WHERE
    ar.frag = 'a' AND
    ar.comp_id = al.id AND
    ar.application_layer_id = ".$id."
    ");
  $model3 = DB::select("
    SELECT
    la.* , 
    la.name AS laname , 
    la.id AS laid ,
    ar.* , 
    ar.id AS arid
    FROM
    develop_language AS la ,
    application_relation AS ar
    WHERE
    ar.comp_id = la.id AND
    ar.frag = 'la' AND
    ar.application_layer_id = ".$id."
    ");
  $model4 = DB::select("
    SELECT
    ser.* , 
    ser.name AS sername , 
    ser.id AS serid ,
    ar.* , 
    ar.id AS arid
    FROM
    technology_layer AS ser ,
    application_relation AS ar
    WHERE
    ser.type = '2' AND
    ar.comp_id = ser.id AND
    ar.frag = 'ser' AND
    ar.application_layer_id = ".$id."
    ");
  $model5 = DB::select("
    SELECT
    db.* , 
    db.name AS dbname , 
    db.id AS dbid ,
    ar.* , 
    ar.id AS arid
    FROM
    use_data AS db ,
    application_relation AS ar
    WHERE
    ar.comp_id = db.id AND
    ar.frag = 'db' AND
    ar.application_layer_id = ".$id."
    ");
  $model6 = DB::select("
    SELECT
    c.* , 
    c.name AS cname , 
    c.id AS cid ,
    ar.* , 
    ar.id AS arid
    FROM
    devlopment_group AS c ,
    application_relation AS ar
    WHERE
    ar.comp_id = c.id AND
    ar.frag = 'c' AND
    ar.application_layer_id = ".$id."
    ");
  $model7 = DB::select("
    SELECT
    bl.* , 
    bl.name AS blname , 
    bl.id AS blid ,
    ar.* , 
    ar.id AS arid
    FROM
    business_layer AS bl ,
    application_relation AS ar
    WHERE
    ar.comp_id = bl.id AND
    ar.frag = 'b' AND
    ar.application_layer_id = ".$id."
    ");
  $model8 = DB::select("
    SELECT
    dl.* , 
    dl.name AS dlname , 
    dl.id AS dlid ,
    ar.* , 
    ar.id AS arid
    FROM
    Data_layer AS dl ,
    application_relation AS ar
    WHERE
    ar.comp_id = dl.id AND
    ar.frag = 'd' AND
    ar.application_layer_id = ".$id."
    ");
  $model9 = DB::select("
    SELECT
    dp.* , 
    dp.name AS dpname , 
    dp.id AS dpid ,
    ar.* , 
    ar.id AS arid
    FROM
    department AS dp ,
    application_relation AS ar
    WHERE
    ar.comp_id = dp.id AND
    ar.frag = 'dp' AND
    ar.application_layer_id = ".$id."
    ");
  return view('front.AppDetail')->with(['model'=>$model,'model2'=>$model2,'model3'=>$model3,'model4'=>$model4,'model5'=>$model5,'model6'=>$model6,'model7'=>$model7,'model8'=>$model8,'model9'=>$model9]);
}

public function viewDat(){
  $model = DB::select("
  SELECT
  dl.* , 
  dl.id AS datid , 
  dl.name AS datname ,
  dl.type AS dattype ,
  dl.remark AS datremark ,
  typee.name AS typee , 
  pfix.initial AS pfix
  FROM 
  data_layer AS dl ,
  type_collection AS typee , 
  initial AS pfix
  WHERE 
  typee.id = dl.type AND
  pfix.name = 'data'
  ORDER BY
  dl.id
  ");

  if($model==NULL){
    return view('front.Nothing');
  }else{
    return view('front.Dat')->with(['model'=>$model]);
  }
}

public function viewDatdetail($id){
 $model = DB::select("
  SELECT 
  dl.* ,
  pfix.initial AS pfix , 
  typee.name AS typee
  FROM 
  data_layer AS dl ,
  initial AS pfix , 
  type_collection AS typee
  WHERE 
  typee.id = dl.type AND
  pfix.name = 'data' AND
  dl.id=".$id."");
 $model2 = DB::select("
  SELECT
  dr.* , 
  st.* , 
  st.name AS stname , 
  st.id AS stid ,
  dr.id AS drid
  FROM
  type_collection AS st ,
  data_relation AS dr
  WHERE
  dr.comp_id = st.id AND
  dr.frag = 'st' AND
  dr.data_layer_id = ".$id."
  ");
 $model3 = DB::select("
  SELECT
  dr.* , 
  al.* , 
  al.name AS alname , 
  al.id AS alid ,
  dr.id AS drid
  FROM
  application_layer AS al ,
  data_relation AS dr
  WHERE
  dr.comp_id = al.id AND
  dr.frag = 'a' AND
  dr.data_layer_id = ".$id."
  ");
 $model4 = DB::select("
  SELECT
  dr.* , 
  bl.* , 
  bl.name AS blname , 
  bl.id AS blid ,
  dr.id AS drid
  FROM
  business_layer AS bl ,
  data_relation AS dr
  WHERE
  dr.comp_id = bl.id AND
  dr.frag = 'b' AND
  dr.data_layer_id = ".$id."
  ");
 $model5 = DB::select("
  SELECT
  dr.* , 
  dp.* , 
  dp.name AS dpname , 
  dp.id AS dpid ,
  dr.id AS drid
  FROM
  department AS dp ,
  data_relation AS dr
  WHERE
  dr.comp_id = dp.id AND
  dr.frag = 'dp' AND
  dr.data_layer_id = ".$id."
  ");
 return view('front.DatDetail')->with(['model'=>$model,'model2'=>$model2,'model3'=>$model3,'model4'=>$model4,'model5'=>$model5]);
}

public function viewtec(){
 $model = DB::select("
  SELECT
  tl.* , 
  tl.id AS tecid ,
  tl.name AS tecname ,
  tl.brand AS tecbrand ,
  tl.model AS tecmodel ,
  tl.tech_spec AS tecspec ,
  tl.amount AS tecamount ,
  tl.tech_location AS teclocation ,
  tl.ma_cost AS tecma_cost ,
  tl.remark AS tecremark 
  FROM 
  technology_layer AS tl
  ORDER BY
  tl.id
  ");
 $model2 = brand::all();
 $model3 = place::all();

 if($model==NULL){
  return view('front.Nothing');
}else{
  return view('front.Tec')->with(['model'=>$model,'model2'=>$model2,'model3'=>$model3]);
}
}
public function viewTecdetail($id){
  $model = DB::select("
    SELECT 
    tl.*
    FROM 
    technology_layer AS tl
    WHERE
    tl.id = ".$id."
    ");
  $model2 = DB::select("
    SELECT
    tr.* , 
    al.* , 
    al.name AS alname , 
    al.id AS alid
    FROM
    technology_relation AS tr , application_layer AS al
    WHERE
    tr.frag = 'a' AND
    tr.comp_id = al.id AND
    tr.technology_layer_id = ".$id."
    ");
  $model3 = brand::all();
  $model4 = place::all();
  return view('front.TecDetail')->with(['model'=>$model,'model2'=>$model2,'model3'=>$model3,'model4'=>$model4]);
}
public function downloadbus($file_name) {    
  $filePath = public_path('images/bus/'.$file_name);

  if(file_exists($filePath)) {
    $fileName = basename($filePath);
    $fileSize = filesize($filePath);

    header("Cache-Control: private");
    header("Content-Type: application/stream");
    header("Content-Disposition: attachment; filename=".$fileName);

    readfile ($filePath);
    exit();
  }
  else {
    die('The provided file path is not valid.');
  }
}
public function downloaddat($file_name) {    
  $filePath = public_path('images/data/'.$file_name);

  if(file_exists($filePath)) {
    $fileName = basename($filePath);
    $fileSize = filesize($filePath);

    header("Cache-Control: private");
    header("Content-Type: application/stream");
    header("Content-Disposition: attachment; filename=".$fileName);

    readfile ($filePath);
    exit();
  }
  else {
    die('The provided file path is not valid.');
  }
}
public function downloadtec($file_name) {    
  $filePath = public_path('images/tech/'.$file_name);

  if(file_exists($filePath)) {
    $fileName = basename($filePath);
    $fileSize = filesize($filePath);

    header("Cache-Control: private");
    header("Content-Type: application/stream");
    header("Content-Disposition: attachment; filename=".$fileName);

    readfile ($filePath);
    exit();
  }
  else {
    die('The provided file path is not valid.');
  }
}
public function menurelation(){
  return view('front.menurelation');
}

public function viewrelation(){
  if($_POST["submit"]=="submit1")
    return $this->exportrelation();
  if($_POST["submit"]=="submit2")
    return $this->exportexcel();
}

public function exportrelation(){
  $st = $_POST['frst'];
  $nd = $_POST['scnd'];
  return $this->convertrelation($_POST['frst'],$_POST['scnd']);
}
public function convertrelation($frst , $scnd){
  switch ($frst) {
    case 'b':
    $modela = business_layer::all();
    break;
    case 'a':
    $modela = application_layer::all();
    break;
    case 'd':
    $modela = data_layer::all();
    break;
    case 't':
    $modela = technology_layer::all();
    break;
    case 'dp':
    $modela = department::all();
    break;
    case 'lo':
    $modela = place::all();
    break;
    case 'db':
    $modela = use_data::all();
    break;
    case 'la':
    $modela = develop_language::all();
    break;
    case 'c':
    $modela = devlopment_group::all();
    break;
  }
  switch ($scnd) {
    case 'b':
    $modelb = business_layer::all();
    break;
    case 'a':
    $modelb = application_layer::all();
    break;
    case 'd':
    $modelb = data_layer::all();
    break;
    case 't':
    $modelb = technology_layer::all();
    break;
    case 'dp':
    $modelb = department::all();
    break;
    case 'lo':
    $modelb = place::all();
    break;
    case 'db':
    $modelb = use_data::all();
    break;
    case 'la':
    $modelb = develop_language::all();
    break;
    case 'c':
    $modelb = devlopment_group::all();
    break;
    case 'ser';
    $modelb = DB::select("SELECT * FROM technology_layer WHERE type='1'");
    break;
    case 'st';
    $modelb = type_collection::all();
    break;
    case 'br';
    $modelb = brand::all();
    break;
  }
  if($frst=='b' && $scnd=='d'){
    $modelar = DB::select("SELECT ar.*,ar.business_layer_id AS arid , ar.comp_id AS arcomp FROM business_relation AS ar WHERE ar.frag='".$scnd."'");
    $modelbr = DB::select("SELECT br.*,br.data_layer_id AS brid , br.comp_id AS brcomp FROM data_relation AS br WHERE br.frag='".$frst."'");
  }
  if($frst=='b' && $scnd=='a'){
    $modelar = DB::select("SELECT ar.*,ar.business_layer_id AS arid , ar.comp_id AS arcomp FROM business_relation AS ar WHERE ar.frag='".$scnd."'");
    $modelbr = DB::select("SELECT br.*,br.application_layer_id AS brid , br.comp_id AS brcomp FROM application_relation AS br WHERE br.frag='".$frst."'");
  }
  if($frst=='b' && $scnd=='dp'){
    $modelar = DB::select("SELECT ar.*,ar.business_layer_id AS arid , ar.comp_id AS arcomp FROM business_relation AS ar WHERE ar.frag='".$scnd."'");
    $modelbr = DB::select("SELECT br.*,br.department_id AS brid , br.comp_id AS brcomp FROM department_relation AS br WHERE br.frag='".$frst."'");
  }
  if($frst=='a' && $scnd=='b'){
    $modelar = DB::select("SELECT ar.*,ar.application_layer_id AS arid , ar.comp_id AS arcomp FROM application_relation AS ar WHERE ar.frag='".$scnd."'");
    $modelbr = DB::select("SELECT br.*,br.business_layer_id AS brid , br.comp_id AS brcomp FROM business_relation AS br WHERE br.frag='".$frst."'");
  }
  if($frst=='a' && $scnd=='d'){
    $modelar = DB::select("SELECT ar.*,ar.application_layer_id AS arid , ar.comp_id AS arcomp FROM application_relation AS ar WHERE ar.frag='".$scnd."'");
    $modelbr = DB::select("SELECT br.*,br.data_layer_id AS brid , br.comp_id AS brcomp FROM data_relation AS br WHERE br.frag='".$frst."'");
  }
  if($frst=='a' && $scnd=='la'){
    $modelar = DB::select("SELECT ar.*,ar.application_layer_id AS arid , ar.comp_id AS arcomp FROM application_relation AS ar WHERE ar.frag='".$scnd."'");
    $modelbr = DB::select("SELECT br.*,br.develop_language_id AS brid , br.comp_id AS brcomp FROM develop_language_relation AS br WHERE br.frag='".$frst."'");
  }
  if($frst=='a' && $scnd=='db'){
    $modelar = DB::select("SELECT ar.*,ar.application_layer_id AS arid , ar.comp_id AS arcomp FROM application_relation AS ar WHERE ar.frag='".$scnd."'");
    $modelbr = DB::select("SELECT br.*,br.department_id AS brid , br.comp_id AS brcomp FROM department_relation AS br WHERE br.frag='".$frst."'");
  }
  if($frst=='a' && $scnd=='ser'){
    $modelar = DB::select("SELECT ar.*,ar.application_layer_id AS arid , ar.comp_id AS arcomp FROM application_relation AS ar WHERE ar.frag='t'");
    $modelbr = DB::select("SELECT br.*,br.technology_layer_id AS brid , br.comp_id AS brcomp FROM technology_relation AS br WHERE br.frag='".$frst."'");
  }
  if($frst=='a' && $scnd=='c'){
    $modelar = DB::select("SELECT ar.*,ar.application_layer_id AS arid , ar.comp_id AS arcomp FROM application_relation AS ar WHERE ar.frag='".$scnd."'");
    $modelbr = DB::select("SELECT br.*,br.devlopment_group_id AS brid , br.comp_id AS brcomp FROM devlopment_group_relation AS br WHERE br.frag='".$frst."'");
  }
  if($frst=='a' && $scnd=='dp'){
    $modelar = DB::select("SELECT ar.*,ar.application_layer_id AS arid , ar.comp_id AS arcomp FROM application_relation AS ar WHERE ar.frag='".$scnd."'");
    $modelbr = DB::select("SELECT br.*,br.department_id AS brid , br.comp_id AS brcomp FROM department_relation AS br WHERE br.frag='".$frst."'");
  }
  if($frst=='d' && $scnd=='b'){
    $modelar = DB::select("SELECT ar.*,ar.data_layer_id AS arid , ar.comp_id AS arcomp FROM data_relation AS ar WHERE ar.frag='".$scnd."'");
    $modelbr = DB::select("SELECT br.*,br.business_layer_id AS brid , br.comp_id AS brcomp FROM business_relation AS br WHERE br.frag='".$frst."'");
  }
  if($frst=='d' && $scnd=='st'){
    $modelar = DB::select("SELECT ar.*,ar.data_layer_id AS arid , ar.comp_id AS arcomp FROM data_relation AS ar WHERE ar.frag='".$scnd."'");
    $modelbr = DB::select("SELECT br.*,br.type_collection_id AS brid , br.comp_id AS brcomp FROM type_collection_relation AS br WHERE br.frag='".$frst."'");
  }
  if($frst=='d' && $scnd=='a'){
    $modelar = DB::select("SELECT ar.*,ar.data_layer_id AS arid , ar.comp_id AS arcomp FROM data_relation AS ar WHERE ar.frag='".$scnd."'");
    $modelbr = DB::select("SELECT br.*,br.application_layer_id AS brid , br.comp_id AS brcomp FROM application_relation AS br WHERE br.frag='".$frst."'");
  }
  if($frst=='d' && $scnd=='dp'){
    $modelar = DB::select("SELECT ar.*,ar.data_layer_id AS arid , ar.comp_id AS arcomp FROM data_relation AS ar WHERE ar.frag='".$scnd."'");
    $modelbr = DB::select("SELECT br.*,br.department_id AS brid , br.comp_id AS brcomp FROM department_relation AS br WHERE br.frag='".$frst."'");
  }
  if($frst=='t' && $scnd=='a'){
    $modelar = DB::select("SELECT ar.*,ar.technology_layer_id AS arid , ar.comp_id AS arcomp FROM technology_relation AS ar WHERE ar.frag='".$scnd."'");
    $modelbr = DB::select("SELECT br.*,br.application_layer_id AS brid , br.comp_id AS brcomp FROM application_relation AS br WHERE br.frag='".$frst."'");
  }
  if($frst=='t' && $scnd=='br'){
    $modelar = DB::select("SELECT ar.*,ar.technology_layer_id AS arid , ar.comp_id AS arcomp FROM technology_relation AS ar WHERE ar.frag='".$scnd."'");
    $modelbr = DB::select("SELECT br.*,br.brand_id AS brid , br.comp_id AS brcomp FROM brand_relation AS br WHERE br.frag='".$frst."'");
  }
  if($frst=='t' && $scnd=='lo'){
    $modelar = DB::select("SELECT ar.*,ar.technology_layer_id AS arid , ar.comp_id AS arcomp FROM technology_relation AS ar WHERE ar.frag='".$scnd."'");
    $modelbr = DB::select("SELECT br.*,br.place_id AS brid , br.comp_id AS brcomp FROM place_relation AS br WHERE br.frag='".$frst."'");
  }

  $tablea = $frst;
  $tableb = $scnd;
  return view('front.viewrelation')->
  with([
    'modelb'=>$modelb,
    'modela'=>$modela,
    'modelar'=>$modelar,
    'modelbr'=>$modelbr,
    'tablea'=>$tablea,
    'tableb'=>$tableb
    ]);
}
public function viewBusType($type){
 $model = DB::select("
  SELECT
  bl.* ,  
  bl.id AS blid , 
  bl.ids AS blids ,
  bl.name AS blname ,  
  bl.type AS bltype , 
  typee.name AS typee , 
  typee.remark AS pfix
  FROM 
  business_layer AS bl ,
  type_process AS typee 
  WHERE
  typee.id = bl.type AND
  bl.type = ".$type);
 $model2 = DB::select("
  SELECT
  bl.* , 
  al.* ,
  br.* , 
  bl.id AS blid ,   
  al.name AS alname ,
  br.business_layer_id AS compblid
  FROM 
  business_layer AS bl ,  
  application_layer AS al ,
  business_relation AS br
  WHERE
  al.id = br.comp_id AND
  bl.id = br.business_layer_id AND
  br.frag = 'a'
  ");
 $model3 = DB::select("
  SELECT 
  dp.name AS dpname , 
  dp.id AS dpid , 
  dr.id_bus AS drbusid , 
  dr.department_id AS drdpid
  FROM
  department AS dp , 
  bus_depart AS dr
  WHERE
  dp.id = dr.department_id
  ");
 if($model==NULL){
  return view('front.Nothing');
}else{
  return view('front.Bustype')->with(['model'=>$model,'model2'=>$model2,'model3'=>$model3]);
}
}
public function viewDatType($type){
 $model = DB::select("
  SELECT
  dl.* , 
  dl.id AS datid , 
  dl.name AS datname ,
  dl.type AS dattype ,
  dl.remark AS datremark ,
  pfix.initial AS pfix , 
  typee.name AS typee
  FROM 
  data_layer AS dl ,
  initial AS pfix ,
  type_collection AS typee
  WHERE
  pfix.name = 'data' AND
  dl.type = typee.id AND
  dl.type = ".$type);
 if($model==NULL){
  return view('front.Nothing');
}else{
  return view('front.Dattype')->with(['model'=>$model]);
}
}

public function viewTecType($type){
 $model = DB::select("
  SELECT
  tl.* , 
  tl.id AS tecid ,
  tl.name AS tecname ,
  tl.brand AS tecbrand ,
  tl.model AS tecmodel ,
  tl.tech_spec AS tecspec ,
  tl.amount AS tecamount ,
  tl.tech_location AS teclocation ,
  tl.ma_cost AS tecma_cost ,
  tl.remark AS tecremark 
  FROM 
  technology_layer AS tl
  WHERE
  type = ".$type);
 $model2 = brand::all();
 $model3 = place::all();
 if($model==NULL){
  return view('front.Nothing');
}else{
  return view('front.Tectype')->with(['model'=>$model,'model2'=>$model2,'model3'=>$model3]);
}
}

public function exportexcel(){
  // $st = 'b';
  // $nd = 'a';
  $st = $_POST['frst'];
  $nd = $_POST['scnd'];
  return $this->convertrelationexport($st,$nd);
}
public function convertrelationexport($frst , $scnd)
{
  switch ($frst) {
    case 'b':
    $modela = business_layer::all();
    $tablea = "กระบวนการ";
    break;
    case 'a':
    $modela = application_layer::all();
    $tablea = "ระบบสารสนเทศ";
    break;
    case 'd':
    $modela = data_layer::all();
    $tablea = "ข้อมูล";
    break;
    case 't':
    $modela = technology_layer::all();
    $tablea = "เทคโนโลยี";
    break;
    case 'dp':
    $modela = department::all();
    $tablea = "หน่วยงาน";
    break;
    case 'lo':
    $modela = place::all();
    $tablea = "สถานที่ตั้ง";
    break;
    case 'db':
    $modela = use_data::all();
    $tablea = "ฐานข้อมูล";
    break;
    case 'la':
    $modela = develop_language::all();
    $tablea = "ภาษาที่พัฒนา";
    break;
    case 'c':
    $modela = devlopment_group::all();
    $tablea = "บริษัทที่พัฒนา";
    break;
  }
  switch ($scnd) {
    case 'b':
    $modelb = business_layer::all();
    $tableb = "กระบวนการ";
    break;
    case 'a':
    $modelb = application_layer::all();
    $tableb = "ระบบสารสนเทศ";
    break;
    case 'd':
    $modelb = data_layer::all();
    $tableb = "ข้อมูล";
    break;
    case 't':
    $modelb = technology_layer::all();
    $tableb = "เทคโนโลยี";
    break;
    case 'dp':
    $modelb = department::all();
    $tableb = "หน่วยงานที่เกี่ยวข้อง";
    break;
    case 'lo':
    $modelb = place::all();
    $tableb = "สถานที่ตั้ง";
    break;
    case 'db':
    $modelb = use_data::all();
    $tableb = "ฐานข้อมูล";
    break;
    case 'la':
    $modelb = develop_language::all();
    $tableb = "ภาษาที่พัฒนา";
    break;
    case 'c':
    $modelb = devlopment_group::all();
    $tableb = "บริษัทที่พัฒนา";
    break;
    case 'ser';
    $modelb = DB::select("SELECT * FROM technology_layer WHERE type='1'");
    $tableb = "เครื่องแม่ข่าย";
    break;
    case 'st';
    $modelb = type_collection::all();
    $tableb = "การจัดเก็บ";
    break;
    case 'br';
    $modelb = brand::all();
    $tableb = "ยี่ห้อ";
    break;
  }
  if($frst=='b' && $scnd=='d'){
    $modelar = DB::select("SELECT ar.*,ar.business_layer_id AS arid , ar.comp_id AS arcomp FROM business_relation AS ar WHERE ar.frag='".$scnd."'");
    $modelbr = DB::select("SELECT br.*,br.data_layer_id AS brid , br.comp_id AS brcomp FROM data_relation AS br WHERE br.frag='".$frst."'");
  }
  if($frst=='b' && $scnd=='a'){
    $modelar = DB::select("SELECT ar.*,ar.business_layer_id AS arid , ar.comp_id AS arcomp FROM business_relation AS ar WHERE ar.frag='".$scnd."'");
    $modelbr = DB::select("SELECT br.*,br.application_layer_id AS brid , br.comp_id AS brcomp FROM application_relation AS br WHERE br.frag='".$frst."'");
  }
  if($frst=='b' && $scnd=='dp'){
    $modelar = DB::select("SELECT ar.*,ar.business_layer_id AS arid , ar.comp_id AS arcomp FROM business_relation AS ar WHERE ar.frag='".$scnd."'");
    $modelbr = DB::select("SELECT br.*,br.department_id AS brid , br.comp_id AS brcomp FROM department_relation AS br WHERE br.frag='".$frst."'");
  }
  if($frst=='a' && $scnd=='b'){
    $modelar = DB::select("SELECT ar.*,ar.application_layer_id AS arid , ar.comp_id AS arcomp FROM application_relation AS ar WHERE ar.frag='".$scnd."'");
    $modelbr = DB::select("SELECT br.*,br.business_layer_id AS brid , br.comp_id AS brcomp FROM business_relation AS br WHERE br.frag='".$frst."'");
  }
  if($frst=='a' && $scnd=='d'){
    $modelar = DB::select("SELECT ar.*,ar.application_layer_id AS arid , ar.comp_id AS arcomp FROM application_relation AS ar WHERE ar.frag='".$scnd."'");
    $modelbr = DB::select("SELECT br.*,br.data_layer_id AS brid , br.comp_id AS brcomp FROM data_relation AS br WHERE br.frag='".$frst."'");
  }
  if($frst=='a' && $scnd=='la'){
    $modelar = DB::select("SELECT ar.*,ar.application_layer_id AS arid , ar.comp_id AS arcomp FROM application_relation AS ar WHERE ar.frag='".$scnd."'");
    $modelbr = DB::select("SELECT br.*,br.develop_language_id AS brid , br.comp_id AS brcomp FROM develop_language_relation AS br WHERE br.frag='".$frst."'");
  }
  if($frst=='a' && $scnd=='db'){
    $modelar = DB::select("SELECT ar.*,ar.application_layer_id AS arid , ar.comp_id AS arcomp FROM application_relation AS ar WHERE ar.frag='".$scnd."'");
    $modelbr = DB::select("SELECT br.*,br.department_id AS brid , br.comp_id AS brcomp FROM department_relation AS br WHERE br.frag='".$frst."'");
  }
  if($frst=='a' && $scnd=='ser'){
    $modelar = DB::select("SELECT ar.*,ar.application_layer_id AS arid , ar.comp_id AS arcomp FROM application_relation AS ar WHERE ar.frag='t'");
    $modelbr = DB::select("SELECT br.*,br.technology_layer_id AS brid , br.comp_id AS brcomp FROM technology_relation AS br WHERE br.frag='".$frst."'");
  }
  if($frst=='a' && $scnd=='c'){
    $modelar = DB::select("SELECT ar.*,ar.application_layer_id AS arid , ar.comp_id AS arcomp FROM application_relation AS ar WHERE ar.frag='".$scnd."'");
    $modelbr = DB::select("SELECT br.*,br.devlopment_group_id AS brid , br.comp_id AS brcomp FROM devlopment_group_relation AS br WHERE br.frag='".$frst."'");
  }
  if($frst=='a' && $scnd=='dp'){
    $modelar = DB::select("SELECT ar.*,ar.application_layer_id AS arid , ar.comp_id AS arcomp FROM application_relation AS ar WHERE ar.frag='".$scnd."'");
    $modelbr = DB::select("SELECT br.*,br.department_id AS brid , br.comp_id AS brcomp FROM department_relation AS br WHERE br.frag='".$frst."'");
  }
  if($frst=='d' && $scnd=='b'){
    $modelar = DB::select("SELECT ar.*,ar.data_layer_id AS arid , ar.comp_id AS arcomp FROM data_relation AS ar WHERE ar.frag='".$scnd."'");
    $modelbr = DB::select("SELECT br.*,br.business_layer_id AS brid , br.comp_id AS brcomp FROM business_relation AS br WHERE br.frag='".$frst."'");
  }
  if($frst=='d' && $scnd=='st'){
    $modelar = DB::select("SELECT ar.*,ar.data_layer_id AS arid , ar.comp_id AS arcomp FROM data_relation AS ar WHERE ar.frag='".$scnd."'");
    $modelbr = DB::select("SELECT br.*,br.type_collection_id AS brid , br.comp_id AS brcomp FROM type_collection_relation AS br WHERE br.frag='".$frst."'");
  }
  if($frst=='d' && $scnd=='a'){
    $modelar = DB::select("SELECT ar.*,ar.data_layer_id AS arid , ar.comp_id AS arcomp FROM data_relation AS ar WHERE ar.frag='".$scnd."'");
    $modelbr = DB::select("SELECT br.*,br.application_layer_id AS brid , br.comp_id AS brcomp FROM application_relation AS br WHERE br.frag='".$frst."'");
  }
  if($frst=='d' && $scnd=='dp'){
    $modelar = DB::select("SELECT ar.*,ar.data_layer_id AS arid , ar.comp_id AS arcomp FROM data_relation AS ar WHERE ar.frag='".$scnd."'");
    $modelbr = DB::select("SELECT br.*,br.department_id AS brid , br.comp_id AS brcomp FROM department_relation AS br WHERE br.frag='".$frst."'");
  }
  if($frst=='t' && $scnd=='a'){
    $modelar = DB::select("SELECT ar.*,ar.technology_layer_id AS arid , ar.comp_id AS arcomp FROM technology_relation AS ar WHERE ar.frag='".$scnd."'");
    $modelbr = DB::select("SELECT br.*,br.application_layer_id AS brid , br.comp_id AS brcomp FROM application_relation AS br WHERE br.frag='".$frst."'");
  }
  if($frst=='t' && $scnd=='br'){
    $modelar = DB::select("SELECT ar.*,ar.technology_layer_id AS arid , ar.comp_id AS arcomp FROM technology_relation AS ar WHERE ar.frag='".$scnd."'");
    $modelbr = DB::select("SELECT br.*,br.brand_id AS brid , br.comp_id AS brcomp FROM brand_relation AS br WHERE br.frag='".$frst."'");
  }
  if($frst=='t' && $scnd=='lo'){
    $modelar = DB::select("SELECT ar.*,ar.technology_layer_id AS arid , ar.comp_id AS arcomp FROM technology_relation AS ar WHERE ar.frag='".$scnd."'");
    $modelbr = DB::select("SELECT br.*,br.place_id AS brid , br.comp_id AS brcomp FROM place_relation AS br WHERE br.frag='".$frst."'");
  }


    // $modela = application_layer::all();
    // $modelar = DB::select("SELECT ar.*,ar.application_layer_id AS arid , ar.comp_id AS arcomp FROM application_relation AS ar WHERE ar.frag='b'");
    // $modelb = application_layer::all();
    // $modelbr = DB::select("SELECT br.*,br.business_layer_id AS brid , br.comp_id AS brcomp FROM business_relation AS br WHERE br.frag='a'");
    $layerid[0][0]=0;
    $f = 0;
    $n = 0;
    foreach ($modelb as $modellb) {
      foreach ($modela as $modella) {

        foreach ($modelbr as $modellbr) {
          if( $modellbr->brid == $modellb->id){
            if( $modellbr->brcomp == $modella->id){
              $f=1;
            }
          }
        }

        foreach ($modelar as $modellar) {
          if( $modellar->arid == $modella->id){
            if( $modellar->arcomp == $modellb->id){
              $n=1;
            }
          }
        }
        if ($f == 1 || $n == 1) {
          $layerid[$modellb->id][$modella->id] = "true";
          $f = 0;
          $n = 0;
        }else{
          $layerid[$modellb->id][$modella->id] = "false";
          $f = 0;
          $n = 0;
        }

      }
    }
    Excel::create("ตารางความสัมพันธ์ของ".$tablea." - ".$tableb, function($excel)use($layerid,$modela,$modelb,$modelar,$modelbr){
      $excel->sheet('ตารางความสัมพันธ์', function($sheet)use($layerid,$modela,$modelb,$modelar,$modelbr){
  //Content
          $colum = 'A';
          $ro = 1;
          //$sheet->cell("A"."2", function($cell)use($layerid){$cell->setValue($layerid[1][2]); });
          foreach ($modela as $modella) {
            $ro++;
            foreach ($modelb as $modellb) {
              $colum++;
              if ($layerid[$modellb->id][$modella->id]=="true") {
                       $sheet->cell($colum.$ro, function($cell)use($layerid,$modella,$modellb){$cell->setValue("✔")->setAlignment('center'); });
              }
              //$sheet->cell($colum.$ro, function($cell)use($layerid,$modella,$modellb){$cell->setValue($modella->id."/".$modellb->id); });


            }
            $colum = 'A';
          }
  //Content
  //Header
          $colum = 'B';
          $ro = 2;
          foreach ($modelb as $modellb) {
            //$sheet->cell($colum."1",  function($cell)use($modellb){$cell->setValue($modellb->id.$modellb->name); });
            $sheet->cell($colum."1",  function($cell)use($modellb){$cell->setValue($modellb->name); });
            $colum++;
          }
          foreach ($modela as $modella) {
            //$sheet->cell("A".$ro, function($cell)use($modella){$cell->setValue($modella->id.$modella->name); });
            $sheet->cell("A".$ro, function($cell)use($modella){$cell->setValue($modella->name); });
            $ro++;
          }
  //Header
        });
      })->download('xls');
    }
}/*
    //start th row
foreach($modela as $modella){
  {{$modella->name}}
}
    //end th row

    //start th column
foreach($modelb as $modellb){
  {{$modellb->name}}
  foreach($modela as $modella){

    $f=0; $n=0;
      //start comp a
    foreach($modelar as $modellar){
      if($modellar->arid==$modella->id){ 
        if($modellb->id==$modellar->arcomp){
          $f=1;
        }
      }
    }
      //end comp a

      //start comp b
    foreach($modelbr as $modellbr){
      if($modellbr->brid==$modellb->id){
        if($modella->id==$modellbr->brcomp){
          $n=1;
        }
      }
    }
      //end comp b

      //start print
    if($f==1||$n==1){
      echo '✔';
    }
      //end print

  }
}
*/