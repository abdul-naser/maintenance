<?php

$whereList = "";

if ($school_code && !$adminLogin) {
    $whereList = " AND r.applicant_school = '$school_code'"; // Add quotes if school_code is a string
}
elseif($noSection && !$adminLogin) {
    $whereList = " AND r.applicant_section = '$noSection'"; // Add quotes if school_code is a string

}

elseif($_SESSION['role'] == "technical") {
    $whereList = " AND request_assign = '$nameAdmin'"; // Add quotes if school_code is a string

}

$query = "
SELECT r.*, s.name, sc.department_name, request_assign.request_assign,request_status.request_status
FROM requests_maintenance r 
LEFT JOIN schools s ON r.applicant_school = s.code 
LEFT JOIN login_section sc ON r.applicant_section = sc.no 

-- نضيف هنا فلترة للـ request_assign بحيث نعرض فقط التعيين الأخير
LEFT JOIN request_assign ON r.no = request_assign.no_request 
    AND request_assign.time_update_assign = (
        SELECT MAX(time_update_assign)
        FROM request_assign AS ra
        WHERE ra.no_request = r.no
    )

    -- نضيف هنا فلترة للـ request_assign بحيث نعرض فقط الحالة الأخير
LEFT JOIN request_status ON r.no = request_status.no_request 
    AND request_status.time_update_status = (
        SELECT MAX(time_update_status)
        FROM request_status AS rs
        WHERE rs.no_request = r.no
    )

WHERE 1=1 " . $whereList . " ORDER BY r.no DESC";


$result = $conn->query($query);


?>

<section id="sec-2" <?php echo $adminNone;  ?>>
<!-- <section id="sec-2"> -->


<!-- <div id="resultDetailesReque"> -->

<div class="recent_order">
         <h2>قائمة الطلبات</h2>
         <table> 
             <thead>
              <tr>
                <th>رقم الطلب</th>
                <th>عنوان الطلب</th>
                <th>جهة الطلب</th>
                <th>تعيين لي </th>
          
                <th>وقت الطلب</th>
                <th>حالة الطلب</th>
              </tr>
             </thead>

        
              <tbody>

              <?php
        while ($row = $result->fetch_assoc()) {

             ?>
                 <tr>
                   <td><?php echo $row['no'] ?></td>
                   <td>
    <?php
    echo ($row['tiltle'] === 'اخرى') ? $row['another_title'] : $row['tiltle'];
    ?>
</td>
                   <td><?php echo $row['name'], $row['department_name']?></td>
                   <td><?php 
                   if(empty($row['request_assign'])) {
                    echo "<span class='warning'>لم يتم التعيين بعد";
                   }
                   else {
                   echo $row['request_assign'];
                   }
                    ?></td>
                   <td><?php echo $row['request_time'] ?></td>

                   <!-- <td class="warning"><?php echo $row['request_status'] ?></td> -->

                   
<?php if ($row['request_status'] == 'تم الانجاز') {?>

<td class="success"><?php echo $row['request_status']; ?></td>

<?php } else if  ($row['request_status'] == 'أرسال للمشتريات') {?>

<td class="py-3 px6 text-red-600"><?php echo $row['request_status']; ?></td>

<?php  }  else if  ($row['request_status'] == 'تحتاج زيارة مهندس') {?>
    <td class="py-3 px-6 text-lime-600"><?php echo $row['request_status']; ?></td>
    <?php  } else if  ($row['request_status'] == 'تحتاج توفير مواد من ادارة المدرسة') {?>
    <td class="py-3 px6 text-yellow-400"><?php echo $row['request_status']; ?></td>

    <?php  }  
    else {?>
<td class="warning">مفتوح</td>
    <?php }?>

    
                   <td class="primary">
                    <input type="hidden" class="requestNo" value="<?php echo $row['no']; ?>">

                    <button class="viewReportRequest">التفاصيل</button></td>
                 </tr>
             <?php
        }
             ?>
              </tbody>
         </table>
      </div>

      </section>

<div id="resultDetailesReque">
</div>

      <script>

$(document).ready(function(){ 


$(".viewReportRequest").click(function(){
    let rowRequest =  $(this).closest('td');
    let requestNo =Number(rowRequest.find(".requestNo").val());

    $.ajax ({
        url:"detailes_request.php",
        method: "POST",
        data: {requestNo:requestNo},

        success:function(data){
            $("#resultDetailesReque").html(data);
            $("#resultDetailesReque").css("display", "block");
            $("#sec-2").css("display", "none");

        }
    });

 
});

})

      </script>