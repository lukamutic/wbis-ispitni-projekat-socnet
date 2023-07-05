<?php

function clean($string)
{
    return htmlentities($string);
}

function redirect($location)
{
    header("location: {$location}");
    exit();
}

function set_message($message)
{
    if (!empty($message)) {
        $_SESSION['message'] = $message;
    } else {
        $message = "";
    }
}

function display_message()
{
    if (isset($_SESSION['message'])) {
        echo($_SESSION['message']);
        unset($_SESSION['message']);
    }
}

function email_exists($email)
{
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $query = "SELECT id FROM users WHERE email = '$email'";
    $result = query($query);

    if ($result->num_rows > 0) {
        return true;
    } else {
        return false;
    }
}

function user_exists($user)
{
    $user = filter_var($user, FILTER_SANITIZE_STRING);
    $query = "SELECT id FROM users WHERE username = '$user'";
    $result = query($query);

    if ($result->num_rows > 0) {
        return true;
    } else {
        return false;
    }
}

function validate_user_registration()
{
    $errors = [];

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $first_name = clean($_POST['first_name']);
        $last_name = clean($_POST['last_name']);
        $username = clean($_POST['username']);
        $email = clean($_POST['email']);
        $password = clean($_POST['password']);
        $confirm_password = clean($_POST['confirm_password']);

        if (strlen($username) > 20) {
            $errors[] = "Your Username can not be more then 20 characters!";
        }
        if (email_exists($email)) {
            $errors[] = "Sorry, that email is already taken.";
        }
        if (user_exists($username)) {
            $errors[] = "Sorry, that username is already taken.";
        }
        if (strlen($password) < 8) {
            $errors[] = "Your Password can not be less then 8 characters!";
        }
        if ($password != $confirm_password) {
            $errors[] = "The Password was not confirmed correctly!";
        }
        if (!empty($errors)) {
            foreach ($errors as $error) {
                echo "<div class='alert'>" . $error . "</div>";
            }
        } else {
            $first_name = filter_var($first_name, FILTER_SANITIZE_STRING);
            $last_name = filter_var($last_name, FILTER_SANITIZE_STRING);
            $username = filter_var($username, FILTER_SANITIZE_STRING);
            $email = filter_var($email, FILTER_SANITIZE_EMAIL);
            $password = filter_var($password, FILTER_SANITIZE_STRING);

            create_user($first_name, $last_name, $username, $email, $password);
        }
    }
}

function create_user($first_name, $last_name, $username, $email, $password)
{

    $first_name = escape($first_name);
    $last_name = escape($last_name);
    $username = escape($username);
    $email = escape($email);
    $password = escape($password);
    $password = password_hash($password, PASSWORD_DEFAULT);
    $active = 1;
    $role_id = 3;


    $sql = "INSERT INTO users(first_name, last_name, username, profile_image, email, password, active, role_id)";
    $sql .= "VALUES('$first_name','$last_name','$username', 'uploads/default.jpg', '$email', '$password', '$active','$role_id')";

    confirm(query($sql));
    set_message("You have been successfuly registered! Please log in!");
    redirect("login.php");

}


function validate_user_login()
{
    $errors = [];
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $email = clean($_POST['email']);
        $password = clean($_POST['password']);
        if (empty($email)) {
            $errors[] = "Email field cannot be empty!";
        }
        if (empty($password)) {
            $errors[] = "Password field cannot be empty!";
        }
        if (empty($erros)) {
            if (user_login($email, $password)) {
                redirect("index.php");
            } else {
                $errors[] = "Your email or password is incorrect. Please try again";
            }
        }

        if (!empty($errors)) {
            foreach ($errors as $error) {
                echo "<div class='alert'>" . $error . "</div>";
            }
        }

    }
}


function user_login($email, $password)
{
    $password = filter_var($password, FILTER_SANITIZE_STRING);
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = query($query);

    if ($result->num_rows > 0) {
        $date = $result->fetch_assoc();
        if (password_verify($password, $date['password'])) {
            $_SESSION['email'] = $email;
            if($date['role_id'] == 1) {
                $_SESSION['user_type'] = "admin";
            }   
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }

}


function get_user($id = NULL)
{
    if ($id != NULL) {
        $query = "SELECT * FROM users WHERE id=" . $id;
        $result = query($query);

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return "User not found.";
        }

    } else {
        $query = "SELECT * FROM users WHERE email='" . $_SESSION['email'] . "'";
        $result = query($query);

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return "User not found.";
        }
    }
}

function user_profile_image_upload()
{
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $target_dir = "uploads/";
        $user = get_user();
        $user_id = $user['id'];
        $target_file = $target_dir . $user_id . "." . pathinfo(basename($_FILES['profile_image_file']['name']), PATHINFO_EXTENSION);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $error = "";

        $check = getimagesize($_FILES['profile_image_file']['tmp_name']);
        if ($check != false) {
            $uploadOk = 1;
        } else {
            $error = "File is not an image.";
            $uploadOk = 0;
        }

        if ($_FILES['profile_image_file']['size'] > 10000000) {
            $error = "Sorry, your file is too large";
            $uploadOk = 0;
        }

        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            $error = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        if ($uploadOk == 0) {
            set_message('Error upload file: ' . $error);
        } else {
            $sql = "UPDATE users SET profile_image = '$target_file' WHERE id=$user_id";
            confirm(query($sql));

            set_message('Profile image uploaded!');

            if (!move_uploaded_file($_FILES["profile_image_file"]["tmp_name"], $target_file)) {
                set_message('Error uploading file: ' . $error);
            }
        }
        redirect("profile.php");
    }

}


