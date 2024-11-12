<?php
include 'conn.php';
session_start(); // Start or resume the session

// Check if the user is logged in
if (!isset($_SESSION['logged_in']) && !isset($_SESSION['logged_section'])  && !isset($_SESSION['logged_admin'])) {
    // Redirect to login page if not logged in
    header("Location: index.php");
    exit();
}
//Schools Login
$school_code = isset($_SESSION['school_code']) ? $_SESSION['school_code'] : null;
$nameSchool = isset($_SESSION['nameSchool']) ? $_SESSION['nameSchool'] : null;

//Section Login
$section = isset($_SESSION['section']) ? $_SESSION['section'] : null;
$noSection = isset($_SESSION['noSection']) ? $_SESSION['noSection'] : null;


//Admin Login
$requesterNone =  (isset($_SESSION['logged_in']) || isset($_SESSION['logged_section'])? 'style="display:none;"' : '');
$adminLogin =isset($_SESSION['logged_admin']) ? $_SESSION['logged_admin'] : null;
$adminNone =  (isset($_SESSION['logged_admin']) ? 'style="display:none;"' : '');
$nameAdmin = isset($_SESSION['nameAdmin']) ? $_SESSION['nameAdmin'] : null;

$tecnicalNone = (isset($_SESSION['role']) && $_SESSION['role'] == "technical") ? 'style="display:none;"' : null;



?>


<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>قسم الصيانة | تقديم طلب صيانة</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Sharp:opsz,wght,FILL,GRAD@48,400,0,0" />
  <link rel="stylesheet" href="assets/style.css?v=<?php echo time(); ?>">
  <script src="https://cdn.tailwindcss.com"></script>


  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

  </head>
<body>
   <div class="container">
      <aside>
           
         <div class="top">
           <div class="logo">
             <!-- <h2>C <span class="danger">BABAR</span> </h2> -->
              <img src="images/a.png" alt="">
           </div>
           <div class="close" id="close_btn">
            <span class="material-symbols-sharp">
              close
              </span>
           </div>
         </div>
         <!-- end top -->
          <div class="sidebar">

          <a href="#" class="active" onclick="toggleSection('sec-1', this)" <?php echo $requesterNone;  ?>>
  <span class="material-symbols-sharp">grid_view</span>
  <h3>الرئيسية</h3>
</a>

<a href="#" onclick="toggleSection('sec-2', this)">
  <span class="material-symbols-sharp">mail_outline</span>
  <h3>الطلبات</h3>
  <!-- <span class="msg_count">14</span> -->
</a>

<a href="#" onclick="toggleSection('sec-3', this)" <?php echo $adminNone;  ?>>
  <span class="material-symbols-sharp">add</span>
  <h3>ارسال طلب</h3>
</a>

<!-- <a href="#" onclick="toggleSection('sec-4', this)">
  <span class="material-symbols-sharp">person_outline</span>
  <h3>الطلبات</h3>
</a> -->

<a href="logout.php">
  <span class="material-symbols-sharp">logout</span>
  <h3>خروج</h3>
</a>
             


          </div>

      </aside>
      <!-- --------------
        end asid
      -------------------- -->

      <!-- --------------
        start main part
      --------------- -->

      <main>

   
      <?php
      if($adminLogin) {
include 'home.php';
      }
      ?>

<?php
include 'list.php';
      ?>

      <?php
include 'new_request.php';
      ?>

<!-- <div id="resultDetailesReque">
</div> -->

      </main>
      <!------------------
         end main
        ------------------->

      <!----------------
        start right main 
      ---------------------->
    <div class="right">

<div class="top">
   <button id="menu_bar">
     <span class="material-symbols-sharp">menu</span>
   </button>

   <div class="theme-toggler">
     <span class="material-symbols-sharp active">light_mode</span>
     <span class="material-symbols-sharp">dark_mode</span>
   </div>
    <div class="profile">
       <div class="info">
           <p><b><?php echo $nameSchool, $section,$nameAdmin;?></b></p>
           <p><?php echo $school_code;  ?></p>
           <small class="text-muted"></small>
       </div>
      
    </div>
</div>

  
</div>


   </div>



   <script src="assets/script.js?v=<?php echo time(); ?>"></script>
</body>
</html>

