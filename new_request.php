
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<?php



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tiltle = trim($_POST['tiltle']);
    $another_title = trim($_POST['another_title']);
    $applicant = trim($_POST['applicant']);
    $contact = trim($_POST['contact']);
    $details = trim($_POST['details']);
    $file_name = '';

    $uploadOk1 = 1;

    if (isset($_FILES['file_txt'])) {
        // Check file size
        if ($_FILES["file_txt"]["size"] > 8000000) { // max file size is 8MB
            $uploadOk1 = 0;
        }

        // Allow certain file formats
        $temp = explode(".", $_FILES["file_txt"]["name"]);
        $fileType = strtolower(end($temp));
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'docx', 'rar'];

        if (!in_array($fileType, $allowedTypes)) {
            $uploadOk1 = 0;
        }

        // Check for upload errors
        if ($_FILES['file_txt']['error'] !== UPLOAD_ERR_OK) {
            $uploadOk1 = 0;
        }

        // Upload file if everything is okay
        if ($uploadOk1 == 1) {
            $uploaddir = "upload/";
            $file_name = microtime(true) . '.' . $fileType;

            if (!move_uploaded_file($_FILES['file_txt']['tmp_name'], $uploaddir . $file_name)) {
                $uploadOk1 = 0; // File upload failed
            }
        }
    }

    // Prepare and bind
    if($school_code) {
        $stmt = $conn->prepare("INSERT INTO requests_maintenance (tiltle,another_title, applicant_school, contact, details, file) VALUES (?,?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $tiltle, $another_title, $school_code, $contact, $details, $file_name);
    } 
    elseif($noSection) {
      $stmt = $conn->prepare("INSERT INTO requests_maintenance (tiltle,another_title, applicant_section, contact, details, file) VALUES (?,?, ?, ?, ?, ?)");
      $stmt->bind_param("ssssss", $tiltle,$another_title, $noSection, $contact, $details, $file_name);
    }


   


        if ($stmt->execute()) {
    //       $new_id_Request = $conn->insert_id;

    //       $stmtStatus = $conn->prepare("INSERT INTO request_status (request_status, no_request) VALUES (?, ?)");
    // $status = "مفتوح"; // Arabic for "Open" (or replace with the desired status in your database)
    // $stmtStatus->bind_param("si", $status, $new_id_Request); // "si" for string and integer types


    // if ($stmtStatus->execute()) {
      echo "<script>
          Swal.fire({
              // title: 'Success!',
              text: 'تم أرسال الطلب بنجاح',
              icon: 'success',
              confirmButtonText: 'حسنا'
          }).then(function() {
              window.location.href = 'main.php';
          });
      </script>";
      exit();
  // }
        
        // else {
        //   echo "Error in request_status: " . $stmtStatus->error;
        // }

        // $stmtStatus->close();
} else {
    echo "Error in requests: " . $stmt->error;
}

// Close the first statement
$stmt->close();
}
?>


<section id="sec-3" class="" style="display: none;">



    <form  action="" method="post" enctype="multipart/form-data" class="mt-16  w-10/12 p-2 rounded-lg" style="background:  rgba(132, 139, 200, 0.18);" >
        <label class="block">
            <span class="block text-sm font-medium text-slate-700 mt-4">عنوان الطلب</span>
            <!-- <input type="text" name="tiltle"  required class="mt-1 block w-full px-3 py-2 bg-white border border-slate-300 rounded-md text-sm shadow-sm placeholder-slate-400
              focus:outline-none focus:border-sky-500 focus:ring-1 focus:ring-sky-500
              disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none
               w-3/4
            "/> -->


              <select  name="tiltle" id="titleRequest"  required class="mt-1 block w-full px-3 py-2 bg-white border border-slate-300 rounded-md text-sm shadow-sm placeholder-slate-400
              focus:outline-none focus:border-sky-500 focus:ring-1 focus:ring-sky-500
              disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none
               w-3/4">
               <option value=""></option>
               <option>أعمال نجارة</option> 
               <option>أعمال سباكة</option> 
               <option>أعمال كهرباء</option> 
               <option value="اخرى">اخرى</option>
          </select>


          <!-- <div id="" class="mb-4 "> -->
            <!-- <label for="" class="block text-gray-700">يرجى تحديد مكان الجهاز</label> -->
            <input type="text" id="otherTitle" required name="another_title"class="hidden mt-1 mb-4 block w-full px-3 py-2 bg-white border border-slate-300 rounded-md text-sm shadow-sm placeholder-slate-400
            focus:outline-none focus:border-sky-500 focus:ring-1 focus:ring-sky-500
            disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none
             w-3/4" placeholder="اذكر هنا عنوان الطلب" />
          <!-- </div> -->
          


          </label>


          <label class="block">
            <span class="block text-sm font-medium text-slate-700 mt-7">جهة الطلب</span>
            <input type="text" name="applicant"   value="<?php echo $nameSchool, $section ?>" readonly class="mt-1 block w-full px-3 py-2 bg-white border border-slate-300 rounded-md text-sm shadow-sm placeholder-slate-400
              focus:outline-none focus:border-sky-500 focus:ring-1 focus:ring-sky-500
              disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none
              invalid:border-pink-500 invalid:text-pink-600
              focus:invalid:border-pink-500 focus:invalid:ring-pink-500 w-3/4
            "/>
          </label>


          
  <label class="block">
            <span class="block text-sm font-medium text-slate-700 mt-7">بيانات التواصل</span>
            <input type="text" name="contact" required  class="mt-1 block w-full px-3 py-2 bg-white border border-slate-300 rounded-md text-sm shadow-sm placeholder-slate-400
              focus:outline-none focus:border-sky-500 focus:ring-1 focus:ring-sky-500
              disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none
               w-3/4
            "/>
          </label>


          
          <label class="block">
            <span class="block text-sm font-medium text-slate-700 mt-7">تفاصيل الطلب </span>
            <textarea rows="8" name="details" required  class="mt-1 block w-full px-3 py-2 bg-white border border-slate-300 rounded-md text-sm shadow-sm placeholder-slate-400
              focus:outline-none focus:border-sky-500 focus:ring-1 focus:ring-sky-500
              disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none
              
               w-3/4
            "></textarea>
          </label>

          <span class="block text-sm font-medium text-slate-700 mt-7">أرفاق صورة توضيحية (إن امكن)</span>
<div class="flex items-center space-x-6">
          <div class="shrink-0">
            <img class="object-cover" src="images/upload.png" alt="Current profile photo" />
          </div>
          <label class="block">
          
            <input type="file" name="file_txt" class="mt-1 block w-full text-sm text-slate-500
              file:mr-4 file:py-2 file:px-4
              file:rounded-full file:border-0
              file:text-sm file:font-semibold
              file:bg-violet-50 file:text-violet-700
              hover:file:bg-violet-100
            "/>
          </label>
        </div>

          <input type="submit" name="submit" class="rounded-md bg-gradient-to-r from-cyan-300 to-cyan-500 hover:from-cyan-700  hover:to-cyan-800  text-center mt-6	p-2 text-white cursor-pointer"   value="تقديم الطلب">

</form>
</section>
<script  type="text/javascript">

$(document).ready(function() {


  $('#titleRequest').on('change', function() { 
      if ($(this).val() === 'اخرى') {
        $('#otherTitle').removeClass('hidden'); // Show the input if 'other' is selected
        $('#otherTitle').attr('required', true);


      } else {
        $('#otherTitle').addClass('hidden'); // Hide the input for other selections
        $('#otherTitle').removeAttr('required');

  
      }
    });
  });
  

</script>

