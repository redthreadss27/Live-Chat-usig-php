<?php
    session_start();
    // echo "we are in sign";
    include_once "config.php";
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    if(!empty($fname) && !empty($lname) && !empty($email) && !empty($password)){
        // lets check user email is vail or not
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){//IF EMAIL is valid
            // lets check the email already exist in the data base or not
            $sql = mysqli_query($conn, "select email from users where email = '$email'");
            if(mysqli_num_rows($sql)>0){//if email already exist
                echo "$email - already exists";
            }else{
                //lets check user upload file or not
                if(isset($_FILES['image'])){ //if file is uploaded
                    $img_name = $_FILES['image']['name'];//getting user uploaded img name
                    $img_type = $_FILES['image']['type'];//getting user uploaded img type
                    $tmp_name = $_FILES['image']['tmp_name'];//this temporary name is used to save/move file in our folder

                    //lets exploade image and get the extension like jpg png
                    $img_explode = explode('.', $img_name);
                    $img_ext = end($img_explode); //here we get the extension of an user uploaded img file

                    $extensions = ['png', 'jpeg', 'jpg'];//these are some valid img ext and we've store that in array
                    if(in_array($img_ext, $extensions) === true){//if user uploaded img ext is matched with any array extension
                        $time = time(); //this will return us current time 
                                        //we need this time because when you uploading user img to in our folder we rename user file with current time so all 
                                        //the image file wil have a unique name
                        //lets move the user uploaded img to our particular folder
                        $new_img_name = $time.$img_name;
                        if(move_uploaded_file($tmp_name, "images/".$new_img_name)){// if user upload img move to our folder successfully

                            $status = "Active now";//once user signed up then his status will be active now
                            $random_id = rand(time(), 10000000);//creating random id for user

                            //lets insert all user data inside the table
                            $sql2 = mysqli_query($conn, "insert into users(unique_id, fname, lname, email, password, img, status) values($random_id, '$fname', '$lname', '$email', '$password', '$new_img_name', '$status')");
                            if($sql2){//if these data inserted
                                $sql3 = mysqli_query($conn, "select * from users where email = '$email'");
                                if(mysqli_num_rows($sql3)>0){
                                    $row = mysqli_fetch_assoc($sql3);
                                    $_SESSION['unique_id']= $row['unique_id'];//using this session we used user unique_id in other php file
                                    echo "success";
                                }
                            }else{
                                echo "Something went wrong!";
                            }
                        }
                    }else{
                        echo "please select an image file - jpeg, jpg, png";
                    }
                }else{
                    echo "please select an image file";
                }
            }
        }else{
        echo "$email - this is not a valid email";
        }
    }else{
        echo "all input field are required!";
    }
?>