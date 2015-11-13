<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sk";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// sql to create table
$sql = "SELECT * from forum_topic";
$result = $conn->query($sql);
if ( $result=== FALSE) {
  echo "Error query: " . $conn->error;
} else {
  foreach ($result as $tag_id) {
    $tags_id = explode(",",$tag_id["cat_id"]);
    $topic_id = $tag_id["id"];
    echo '<pre>'; // pre-formatted text, \n should work
    print_r("topic_id :".$tag_id["id"]."\n");
    print_r($tags_id);
    $count  = count($tags_id);
    $i = 0;
    $to_DB=array();
    foreach ($tags_id as $tag_id){
      $sql2 = "SELECT forum_cat.cat_name from forum_cat where forum_cat.id = $tag_id";
      $result2 = $conn->query($sql2);
      foreach ($result2 as $tagi) {
        $cat_name = $tagi["cat_name"];
      }
      $to_DB[$i]=$cat_name;
      $i++;
    }
    $cat_name_toDB =  implode(",",$to_DB);
    echo $topic_id."__".$cat_name_toDB;
    $sql3 = "UPDATE forum_topic SET cat_string='$cat_name_toDB' WHERE id=$topic_id";
    $result3 = $conn->query($sql3);
    if ( $result3=== FALSE) {
      echo "Error query: " . $conn->error;
    }else{
      echo "Query success ";
    }
    echo '</pre>';
  }
}

$conn->close();
?>
