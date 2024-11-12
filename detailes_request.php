
<?php
include 'conn.php';
session_start(); // Start or resume the session


$requesterNone =  (isset($_SESSION['logged_in']) || isset($_SESSION['logged_section'])? 'style="display:none;"' : '');
$tecnicalNone = (isset($_SESSION['role']) && $_SESSION['role'] == "technical") ? 'style="display:none;"' : null;
$nameAdmin = isset($_SESSION['nameAdmin']) ? $_SESSION['nameAdmin'] : null;

// $name_requester =$_SESSION['login_request_name'];




 $requestNo=$_POST['requestNo'];

 $sql = "
 SELECT requests_maintenance.*, latest_status.request_status, latest_assign.request_assign, 
        schools.name, login_section.department_name
 FROM requests_maintenance
 LEFT JOIN schools ON requests_maintenance.applicant_school = schools.code
 LEFT JOIN login_section ON requests_maintenance.applicant_section = login_section.no
 LEFT JOIN (
     SELECT rs.no_request, rs.request_status
     FROM request_status rs
     INNER JOIN (
         SELECT no_request, MAX(time_update_status) AS latest_time
         FROM request_status
         GROUP BY no_request
     ) AS latest ON rs.no_request = latest.no_request 
                  AND rs.time_update_status = latest.latest_time
 ) AS latest_status ON requests_maintenance.no = latest_status.no_request
 LEFT JOIN (
     SELECT ra.no_request, ra.request_assign
     FROM request_assign ra
     INNER JOIN (
         SELECT no_request, MAX(time_update_assign) AS latest_time
         FROM request_assign
         GROUP BY no_request
     ) AS latest ON ra.no_request = latest.no_request 
                  AND ra.time_update_assign = latest.latest_time
 ) AS latest_assign ON requests_maintenance.no = latest_assign.no_request
 WHERE requests_maintenance.no='$requestNo'";
 



$result = $conn->query($sql);





?>




    <?php


// if(isset($_POST['replay_send']))
// //if (!empty($_POST['replay_send']))

//  {

//   $replay=$_POST['replay_txt'];
//     $replay_owner=$_POST['replay_owner_txt'];
//   $no_request=$_POST['no_request_txt'];



//   $sql_replay ="insert into replay_request (replay_message,replay_owner,no_request) values ('$replay','$replay_owner','$no_request')";
//   $sql_replay_connect=mysql_query($sql_replay,$db_connect);



