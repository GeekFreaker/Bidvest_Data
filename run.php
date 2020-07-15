<?php

//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------"'
//                                    .///.....---#---#-                                                                                                                                                 ".
//                                 (   ,/(#           #-(                                                                                                                                                ".
//                               ./,,,*(((              #                                                                                                                                                ".
//                           .#   (((((                  #                                                                                                                                               ".
//                        (                              #                                                                                                                                               ".
//                     (                                #                                                                                                                                                ".
//                  #                                  #                                                                                                                                                 ".
//                (                                   #                                                                                                                                                  ".
//             #                    @@@@@@@@@@@@@@@ #    @@@@             (@@@@                                                                @@@@@@@@@@@@@@                                            ".
//           (                      @@@@@@@@@@@@@@@@    @@@@              @@@@/                                                  #@@@#          @@@@@@@@@@@@@@@                     @@@@                 ".
//         #                       @@@@,        @@@@             @@@@@@ %@@@@/  @@@@      @@@@@    @@@@@@@@       .@@@@@@@@    @@@@@@@@@,       @@@@        @@@@,    @@@@@@@@@\   @@@@@@@@@   @@@@@@@@\  ".
//       #                         @@@@@@@@@@@@@@@     @@@@    @@@@@@@@@@@@@@    @@@@    @@@@   @@@@@. @@@@@@   @@@@.   @@@@@ ..@@@@(..        @@@@         @@@@   @@@@@  @@@@@  ..@@@@..   @@@@  @@@@@  ".
//      #                         @@@@@@@@@@@@@@@@    @@@@   @@@@      @@@@@    @@@@   @@@@   @@@@      @@@@  @@@@@@@          @@@@           @@@@        @@@@@          @@@@@   @@@@             @@@@   ".
//    (                           @@@@        @@@@@  @@@@   @@@@       @@@@     @@@@  @@@&   @@@@@@@@@@@@@@@   *@@@@@@@@@@    @@@@           @@@@        *@@@@   @@@@@@@@@@@@#  @@@@     @@@@@@@@@@@@    ".
//   #                           @@@@        @@@@@  @@@@   @@@@      @@@@#     @@@@&@@@     @@@@            @@@@     @@@@@   @@@@           @@@@       @@@@@   #@@@@    @@@@   @@@@     @@@@     @@@     ".
//  #                           @@@@@@@@@@@@@@@@,  @@@@    @@@@@@@@@@@@@@       @@@@@@      @@@@@@@@@@@@.   @@@@@@@@@@@@@   @@@@@@@       @@@@@@@@@@@@@@@@    @@@@@@@@@@@@/   @@@@@@   @@@@@@@@@@@@      ".
// /                           \@ @@@@@@@@@@@@@    @@@@     @@@@@@@@ @@@\        @@@@         @@&@@@@&         *@@@@@@      \@@@@&       @@@@  @@@@@@@@@       \@@@@@@  @@@/   \@@@@/   &@&&@@  @@@/     ".
// #                                #/                                                                                                                                                                   ".
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------"'
// #                            #/   /        (,  #  #             #                                 #                                                     #                #  #                         ".
//  /         ,,,,,          (#_##  #   #  #  (,  #  #       #  #  #,  #  #  #(  (  #*  (  #   (  #  #      (,  #  (  #  ##  #  #  #(  #  #   #  (  ##  #  #  /#  #  #  #   #  #  (#  #  ##  #  #  ##    ".
//   #.      ..  .,//    # #/(#  #  .(  #  #  (,  #  #      #      #   #  #  ,(  #   #  #  (. #      #      (     #    # #   #  #. #   #  */  #  #  #   #  #  #     .#  #   #  #  #   (, #   #     #(    ".
//     ------*,,,*//___-- # #####*.# *  .*  .#**  *.  (/ *    ****##   *   *  *#. #  *   *  *  *.   ##   *       *#*    ##   *   *  *  *   *  ,,  ,#**  *   *  *    #*   *#  (  /( *    ##   *   *   (#* ";
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------"'

//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------"'
// Company : BidVest Data Assessment
// Name    : LGM Matabane
// Date    : 2020-07
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------"'

//-- 1. Get the params parsed in from the cli.
$params = getopt(null,["action:","id:"]);

//-- 2. scan all the records that exist and use them for reference
$students = scan_students();

//-- 3. Now go ahead and capture the required values from the array.
$action = !empty($params["action"])  ? $params["action"]:"";
$id = array_key_exists("id",$params) ? $params["id"]: "";

