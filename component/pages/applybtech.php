<?php 
  session_start();

  // variable declaration
  $username = "";
  $email = "";
  $matricule = "";
  $errors = array();
  // $_SESSION['loggedin'] = TRUE;

  // connect to database
  $db = mysqli_connect('localhost', 'root', '', 'admission');

  // REGISTER USER
  if (isset($_POST['reg_user'])) {
    $level = "";
   
    // receive all input values from the form
    $fname = mysqli_real_escape_string($db, $_POST['firstname']);
    $lname = mysqli_real_escape_string($db, $_POST['lastname']);
    $gender = mysqli_real_escape_string($db, $_POST['gender']);
    $pob = mysqli_real_escape_string($db, $_POST['pob']);
    $dob = mysqli_real_escape_string($db, $_POST['dob']);
    $nation = mysqli_real_escape_string($db, $_POST['nation']);
    $dept = mysqli_real_escape_string($db, $_POST['dept']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $tel = mysqli_real_escape_string($db, $_POST['number']);
    $gname = mysqli_real_escape_string($db, $_POST['gname']);
    $gnumber = mysqli_real_escape_string($db, $_POST['gnumber']);
    $password = mysqli_real_escape_string($db, $_POST['password']);
    $repassword = mysqli_real_escape_string($db, $_POST['repassword']);
    $level = "B-TECH";

    if (isset($_FILES['olevel']) && isset($_FILES['alevel']) && isset($_FILES['photo']) && isset($_FILES['nic']) && isset($_FILES['birthcert'])) {
        $target_dir = "uploads/";
        $target_file1 = $target_dir . basename($_FILES["olevel"]["name"]);
        $target_file2 = $target_dir . basename($_FILES["alevel"]["name"]);
        $target_file3 = $target_dir . basename($_FILES["photo"]["name"]);
        $target_file4 = $target_dir . basename($_FILES["nic"]["name"]);
        $target_file5 = $target_dir . basename($_FILES["birthcert"]["name"]);
    
        $imageFileType1 = strtolower(pathinfo($target_file1,PATHINFO_EXTENSION));
        $imageFileType2 = strtolower(pathinfo($target_file2,PATHINFO_EXTENSION));
        $imageFileType3 = strtolower(pathinfo($target_file3,PATHINFO_EXTENSION));
        $imageFileType4 = strtolower(pathinfo($target_file4,PATHINFO_EXTENSION));
        $imageFileType5 = strtolower(pathinfo($target_file5,PATHINFO_EXTENSION));

         if (move_uploaded_file($_FILES["olevel"]["tmp_name"],$target_file1) && move_uploaded_file($_FILES["alevel"]["tmp_name"],$target_file2) && move_uploaded_file($_FILES["photo"]["tmp_name"],$target_file3) && move_uploaded_file($_FILES["nic"]["tmp_name"],$target_file4) && move_uploaded_file($_FILES["birthcert"]["tmp_name"],$target_file5)) {
            echo "<script>
            alert('SUCCESFULL!');
          </script>";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
           
    }


    if ($password != $repassword) {
      array_push($errors, "The two passwords do not match");
    }

    // register user if there are no errors in the form
    if ($password == $repassword) {
      $password = sha1($repassword);//encrypt the password before saving
       
      $query = "
      INSERT INTO `student`(`firstname`,`laststname`,`departement`,level,`gender`,`dob`,`pob`,`nationality`,`email`,`tel`,`gname`,`gtel`,`password`,`olevel`,`alevel`,`photo`,`nic`,`birthcert`) 
        VALUES (
        '$fname', '$lname', '$dept','$level', '$gender', '$dob', '$pob', '$nation', '$email', '$tel', '$gname', '$gnumber', '$password','$target_file1','$target_file2','$target_file3','$target_file4','$target_file5')";
      mysqli_query($db, $query);

      $_SESSION['name'] = $fname;
      $_SESSION['email'] = $email;
      // $_SESSION['matricule'] = $matricule;
      header('location: payment.php');

    }else{
      echo " 
      <script>
        alert('The two passwords do not match!');
      </script>";
    }

  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>ADMISSION</title>
  <link rel="icon" href="../../resources/logo.png">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../fa/css/all.min.css">
  <!-- Bootstrap core CSS -->
  <link href="../css/bootstrap.min.css" rel="stylesheet">
  <!-- Material Design Bootstrap -->
  <link href="../css/mdb.min.css" rel="stylesheet">
  <!-- Your custom styles (optional) -->
  <link href="../css/style.css" rel="stylesheet">
</head>

<body>
<nav class="navbar navbar-custom">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="glyphicon glyphicon-menu-hamburger"></span>                        
      </button>
      <a class="logo navbar-brand" href="../../index.php">
        <div class="col-sm-1 ">
          <img class="img-responsive main_logo" src="../../resources/logo.png">
        </div>
        <div class="col-sm-4">
          <b>HIBMAT</b>
        </div>
      </a>
    </div>
  </div></nav>
  
<div class="container-fluid"> 
  <form action="applybtech.php" method="POST" enctype="multipart/form-data" class="form-content">
    <h1 id="step">
      <span class="label label-info">APPLY FOR B-TECH</span>
    </h1>

    <!-- step1 -->
    <table id="step1" class="table">
      <thead>
        <tr>
          <th>Department</th>
        </tr>
        <tr>
          <th>
            <select class="form-control" name="dept">
              <option value="insurance">INSURANCE</option>
              <option value="technology and electrical eng">TECHNOLOGY ELECTRICAL AND ELECTRONICS ENGINEERING</option>
              <option value="HPD">HIGHER PROFESSIONAL DIPLOMA HUMAN RESOURCE MANAGEMENT</option>
              <option value="CCE">COMPUTER AND COMMUNICATIONS ENGINEERING</option>
            </select>
          </th>
        </tr>
        <tr>
          <th>Firstname</th>
          <th>Lastname</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><input required type="text" class="form-control" name="firstname"></td>
          <td><input required type="text" class="form-control" name="lastname"></td>
        </tr>
        <tr>
          <th>Date of birth</th>
          <th>Gender</th>
        </tr>
        <tr>
          <td><input required type="date" class="form-control" name="dob"></td>
          <td>
            <span><label class="radio-inline">
              <input required type="radio" name="gender" value="male">male</label></span>
            <span><label class="radio-inline">
              <input required type="radio" name="gender" value="female">Female</label></span>
            <span><label class="radio-inline">
              <input required type="radio" name="gender" value="other">other</label> </span>
              
          </td>
        </tr>
        <tr>
          <th>Place of birth</th>
          <th>Nationality</th>
        </tr>
        <tr>
          <td><input required type="text" class="form-control" name="pob"></td>
          <td>
            <select class="form-control" name="nation">
              <option value="Afganistan">Afghanistan</option>
              <option value="Albania">Albania</option>
              <option value="Algeria">Algeria</option>
              <option value="American Samoa">American Samoa</option>
              <option value="Andorra">Andorra</option>
              <option value="Angola">Angola</option>
              <option value="Anguilla">Anguilla</option>
              <option value="Antigua & Barbuda">Antigua & Barbuda</option>
              <option value="Argentina">Argentina</option>
              <option value="Armenia">Armenia</option>
              <option value="Aruba">Aruba</option>
              <option value="Australia">Australia</option>
              <option value="Austria">Austria</option>
              <option value="Azerbaijan">Azerbaijan</option>
              <option value="Bahamas">Bahamas</option>
              <option value="Bahrain">Bahrain</option>
              <option value="Bangladesh">Bangladesh</option>
              <option value="Barbados">Barbados</option>
              <option value="Belarus">Belarus</option>
              <option value="Belgium">Belgium</option>
              <option value="Belize">Belize</option>
              <option value="Benin">Benin</option>
              <option value="Bermuda">Bermuda</option>
              <option value="Bhutan">Bhutan</option>
              <option value="Bolivia">Bolivia</option>
              <option value="Bonaire">Bonaire</option>
              <option value="Bosnia & Herzegovina">Bosnia & Herzegovina</option>
              <option value="Botswana">Botswana</option>
              <option value="Brazil">Brazil</option>
              <option value="British Indian Ocean Ter">British Indian Ocean Ter</option>
              <option value="Brunei">Brunei</option>
              <option value="Bulgaria">Bulgaria</option>
              <option value="Burkina Faso">Burkina Faso</option>
              <option value="Burundi">Burundi</option>
              <option value="Cambodia">Cambodia</option>
              <option value="Cameroon">Cameroon</option>
              <option value="Canada">Canada</option>
              <option value="Canary Islands">Canary Islands</option>
              <option value="Cape Verde">Cape Verde</option>
              <option value="Cayman Islands">Cayman Islands</option>
              <option value="Central African Republic">Central African Republic</option>
              <option value="Chad">Chad</option>
              <option value="Channel Islands">Channel Islands</option>
              <option value="Chile">Chile</option>
              <option value="China">China</option>
              <option value="Christmas Island">Christmas Island</option>
              <option value="Cocos Island">Cocos Island</option>
              <option value="Colombia">Colombia</option>
              <option value="Comoros">Comoros</option>
              <option value="Congo">Congo</option>
              <option value="Cook Islands">Cook Islands</option>
              <option value="Costa Rica">Costa Rica</option>
              <option value="Cote DIvoire">Cote DIvoire</option>
              <option value="Croatia">Croatia</option>
              <option value="Cuba">Cuba</option>
              <option value="Curaco">Curacao</option>
              <option value="Cyprus">Cyprus</option>
              <option value="Czech Republic">Czech Republic</option>
              <option value="Denmark">Denmark</option>
              <option value="Djibouti">Djibouti</option>
              <option value="Dominica">Dominica</option>
              <option value="Dominican Republic">Dominican Republic</option>
              <option value="East Timor">East Timor</option>
              <option value="Ecuador">Ecuador</option>
              <option value="Egypt">Egypt</option>
              <option value="El Salvador">El Salvador</option>
              <option value="Equatorial Guinea">Equatorial Guinea</option>
              <option value="Eritrea">Eritrea</option>
              <option value="Estonia">Estonia</option>
              <option value="Ethiopia">Ethiopia</option>
              <option value="Falkland Islands">Falkland Islands</option>
              <option value="Faroe Islands">Faroe Islands</option>
              <option value="Fiji">Fiji</option>
              <option value="Finland">Finland</option>
              <option value="France">France</option>
              <option value="French Guiana">French Guiana</option>
              <option value="French Polynesia">French Polynesia</option>
              <option value="French Southern Ter">French Southern Ter</option>
              <option value="Gabon">Gabon</option>
              <option value="Gambia">Gambia</option>
              <option value="Georgia">Georgia</option>
              <option value="Germany">Germany</option>
              <option value="Ghana">Ghana</option>
              <option value="Gibraltar">Gibraltar</option>
              <option value="Great Britain">Great Britain</option>
              <option value="Greece">Greece</option>
              <option value="Greenland">Greenland</option>
              <option value="Grenada">Grenada</option>
              <option value="Guadeloupe">Guadeloupe</option>
              <option value="Guam">Guam</option>
              <option value="Guatemala">Guatemala</option>
              <option value="Guinea">Guinea</option>
              <option value="Guyana">Guyana</option>
              <option value="Haiti">Haiti</option>
              <option value="Hawaii">Hawaii</option>
              <option value="Honduras">Honduras</option>
              <option value="Hong Kong">Hong Kong</option>
              <option value="Hungary">Hungary</option>
              <option value="Iceland">Iceland</option>
              <option value="Indonesia">Indonesia</option>
              <option value="India">India</option>
              <option value="Iran">Iran</option>
              <option value="Iraq">Iraq</option>
              <option value="Ireland">Ireland</option>
              <option value="Isle of Man">Isle of Man</option>
              <option value="Israel">Israel</option>
              <option value="Italy">Italy</option>
              <option value="Jamaica">Jamaica</option>
              <option value="Japan">Japan</option>
              <option value="Jordan">Jordan</option>
              <option value="Kazakhstan">Kazakhstan</option>
              <option value="Kenya">Kenya</option>
              <option value="Kiribati">Kiribati</option>
              <option value="Korea North">Korea North</option>
              <option value="Korea Sout">Korea South</option>
              <option value="Kuwait">Kuwait</option>
              <option value="Kyrgyzstan">Kyrgyzstan</option>
              <option value="Laos">Laos</option>
              <option value="Latvia">Latvia</option>
              <option value="Lebanon">Lebanon</option>
              <option value="Lesotho">Lesotho</option>
              <option value="Liberia">Liberia</option>
              <option value="Libya">Libya</option>
              <option value="Liechtenstein">Liechtenstein</option>
              <option value="Lithuania">Lithuania</option>
              <option value="Luxembourg">Luxembourg</option>
              <option value="Macau">Macau</option>
              <option value="Macedonia">Macedonia</option>
              <option value="Madagascar">Madagascar</option>
              <option value="Malaysia">Malaysia</option>
              <option value="Malawi">Malawi</option>
              <option value="Maldives">Maldives</option>
              <option value="Mali">Mali</option>
              <option value="Malta">Malta</option>
              <option value="Marshall Islands">Marshall Islands</option>
              <option value="Martinique">Martinique</option>
              <option value="Mauritania">Mauritania</option>
              <option value="Mauritius">Mauritius</option>
              <option value="Mayotte">Mayotte</option>
              <option value="Mexico">Mexico</option>
              <option value="Midway Islands">Midway Islands</option>
              <option value="Moldova">Moldova</option>
              <option value="Monaco">Monaco</option>
              <option value="Mongolia">Mongolia</option>
              <option value="Montserrat">Montserrat</option>
              <option value="Morocco">Morocco</option>
              <option value="Mozambique">Mozambique</option>
              <option value="Myanmar">Myanmar</option>
              <option value="Nambia">Nambia</option>
              <option value="Nauru">Nauru</option>
              <option value="Nepal">Nepal</option>
              <option value="Netherland Antilles">Netherland Antilles</option>
              <option value="Netherlands">Netherlands (Holland, Europe)</option>
              <option value="Nevis">Nevis</option>
              <option value="New Caledonia">New Caledonia</option>
              <option value="New Zealand">New Zealand</option>
              <option value="Nicaragua">Nicaragua</option>
              <option value="Niger">Niger</option>
              <option value="Nigeria">Nigeria</option>
              <option value="Niue">Niue</option>
              <option value="Norfolk Island">Norfolk Island</option>
              <option value="Norway">Norway</option>
              <option value="Oman">Oman</option>
              <option value="Pakistan">Pakistan</option>
              <option value="Palau Island">Palau Island</option>
              <option value="Palestine">Palestine</option>
              <option value="Panama">Panama</option>
              <option value="Papua New Guinea">Papua New Guinea</option>
              <option value="Paraguay">Paraguay</option>
              <option value="Peru">Peru</option>
              <option value="Phillipines">Philippines</option>
              <option value="Pitcairn Island">Pitcairn Island</option>
              <option value="Poland">Poland</option>
              <option value="Portugal">Portugal</option>
              <option value="Puerto Rico">Puerto Rico</option>
              <option value="Qatar">Qatar</option>
              <option value="Republic of Montenegro">Republic of Montenegro</option>
              <option value="Republic of Serbia">Republic of Serbia</option>
              <option value="Reunion">Reunion</option>
              <option value="Romania">Romania</option>
              <option value="Russia">Russia</option>
              <option value="Rwanda">Rwanda</option>
              <option value="St Barthelemy">St Barthelemy</option>
              <option value="St Eustatius">St Eustatius</option>
              <option value="St Helena">St Helena</option>
              <option value="St Kitts-Nevis">St Kitts-Nevis</option>
              <option value="St Lucia">St Lucia</option>
              <option value="St Maarten">St Maarten</option>
              <option value="St Pierre & Miquelon">St Pierre & Miquelon</option>
              <option value="St Vincent & Grenadines">St Vincent & Grenadines</option>
              <option value="Saipan">Saipan</option>
              <option value="Samoa">Samoa</option>
              <option value="Samoa American">Samoa American</option>
              <option value="San Marino">San Marino</option>
              <option value="Sao Tome & Principe">Sao Tome & Principe</option>
              <option value="Saudi Arabia">Saudi Arabia</option>
              <option value="Senegal">Senegal</option>
              <option value="Seychelles">Seychelles</option>
              <option value="Sierra Leone">Sierra Leone</option>
              <option value="Singapore">Singapore</option>
              <option value="Slovakia">Slovakia</option>
              <option value="Slovenia">Slovenia</option>
              <option value="Solomon Islands">Solomon Islands</option>
              <option value="Somalia">Somalia</option>
              <option value="South Africa">South Africa</option>
              <option value="Spain">Spain</option>
              <option value="Sri Lanka">Sri Lanka</option>
              <option value="Sudan">Sudan</option>
              <option value="Suriname">Suriname</option>
              <option value="Swaziland">Swaziland</option>
              <option value="Sweden">Sweden</option>
              <option value="Switzerland">Switzerland</option>
              <option value="Syria">Syria</option>
              <option value="Tahiti">Tahiti</option>
              <option value="Taiwan">Taiwan</option>
              <option value="Tajikistan">Tajikistan</option>
              <option value="Tanzania">Tanzania</option>
              <option value="Thailand">Thailand</option>
              <option value="Togo">Togo</option>
              <option value="Tokelau">Tokelau</option>
              <option value="Tonga">Tonga</option>
              <option value="Trinidad & Tobago">Trinidad & Tobago</option>
              <option value="Tunisia">Tunisia</option>
              <option value="Turkey">Turkey</option>
              <option value="Turkmenistan">Turkmenistan</option>
              <option value="Turks & Caicos Is">Turks & Caicos Is</option>
              <option value="Tuvalu">Tuvalu</option>
              <option value="Uganda">Uganda</option>
              <option value="United Kingdom">United Kingdom</option>
              <option value="Ukraine">Ukraine</option>
              <option value="United Arab Erimates">United Arab Emirates</option>
              <option value="United States of America">United States of America</option>
              <option value="Uraguay">Uruguay</option>
              <option value="Uzbekistan">Uzbekistan</option>
              <option value="Vanuatu">Vanuatu</option>
              <option value="Vatican City State">Vatican City State</option>
              <option value="Venezuela">Venezuela</option>
              <option value="Vietnam">Vietnam</option>
              <option value="Virgin Islands (Brit)">Virgin Islands (Brit)</option>
              <option value="Virgin Islands (USA)">Virgin Islands (USA)</option>
              <option value="Wake Island">Wake Island</option>
              <option value="Wallis & Futana Is">Wallis & Futana Is</option>
              <option value="Yemen">Yemen</option>
              <option value="Zaire">Zaire</option>
              <option value="Zambia">Zambia</option>
              <option value="Zimbabwe">Zimbabwe</option>
            </select>
          </td>
        </tr>
      </tbody>
    </table>


    <!-- step2 -->
    <table id="step2" class="table">
      <thead>
        <tr>
          <th>email</th>
          <th>Phone Number</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><input required type="email" class="form-control" name="email"></td>
          <td><input required type="number" class="form-control" name="number"></td>
        </tr>
        <tr>
          <th>Guidian Name</th>
          <th>Guidian Phone Number</th>
        </tr>
        <tr>
          <td><input required type="text" class="form-control" name="gname"></td>
          <td><input required type="number" class="form-control" name="gnumber"></td>
        </tr>
        <tr>
          <th>Password</th>
          <th>Re:password</th>
        </tr>
        <tr>
          <td><input required type="password" class="form-control" name="password"></td>
          <td><input required type="password" class="form-control" name="repassword"></td>
        </tr>
      </tbody>
    </table>


    <!-- step3 -->
    <table id="step3" class="table">
      <thead>
        <tr>
          <th>O-Level</th>
          <th>A-Level</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><input required type="file" class="form-control" name="olevel"></td>
          <td><input required type="file" class="form-control" name="alevel"></td>
        </tr>
        <tr>
          <th>National ID Card</th>
          <th>Birth Certificate</th>
        </tr>
        <tr>
          <td><input required type="file" class="form-control" name="nic"></td>
          <td><input required type="file" class="form-control" name="birthcert"></td>
        </tr>
        <tr>
          <th>4x4 photo</th>
        </tr>
        <tr>
          <td><input required type="file" class="form-control" name="photo"></td>
        </tr>
      </tbody>
    </table>

    <button type="submit" name="reg_user" class="form-group btn btn-default btn-lg">Submit</button>
    <button type="reset"  class="btn btn-danger btn-lg">Cancel</button>
  </form>
  
</div><br>

<footer class="container-fluid text-center">
  <p>HIBMAT©2019</p>
</footer>

</body>
  <script type="text/javascript" src="../js/jquery-3.4.1.min.js"></script>
  <!-- Bootstrap tooltips -->
  <script type="text/javascript" src="../js/popper.min.js"></script>
  <!-- Bootstrap core JavaScript -->
  <script type="text/javascript" src="../js/bootstrap.min.js"></script>
  <!-- MDB core JavaScript -->
  <script type="text/javascript" src="../js/mdb.min.js"></script>
  <script src="../js/main.js"></script>
  
  <script src="../fa/js/all.min.js"></script>
</html>
