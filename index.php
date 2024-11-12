


<!DOCTYPE html>
<html lang="en" >

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="assets/styleLogin.css?v=<?php echo time(); ?>">
    <title>تقديم طلب صيانة | تسجيل الدخول</title>
</head>
<style>
   
</style>
<body>

    <div class="container" id="container">
        <div class="form-container sign-up" dir="rtl">
            <form method="post" action="loginAdmin.php">
                <div class="social-icons">
                    <a href="#" class="icon"><img src="images/a.png"></a>

                </div>

                <span>الدخول لموظفي قسم الصيانة</span>
                <input type="text" name="adminUsername" placeholder="اسم المستخدم">
                <input type="password" name="adminPassword" placeholder="الرمز السري">
                <button type="submit" name="loginAdmin">دخول</button>
            </form>
        </div>
        <div class="form-container sign-in" dir="rtl">
            <form id="loginRequest" method="post" action="loginSchool.php">
                <div class="social-icons">
                    <a href="#" class="icon"><img src="images/a.png"></a>

                </div>
                <!-- <h1>قسم الصيانة</h1> -->

                <span>تقديم طلب خدمة صيانة</span>
                <!-- Login Form for School -->
        <div  id="schoolForm">
                <input type="text" placeholder="رمز المدرسة" name="code">
                <input type="text" placeholder="الرقم المدني " name="civil_no">
</div>

<div   id="emplyeeForm" class="hiddenLogin">
    <!-- <input type="text" name="CivilNum" placeholder=""> -->
    <input type="password" name="password" placeholder="الرمز السري">

</div>


                <div class="checkbox-div">
                    <label>
                        <input type="checkbox" checked id="schoolCheck">
                        <span >الدخول للمدرسة</span>
                    </label>
                    <label >
                        <input type="checkbox" id="employeeCheck">
                        <span>الدخول لاقسام المديرية</span>
                    </label>
                </div>

                <button type="submit" name="loginSchool">دخول</button>
            </form>
        </div>
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                <h1>قسم الصيانة</h1>
                <p>رابط تقديم طلب صيانة ومتابعة حالات الطلب </p>
                    <button class="hidden" id="login">تقديم طلب</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>قسم الصيانة</h1>
                    <p>رابط تقديم طلب صيانة ومتابعة حالات الطلب </p>
                    <button class="hidden" id="register">مسئول النظام</button>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/scriptLogin.js?v=<?php echo time(); ?>"></script>
</body>

</html>


<script>
    const schoolForm = document.getElementById('schoolForm');
    const emplyeeForm = document.getElementById('emplyeeForm');
    const schoolCheck = document.getElementById('schoolCheck');
    const employeeCheck = document.getElementById('employeeCheck');

    const loginForm = document.getElementById('loginRequest'); 


    // Event listeners to toggle forms
    schoolCheck.addEventListener('change', () => { 
        if (schoolCheck.checked) {
            employeeCheck.checked = false; // Uncheck admin checkbox
            schoolForm.classList.remove('hiddenLogin');
            emplyeeForm.classList.add('hiddenLogin');
            loginForm.action = "loginSchool.php"; 

        } else {
            schoolForm.classList.add('hiddenLogin');
            loginForm.action = ""; // Clear the action if unchecked
        }
    });

    employeeCheck.addEventListener('change', () => {
        if (employeeCheck.checked) {
            schoolCheck.checked = false; // Uncheck school checkbox
            emplyeeForm.classList.remove('hiddenLogin');
            schoolForm.classList.add('hiddenLogin');
            loginForm.action = "loginSection.php"; // Set form action to loginEmployee.php

        } else {
            emplyeeForm.classList.add('hiddenLogin');
            loginForm.action = ""; // Clear the action if unchecked

        }
    });
</script>