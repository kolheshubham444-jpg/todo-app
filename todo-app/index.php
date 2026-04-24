<?php
session_start();

/* Initialize array */
if(!isset($_SESSION['tasks'])){
    $_SESSION['tasks'] = [];
}

/* ADD TASK */
if(isset($_POST['add'])){

    $task = trim($_POST['task']);

    if($task!=""){
        $_SESSION['tasks'][] = [
            "title"=>$task,
            "status"=>"pending"
        ];
    }
}

/* DELETE TASK */
if(isset($_GET['delete'])){

    $id = $_GET['delete'];

    if(isset($_SESSION['tasks'][$id])){
        unset($_SESSION['tasks'][$id]);
        $_SESSION['tasks'] = array_values($_SESSION['tasks']);
    }
}

/* LOAD EDIT DATA */
$edit_id="";
$edit_value="";

if(isset($_GET['edit'])){

    $edit_id = $_GET['edit'];

    if(isset($_SESSION['tasks'][$edit_id])){
        $edit_value = $_SESSION['tasks'][$edit_id]['title'];
    }
}

/* UPDATE TASK */
if(isset($_POST['update'])){

    $id = $_POST['edit_id'];
    $task = trim($_POST['task']);

    if($task!=""){
        $_SESSION['tasks'][$id]['title']=$task;
    }
}

/* TOGGLE STATUS */
if(isset($_GET['complete'])){

    $id=$_GET['complete'];

    if($_SESSION['tasks'][$id]['status']=="pending"){
        $_SESSION['tasks'][$id]['status']="completed";
    }else{
        $_SESSION['tasks'][$id]['status']="pending";
    }
}

?>

<!DOCTYPE html>
<html>

<head>

<title>Professional Todo App Second</title>

<style>

body{
font-family:Segoe UI;
background:#f1f3f6;
}

.container{

width:420px;
margin:60px auto;
background:white;
padding:20px;
border-radius:8px;
box-shadow:0 4px 10px rgba(0,0,0,0.1);

}

h2{

text-align:center;
margin-bottom:20px;

}

input{

width:65%;
padding:10px;
border:1px solid #ccc;
border-radius:5px;

}

button{

padding:10px 15px;
border:none;
border-radius:5px;
cursor:pointer;
color:white;

}

.add_btn{

background:#28a745;

}

.update_btn{

background:#007bff;

}

.task{

display:flex;
justify-content:space-between;
align-items:center;
margin-top:10px;
padding:10px;
background:#fafafa;
border:1px solid #ddd;
border-radius:5px;

}

.completed{

text-decoration:line-through;
color:gray;

}

.action a{

margin-left:10px;
text-decoration:none;
font-size:14px;

}

.delete{

color:red;

}

.edit{

color:#007bff;

}

.checkbox{

margin-right:10px;

}

</style>

</head>

<body>

<div class="container">

<h2>Todo List AWS</h2>

<form method="POST">

<input type="text"

name="task"

placeholder="Enter task"

value="<?php echo htmlspecialchars($edit_value); ?>"

required>

<input type="hidden"

name="edit_id"

value="<?php echo $edit_id; ?>">

<?php if($edit_value!=""){ ?>

<button class="update_btn" name="update">Update</button>

<?php }else{ ?>

<button class="add_btn" name="add">Add</button>

<?php } ?>

</form>

<hr>

<?php

foreach($_SESSION['tasks'] as $index=>$task){

$statusClass = $task['status']=="completed" ? "completed" : "";

echo "<div class='task'>";

echo "<div>";

echo "<input type='checkbox' class='checkbox'

onclick=\"window.location='?complete=$index'\"

".($task['status']=="completed"?"checked":"").">";

echo "<span class='$statusClass'>".$task['title']."</span>";

echo "</div>";

echo "<div class='action'>";

echo "<a class='edit' href='?edit=$index'>Edit</a>";

echo "<a class='delete' href='?delete=$index'>Delete</a>";

echo "</div>";

echo "</div>";

}

?>

</div>

</body>

</html>