//-- 4. Then ensure you handle the errors accordingly.
 switch ($action) {
   case 'add'   : add(); break;
   case 'edit'  : edit($id); break;
   case 'delete': delete($id); break;
   case 'search': search(); break;
   case 'help'  : echo help(); break;
   default      : echo def($params); break;
 };

 /**
 * default function (wrong parameters)
 *
 * @return String
 *
 **/
 function def($param)
 {
  //a. a default function incase anything was called unexpectedly
  return "\033[91m" .print_r($param). "InputError: \033[0m ".
         "\033[31mI require atleast a single paramater. \033[0m ".
         "add the correct parameter --action=help \n";
 }



 /**
 * default function (error_handling)
 *
 * @return String
 *
 **/
 function err($message)
 {
   return print "\033[91mInputError: \033[0m\033[31m" .$message. ". \033[0m \n";
 }



 /**
 * Remove a student record from the file
 *
 * @return String
 *
 **/
 function help()
 {
  return
    "\n -------------------------------------------------------------------------\n".
    " ----            ~ BidVest Data : Assessment Commands ~            -------\n".
    " -------------------------------------------------------------------------\n\n".
    " All comamnds begin with '\e[1m\033[92mphp run.php\033[0m'\e[0m\n".
    " Then append of the folling options: \n".
    " -------------------------------------------------------------------------\n".
    "\n\n".
    " 1. \e[1m --action=\033[34madd                 \033[0m \e[0m   : \e[3mThis allows you to add a record.\e[0m \n\n".
    " 2. \e[1m --action=\033[33medit  \033[0m \e[1m--id=<vaild_id>\e[0m \e[0m : \e[3mEdit a student record.\e[0m \n\n".
    "                                        (leave filed blank to keep previous value)\n\n".
    " 3. \e[1m --action=\033[91mdelete\033[0m \e[1m--id=<vaild_id>\e[0m \e[0m : \e[3mDelete a student record (remove file only).\e[0m \n\n".
    " 4. \e[1m --action=\033[36msearch              \033[0m \e[0m   : \e[3mSearch for a student record. \e[0m \n\n".
    " -------------------------------------------------------------------------\n\n".
    " Where \e[1m<valid_id>\e[0m must be an 8-digit number.\n\n".
    " -------------------------------------------------------------------------\n";
 }



 /**
 * Remove a student record from the file
 *
 * @return String
 *
 **/
 function add()
 {
    //-- 1. create a student record.(Number must be seven chars)
    $student = new stdClass();
    echo "\n Enter id:";
    $student->student_id = trim(fgets(STDIN));
    $exists = 0;
    foreach ($students as $Student => $id) {
      if($student->student_id == $id)
      {
        $exists = 1;
      }
    };

    if( $exists == 0 && is_numeric($student->student_id) && strlen((string)$student->student_id)>7)
    {
      echo " Enter name:";
      $student->name = trim(fgets(STDIN));
      echo " Enter surname:";
      $student->surname = trim(fgets(STDIN));
      echo " Enter age:";
      $student->age = trim(fgets(STDIN));
      echo " Enter curriculum:";
      $student->curriculum = trim(fgets(STDIN));
      $content = json_encode($student);

      $dir = "students/".substr($student->student_id,0,2);
      mkdir($dir,0777,true);
      $record = fopen($_SERVER['DOCUMENT_ROOT'] . $dir ."/". $student->student_id. ".json","wb");
      if (!$record) {
        err("file already exists");
      }

      fwrite($record,$content);
      fclose($record);

      echo "\n \033[32m A student(".$student->student_id.") was just created succesfully in!!\033[0m";
    } else {
      if($exists == 1)
        err("A Student Id number\033[0m already exists.");
      elseif (!is_numeric($student->student_id))
        err("This Student Id number\033[0m isn't a number.");
      else
        err("A Student Id number\033[0m must have more than 7 numeric characters");

    }
  }



 /**
 * Edit a student record in the file (green return text)
 *
 * @return null
 *
 **/
 function edit($id)
 {
    // a. find the student record in question
    $dir = "students/".substr($id,0,2);
    $student_arr = file( $dir ."/". $id. ".json");
    $previous_student_arr = $student_arr;
    $previous_student_arr = json_decode($previous_student_arr[0]);
    $student_arr = json_decode($student_arr[0]);

    $keep = "";
    echo " [".$student_arr->name."] Enter name:";
    $keep = fgetc(STDIN);
    if($keep!="\n") {
      $student_arr->name = trim(fgets(STDIN));
    }

    echo " [".$student_arr->surname."] Enter surname:";
    $keep = fgetc(STDIN);
    if($keep!="\n") {
      $student_arr->name = trim(fgets(STDIN));
    }

    echo " [".$student_arr->age."] Enter age:";
    $keep = fgetc(STDIN);
    if($keep!="\n") {
      $student_arr->age = trim(fgets(STDIN));
    }

    echo " [".$student_arr->curriculum."] Enter curriculum:";
    $keep = fgetc(STDIN);
    if($keep!="\n") {
      $student_arr->curriculum = trim(fgets(STDIN));
    }

    $dir = "students/".substr($student_arr->student_id,0,2);
    print_r($student_arr);
    $record = fopen($_SERVER['DOCUMENT_ROOT'] . $dir ."/". $student_arr->student_id . ".json","wb");
    fwrite($record,json_encode($student_arr,true));
    fclose($record);

    print_r($previous_student_arr);
    if($previous_student_arr==$student_arr){
    echo "\33[34m Editing of student (" .$student_arr->student_id. ") succesful. \33[0m";
    } else {
    echo "This student didn't change anything.";
   }
  }



 /**
 * Remove a student record from the file (red return text)
 *
 * @return String
 *
 **/
 function delete($id)
 {
    // a. first find the file in question.
    $search_val = find_by_val("student_id",$id);
    $dir = "students/".substr($id,0,2);
    $delete_location = $_SERVER['DOCUMENT_ROOT'] . $dir ."/". $id. ".json";

    // b. remove the file not the folder

    if (!unlink($delete_location)) {
      err("$delete_location \00[0m cannot be deleted due to an error");
    }
    else {
      err("$delete_location \33[0m has been deleted");
    }

    // c. if a folder is empty then it must be removed
    if (is_dir_empty($dir)) {
      rmdir($_SERVER['DOCUMENT_ROOT'] . $dir ."/");
    }

    if(!empty($search_val))
      echo "\33[34m Your Student \33[34m  has been deleted \33[34m succesfully. \33[0m";
    else
      err("Value non-existent \33[34m Are you sure these are the correct search values? Please try again. ");
  }



 /**
 * Search if a Student Record Exist output that it does if it does.
 * If it doesn't exist let the user know (blue return text)
 *
 * @return String
 *
 **/
 function search()
 {
  //-- a. seek the file ensure if it doesn't exist let the user know.
   echo "Enter Search Criteria: ";

   $search_info = trim(fgets(STDIN));
   $search_data = explode("-",$search_info);
   $field = $search_data[0];
   $value = $search_data[1];

   //
   $search_val = find_by_val($field,$value);
   if(!empty($search_val))
    echo "\33[34m Your Student has been found succesful. \33[0m";
   else
    err("Value non-existent \33[34m Are you sure these are the correct search values? Please try again. ");
 }



 /**
 * Scan & store all students that exist in all the records.
 * Basically get all student ids(filenames) in each folder.
 *
 * @return Array
 *
 **/
 function find_by_val($field,$value)
 {
   $arr1=[];
   $found=[];
   $seek = scan_students();
   foreach ($seek as $student => $id) {
     $dir = "students/".substr($id,0,2);
     $arr1 = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . $dir ."/". $id. ".json"),true);
     if($arr1[$field] == $value) { $found = $arr1;}
   }
   if(!empty($found))
      echo print_r($found);
   else
      err("Student Not Found.\00[0m This student doesn't exist.");
   return $found;
 }



 /**
 * Scan & store all students that exist in all the records.
 * Basically get all student ids(filenames) in each folder.
 *
 * @return Array
 *
 **/
 function scan_students()
 {
    $current_students = [];
    $di = new RecursiveDirectoryIterator('students/');
    foreach (new RecursiveIteratorIterator($di) as $filename => $file) {
        $path_info = pathinfo($filename);
        if($path_info['extension']=='json'){
          array_push($current_students,$path_info['filename']);
        }
    }
    // echo print_r($current_students);
    return $current_students;
  }


  /**
  * Sensure a directory is empty beore removing it.
  *
  * @return Array
  *
  **/
  function is_dir_empty($diectory)
 {
  if (!is_dir($diectory)) return false;
  foreach (scandir($diectory) as $dir)
  {
    if (!in_array($dir, ['.','..','.json'])) return false;
  }
  return true;
 }