// }



  while ($row = $result->fetch_assoc())
{ 

?>

<section id="sec-21" >

<div id="allsection">

<div class="flex mb-4">

<div <?php echo $requesterNone  ?>  id="hireBtn" class="commant_link w-48	 rounded-md bg-gradient-to-r from-cyan-300 to-cyan-500 hover:from-cyan-700  hover:to-cyan-800   py-2 px-6 text-white text-center ml-2">
    <button >تحديث حالة الطلب <ion-icon name="create-outline"></ion-icon></butoon>
</div>


<div <?php echo $requesterNone,$tecnicalNone;  ?> id="hireBtn2"  class="trans_link w-48 	 rounded-md bg-gradient-to-r from-cyan-300 to-cyan-500 hover:from-cyan-700  hover:to-cyan-800   py-2 px-6 text-white text-center">
    <button >تحويل الطلب<ion-icon name="arrow-undo-circle-outline"></ion-icon></butoon>
</div>

</div>






  <div class=" ">
    <span class="text-xl font-medium ">رقم الطلب &nbsp;</span>
    <span class="text-xl font-medium "> <?php echo $row['no']; ?></span>
    <span class="text-xl font-medium "> # &nbsp; &nbsp;</span>
    <span class="text-xl font-medium "><?php echo $row['request_time']; ?> <ion-icon name="time-outline"></ion-icon></span>




  </div>





    <form  action="detailes_request.php" method="post" class="w-10/12  p-2  ">
    <input type="hidden" name="id1" value="<?php echo $row['request_number']; ?>">
    <input type="hidden" name="replay_owner_txt" value="<?php echo $row['request_dep']; ?>">
    <input type="hidden" name="no_request_txt" value="<?php echo $row['request_number']; ?>">



            <div   class="mt-1 block w-full px-3 py-2  border border-slate-300  shadow-sm placeholder-slate-400
               	flex flex-row

            ">



  <div>
  <?php if ($row['request_status'] == 'تم الانجاز') {?>

  <div class="ml-8 text-xl success" ><ion-icon name="checkmark-done-outline"></ion-icon><?php echo $row['request_status']  ?></div>

  <?php } else if  ($row['request_status'] == 'أرسال للمشتريات') {?>

    <div class="ml-8 text-xl text-red-600"><ion-icon name="send-outline"></ion-icon><?php echo $row['request_status']  ?></div>

    <?php  }  else if  ($row['request_status'] == 'تحتاج زيارة مهندس') {?>
      <div class="ml-8 text-xl text-lime-600"><ion-icon name="walk-outline"></ion-icon><?php echo $row['request_status']  ?></div>
      <?php  } else if  ($row['request_status'] == 'تحتاج توفير مواد من ادارة المدرسة') {?>
        <div class="ml-8 text-xl text-yellow-400"><ion-icon name="business-outline"></ion-icon><?php echo $row['request_status']  ?></div>

        <?php  }  else {?>
<div class="ml-8 text-xl warning"><ion-icon name="open-outline"></ion-icon>مفتوح</div>

    <?php }?>



</div>


            <div class="text-xl">
            <?php
    echo ($row['tiltle'] === 'اخرى') ? $row['another_title'] : $row['tiltle'];
    ?>
</div>


          
          </div>


            <div   class=" block w-full px-3 py-9  bg-cyan-100 border border-slate-300  text-sm shadow-sm placeholder-slate-400 ">
            <?php echo $row['details']; ?>


            <span class="block text-sm font-medium text-slate-700 mt-7"> الملفات المرفقة</span>

            <?php
          if($row['file']==""){ 
            echo "لا توجد";
          }
          
        else { ?>
            <a href="upload/<?php echo $row['file']; ?>" target="_blank" class="text-xl">
    <ion-icon name="download-outline"></ion-icon>
</a>

<?php  } ?>
          
          </div>

          <label class="block">
            <!-- Using form state modifers, the classes can be identical for every input -->
            <div  class=" block w-full px-3 py-2 bg-white border border-slate-300 shadow-sm placeholder-slate-400
               w-3/4 text-xl
            "><ion-icon name="information-circle-outline"></ion-icon>
           
            <div  id="all-info" class="mt-1   w-full  py-2 bg-white  text-sm shadow-sm placeholder-slate-400 flex justify-between
               w-3/4 
            ">
            <div>
            <span class="block text-sm font-medium text-slate-700 ">جهة الطلب</span>
            
            <?php echo $row['name']; ?>
            <?php echo $row['department_name']; ?>

        </div>


        <div>

            <span class="block text-sm font-medium text-slate-700 ">بيانات التواصل</span>
<?php echo $row['contact']; ?>

</div>

<div>

<!-- <span class="block text-sm font-medium text-slate-700 "> الجهة المعنية بالطلب</span>
<?php echo $row['request_assign']; ?> -->

</div>
          
          </div>
          
          </div>
          </label>




          <!-- الردود على الطلب -->

<?php

$sql_replay = "SELECT * FROM request_status WHERE no_request='$requestNo' ORDER BY no DESC";
$sql_replay_connect = $conn->query($sql_replay);



if($sql_replay_connect) {
  while ($rowReplay = $sql_replay_connect->fetch_assoc())
{ 

?>

<div   class="mt-7 block  px-3 py-2 bg-white border border-slate-300  shadow-sm placeholder-slate-400
               w-3/4 	flex flex-row

            ">
            <div>

            <span>  <div> <ion-icon class="leading-10"  name="person-circle-outline"></ion-icon><?php echo $rowReplay['status_owner']; ?></span>
          </div>

            </div>

&nbsp; &nbsp; &nbsp; &nbsp;

  <div>
<span> <ion-icon name="time-outline"></ion-icon><?php echo $rowReplay['time_update_status']; ?></span>
</div>
</div>

<div class="block w-3/4 px-3 py-7  border border-slate-300 text-sm shadow-sm placeholder-slate-400">
<span >تم تحديث الطلب إلى:</span> <span class="primary"><?php echo $rowReplay['request_status']; ?></span>
<br>
<span class="primary"><?php echo $rowReplay['note_status']; ?></span>

  
</div>



          
       



<?php
}
}
?>




          <!-- الردود على الطلب نهاية-->


          <!-- <label class="block">
            <textarea rows="8" name="replay_txt" required  class="mt-7 block w-full px-3 py-2 bg-white border border-slate-300 rounded-md text-sm shadow-sm placeholder-slate-400
              focus:outline-none focus:border-sky-500 focus:ring-1 focus:ring-sky-500
              disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none
              
               w-3/4 h-40
            " placeholder="رد على الطلب..."></textarea>
          </label>
          <div  class=" w-24	 rounded-md bg-gradient-to-r from-teal-300 to-teal-400 hover:from-teal-500  hover:to-teal-600 mt-1   py-2 px-1 text-white text-center">
<button type="submit" name="replay_send">رد</butoon> -->
      <!--<input type="submit" name="replay_send" value="رد">-->
</div>


    </form>
</div>


<?php
// }
}
?>