function user_restrictions()
{
    if (!isset($_SESSION['email'])) {
        redirect("login.php");
    }
}

function login_check_pages()
{
    if (isset($_SESSION['email'])) {
        redirect("index.php");
    }
}

function create_post()
{
    $errors = [];
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $post_content = clean($_POST['post_content']);
        $category = $_POST['category'];

        if (strlen($post_content) > 200) {
            $errors[] = "Your post content is too long!";
        }

        if (!empty($errors)) {
            foreach ($errors as $error) {
                echo '<div class="alert">' . $error . '</div>';
            }
        } else {
            $post_content = filter_var($post_content, FILTER_SANITIZE_STRING);
            $post_content = escape($post_content);
            $user = get_user();
            $user_id = $user['id'];

            $sql = "INSERT INTO posts(user_id, content, likes,category_id ) ";
            $sql .= "VALUES($user_id, '$post_content', 0, $category)";

            confirm(query($sql));
            set_message('You added a post!');
            redirect('index.php');
        }
    }
}

function fetch_all_posts()
{

    $query = "SELECT posts.id,user_id, created_time, likes, content, category_name  FROM posts INNER JOIN categories ON posts.category_id = categories.id ORDER BY created_time DESC";
    $result = query($query);


    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $user = get_user($row['user_id']);
            $category = $row['category_name'];

            echo "<article class='post-item mb-4'>

<div class='post-item-profile-info d-flex align-items-center mb-3'>
<div class='post-item-profile-img'>
<img src='" . $user['profile_image'] . "'>
</div>
<div class='post-item-profile-name ps-4'>
<h4><b>" . $user['first_name'] . " " . $user['last_name'] . "</b></h4>
</div> 
</div> 

<div class='post-content mb-2'>
<p>" . $row['content'] . "</p>
</div>

<div class='post-info d-flex align-items-center justify-content-between'>
<div class='post-time'>
<p class='mb-0'><i>Date: " . $row['created_time'] . "</i></p>
</div>

<div>
<em>from category: </em>
<strong>
#" . $category . "
</strong>
</div>

<div class='likes'>
Likes: <b id='likes_ " . $row['id'] . " '>" . $row['likes'] . "</b>
<button class='' data_post_id='" . $row['id'] . "' onclick='like_post(this)'>LIKE</button>
</div>

</div>



</article>";

        }
    }
}

function export_all_posts()
{
    $query = "SELECT posts.id,user_id, created_time, likes, content, category_name  FROM posts INNER JOIN categories ON posts.category_id = categories.id ORDER BY created_time DESC";
    $result = query($query);
    $posts = $result->fetch_all(MYSQLI_ASSOC);

    $json_data = json_encode($posts);
    echo $json_data;
}

function get_data_for_chart()
{
    $query = "SELECT COUNT(posts.id) as num, category_name as category FROM posts INNER JOIN categories ON posts.category_id = categories.id GROUP by categories.category_name ORDER BY COUNT(posts.id);";
    $result = query($query);
    $data = $result->fetch_all(MYSQLI_ASSOC);

    return json_encode($data);
}

function select_category()
{

    $query = "SELECT * FROM categories";
    $result = query($query);
    echo "<div class='mt-4 mb-3'>
<em>Select category </em>
<select name='category'>";

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $category_id = $row['id'];
            $category_name = $row['category_name'];

            echo "<option value='" . $category_id . "'>" . $category_name . "</option>";
        }
    }

    echo "</select></div>";
}


function list_all_categories()
{
    $query = "SELECT * FROM categories";
    $result = query($query);


    echo "<div class='mt-2 mb-1'> <ul>";

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $category_id = $row['id'];
            $category_name = $row['category_name'];

            echo "<li><a href='posts.php?id=" . $category_id . "&name=" . $category_name . "'>" . $category_name . "</a></li>";        
    }

    echo "</ul></div>";

}

}

function fetch_category_posts()
{

    $category_id = $_GET['id'];
    $name = $_GET['name'];

    $query = "SELECT posts.id, user_id, created_time, likes, content, category_name  FROM posts INNER JOIN categories ON posts.category_id = categories.id WHERE posts.category_id=" . $category_id . " ORDER BY created_time DESC";
    $result = query($query);

    if ($result->num_rows > 0) {
        echo "<div class='mt-4 mb-3'><h2>Posts from " . $name . "</h2></div>";


        while ($row = $result->fetch_assoc()) {
            $user = get_user($row['user_id']);
            $category = $row['category_name'];


            echo "<article class='post-item mb-4'>

<div class='post-item-profile-info d-flex align-items-center mb-3'>
<div class='post-item-profile-img'>
<img src='" . $user['profile_image'] . "'>
</div>
<div class='post-item-profile-name ps-4'>
<h4><b>" . $user['first_name'] . " " . $user['last_name'] . "</b></h4>
</div> 
</div> 

<div class='post-content mb-2'>
<p>" . $row['content'] . "</p>
</div>

<div class='post-info d-flex align-items-center justify-content-between'>
<div class='post-time'>
<p class='mb-0'><i>Date: " . $row['created_time'] . "</i></p>
</div>

<div>
<em>from category: </em>
<strong>
#" . $category . "
</strong>
</div>

<div class='likes'>
Likes: <b id='likes_ " . $row['id'] . " '>" . $row['likes'] . "</b>
<button class='' data_post_id='" . $row['id'] . "' onclick='like_post(this)'>Like</button>
</div>

</div>

</article>";

        }
    } 
    
    else {
        echo "<div class='container'>
<h2 class='py-5'>Sorry, no posts from this category!</h2>
</div>";
    }

}