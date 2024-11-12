
<section  <?php echo $requesterNone;  ?> id="sec-1">



<div class="date">
<select id="select_topbar">

<option value="optionMonth">تحليل شهري</option>
<option value="optionYear">تحليل سنوي</option>

</select>         



<!-- Month Search Form -->

<form method="post" action="" >

<div class="search" id="form_search1" >
    <label>
        <input type="text" id="live_search_1" placeholder="السنة">
    </label>

    <label>
        <input type="text" id="live_search_2" placeholder="الشهر">
    </label>
</div>

</form>
<!-- _____________________________ -->



<!-- Year Search Form -->

<form method="post" action=""  >

<div class="search" id="form_search2" style="display: none;">
<label>
<input type="text" id="live_search_year" placeholder="السنة">
</label>
</div>

</form>

<!-- _____________________________ -->
 

</div>

        <div class="insights">

           <!-- start seling -->
            <div class="sales">
               <span class="material-symbols-sharp">trending_up</span>
               <div class="middle">

                 <div class="left">
                   <h3>أجمالي الطلبات</h3>
                   <h1>
                  
                <?php

function queryDays($day) {
   global $conn; // Make sure $conn is accessible inside the function
   $sql_lastDays = $conn->query("SELECT * FROM requests_maintenance WHERE request_time >= DATE_SUB(CURRENT_DATE, INTERVAL {$day} DAY)");

   $no_last_days = mysqli_num_rows($sql_lastDays);
   echo $no_last_days;
}

                 queryDays(30);
               



// $sql_lastmonthe = $conn->query("SELECT * FROM requests_maintenance WHERE request_time >= DATE_SUB(CURRENT_DATE, INTERVAL 30 DAY)");


// $no_last_month = mysqli_num_rows($sql_lastmonthe);
// echo $no_last_month;
?>
                  </h1>
                 </div>
                  <div class="progress">
                      <svg>
                         <circle  r="30" cy="40" cx="40"></circle>
                      </svg>
                      <!-- <div class="number"><p>80%</p></div> -->
                  </div>

               </div>
               <small>آخر 30 يوم</small>
            </div>
           <!-- end seling -->
              <!-- start expenses -->
              <div class="expenses">
              <span class="material-symbols-sharp">trending_up</span>
              <div class="middle">
 
                  <div class="left">
                  <h3>أجمالي الطلبات</h3>
                  <h1><?php  queryDays(7); ?></h1>
                  </div>
                   <div class="progress">
                       <svg>
                          <circle  r="30" cy="40" cx="40"></circle>
                       </svg>
                       <!-- <div class="number"><p>80%</p></div> -->
                   </div>
 
                </div>
                <small>آخر اسبوع</small>
             </div>
            <!-- end seling -->
               <!-- start seling -->
               <div class="income">
               <span class="material-symbols-sharp">trending_up</span>
               <div class="middle">
 
                  <div class="left">
                  <h3>أجمالي الطلبات</h3>
                  <h1><?php  queryDays(1); ?></h1>
                  </div>
                   <div class="progress">
                       <svg>
                          <circle  r="30" cy="40" cx="40"></circle>
                       </svg>
                       <!-- <div class="number"><p>80%</p></div> -->
                   </div>
 
                </div>
                <small>اخر 24 ساعة</small>
             </div>
            <!-- end seling -->

        </div>
       <!-- end insights -->
      
      </section>