<!--poupup box start-->
<?php
// $sql_statue="SELECT * FROM requests WHERE no='$requestNo'";
// $sql_statue_connect = $conn->query($sql_statue);



//   while ($row = $sql_statue_connect->fetch_assoc())

// { 


?>

<div class="popup-outer m-auto">
  <div class="popup-box">
    <ion-icon id="close" name="close-outline"></ion-icon>

    <form action="statue_update.php" method="post">

<input type="hidden"  name="number_request_usestaues" value="<?php echo  $requestNo; ?>">
<input type="hidden"  name="status_owner" value="<?php echo $nameAdmin ?>">


    <label class="block">
      <span class="block text-sm font-medium text-slate-700 mt-7">حالة الطلب</span>
      <!-- Using form state modifers, the classes can be identical for every input -->
      <select name="statue" class="mt-1 block w-full px-3 py-2 bg-white border border-slate-300 rounded-md text-sm shadow-sm placeholder-slate-400
        focus:outline-none focus:border-sky-500 focus:ring-1 focus:ring-sky-500
        disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none
        w-full	
      ">

      <?php
        //  $selected1='';
        //  $selected2='';
        //  $selected3='';
        //  $selected4='';
        //  if($row['request_status']=='مفتوح')
        //  {
        //     $selected1='selected';
        //  }

        //  elseif($row['request_status']=='تم حلها')
        //  {
        //     $selected2='selected';
        //  }

        //  elseif($row['request_status']=='ف الانتظار')
        //  {
        //     $selected3='selected';
        //  }

        //  elseif($row['request_status']=='ملغي')
        //  {
        //     $selected4='selected';
        //  }


         ?>
<!-- 
      <option <?php echo $selected1;?>>مفتوح</option>
      <option <?php echo $selected2;?>>تم حلها</option>
      <option <?php echo $selected3;?>>ف الانتظار</option>
      <option <?php echo $selected4;?>>ملغي</option> -->

      
      <option>تم الانجاز</option>
      <option> أرسال للمشتريات</option>
      <option>تحتاج زيارة مهندس</option>
      <option>تحتاج توفير مواد من ادارة المدرسة</option>
      <option>غير ذلك</option>

    </select>
  </label>

  <label class="block">
            <span class="block text-sm font-medium text-slate-700 mt-7">تعليق</span>
            <!-- Using form state modifers, the classes can be identical for every input -->
            <textarea  name="note"   class="mt-1 block w-full px-3 py-2 bg-white border border-slate-300 rounded-md text-sm shadow-sm placeholder-slate-400
              focus:outline-none focus:border-sky-500 focus:ring-1 focus:ring-sky-500
              disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none
              
             
            "></textarea>
          </label>

  <div class="button">
    <button class="send" name="save">حفظ</button>
    <a id="close" class="cancel">الغاء</a>
</div>
</form>



  </div>
</div>


<?php
include 'conn.php';

if(isset($_POST['save_to']))

{

$noRequest=$_POST['noRequest'];
$request_assign=$_POST['request_assign_txt'];
// $assign_owner=$_POST['assign_owner_txt'];


$sql_assign = "insert into request_assign (request_assign,assign_owner,no_request) values ('$request_assign',NULL,'$noRequest')";

$sql_assign_query = $conn->query($sql_assign);


if($sql_assign_query) {
    echo '<script> alert("تم تحديث الطلب"); </script>';
}
}

?>


<!--poupup box start-->
<?php
$sql2="SELECT * FROM requests_maintenance WHERE no='$requestNo'";
$result2 = $conn->query($sql2);

while ($row = $result2->fetch_assoc())

{ 


?>

<div class="popup-outer2 m-auto">
  <div class="popup-box2">
    <ion-icon id="close2" name="close-outline"></ion-icon>

    <form action="assign_update.php" method="post">

<input type="hidden" name="noRequest" value="<?php echo $row['no']; ?>">
<!-- <input type="hidden"  name="assign_owner_txt" value="<?php echo $name_requester ?>"> -->


    <label class="block">
      <span class="block text-sm font-medium text-slate-700 mt-7">تحويل الطلب الى</span>
      <!-- Using form state modifers, the classes can be identical for every input -->
      <select name="request_assign_txt" class="mt-1 block w-full px-3 py-2 bg-white border border-slate-300 rounded-md text-sm shadow-sm placeholder-slate-400
        focus:outline-none focus:border-sky-500 focus:ring-1 focus:ring-sky-500
        disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none
        w-full	
      ">

      <?php
$query_tech="SELECT name  FROM login_admin_maintenance WHERE  role = 'technical'";
$result_tech = $conn->query($query_tech);

  while ($row = $result_tech->fetch_assoc())
{

         ?>

<option><?php echo $row['name']; ?></option>
<?php
}
?>

    </select>
  </label>

  <div class="button">
    <button class="send" name="save_to">حفظ</button>
    <a id="close2" class="cancel">الغاء</a>
</div>
</form>
<?php
}

?>


  </div>
</div>



</section>


<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>


<script>




const section =document.querySelector("body"),

hireBtn =section.querySelector("#hireBtn"),
closeBtn= section.querySelectorAll("#close");


hireBtn.addEventListener("click", () => {
    section.classList.add("show");

});

closeBtn.forEach (cBtn => {
    cBtn.addEventListener("click", ()=> {
        section.classList.remove("show");

    });
});


//second 
const section1 =document.querySelector("body"),

hireBtn2 =section1.querySelector("#hireBtn2"),
closeBtn2= section1.querySelectorAll("#close2");


hireBtn2.addEventListener("click", () => {
    section1.classList.add("show2");

});

closeBtn2.forEach (cBtn => {
    cBtn.addEventListener("click", ()=> {
        section1.classList.remove("show2");

    });
});


</script>

<style>
  
section .popup-outer {
  display: flex;
  align-items: center;
  justify-content: center;
  height: 1000px;
  width: 1000px;
  background: rgba(0, 0, 0, 0.4);
  opacity: 0;
  pointer-events: none;
}

.show #allsection{
  display: none;
}
.show #hireBtn{
  display: none;
}

.show .history_link{
  display: none;
}


.show .trans_link{
  display: none;
}

.show .popup-outer2{
  display: none;
}


.show .popup-outer{
  opacity: 10;
      pointer-events: auto;

}

section .popup-box {
  padding: 30px;
  max-width: 450px;
  width: 100%;
  background: #fff;
  border-radius: 12px;
}

.popup-box ion-icon {
  cursor: pointer;
  font-size: 24px;
  color: #b4b4b4;
  transition: all 0.2s ease;

}

.popup-box ion-icon:hover {
  color:#333;

}

.popup-box textarea {
  min-height: 140px;
  width: 100%;
  margin-top: 20px;
  outline: none;
  border: 1px solid #ddd;
  padding: 12px;
  border-radius: 6px;
  resize: none;
  font-size: 14px;
  font-weight: 400;
  
}

section .popup-box .button {
  display: flex;
  margin-top: 15px;
  
}

.popup-box .button button ,
.popup-box .button a
{
  outline: none;
  border: none;
  padding: 6px 12px;
  border-radius: 6px;
  background: #6f93f6;
  margin-left: 8px;
  color: #fff;
  font-size: 16px;
  cursor: pointer;
  transition: all 0.3s ease;
}



.button a.cancel{
  background-color: #f082ac;
}
.button a.cancel:hover {
  background-color: #ec5f95;
  }

  .button button.send:hover {
      background-color: #275df1;
      }

      .number_hidden {
        display: none;
      }





/*  start secand popup */


section .popup-outer2 {
  display: flex;
  align-items: center;
  justify-content: center;
  height: 1000px;
  width: 1000px;
  background: rgba(0, 0, 0, 0.4);
  opacity: 0;
  pointer-events: none;
}

.show2 #allsection{
  display: none;
}
.show2 #hireBtn2{
  display: none;
}

.show2 .popup-outer{
  display: none;
}

.show2 .history_link{
  display: none;
}

.show2 .commant_link{
  display: none;
}


.show2 .trans_link{
  display: none;
}

.show2 .popup-outer2{
  opacity: 10;
      pointer-events: auto;

}

section .popup-box2 {
  padding: 30px;
  max-width: 450px;
  width: 100%;
  background: #fff;
  border-radius: 12px;
}

.popup-box2 ion-icon {
  cursor: pointer;
  font-size: 24px;
  color: #b4b4b4;
  transition: all 0.2s ease;

}

.popup-box2 ion-icon:hover {
  color:#333;

}

.popup-box2 textarea {
  min-height: 140px;
  width: 100%;
  margin-top: 20px;
  outline: none;
  border: 1px solid #ddd;
  padding: 12px;
  border-radius: 6px;
  resize: none;
  font-size: 14px;
  font-weight: 400;
  
}

section .popup-box2 .button {
  display: flex;
  margin-top: 15px;
  
}

.popup-box2 .button button ,
.popup-box2 .button a
{
  outline: none;
  border: none;
  padding: 6px 12px;
  border-radius: 6px;
  background: #6f93f6;
  margin-left: 8px;
  color: #fff;
  font-size: 16px;
  cursor: pointer;
  transition: all 0.3s ease;
}



.button a.cancel{
  background-color: #f082ac;
}
.button a.cancel:hover {
  background-color: #ec5f95;
  }

  .button button.send:hover {
      background-color: #275df1;
      }

      .number_hidden {
        display: none;
      }

      /*  end secand popup */
</style>
