<?php 

include 'database.php';

$database = new Database();
// $database->insert('usr' , ['username'=>'amitkasabe','password'=>'Pass@1234']);
// echo "Inserted Id : ".print_r($database->getResult());
// $database->update('usr' , ['username'=>'Ratnakar Dashrath Yadav','password'=>'Pass'],'id="8"');
// echo "Updated Result is :";
// print_r($database->getResult()); 
// $database->update('usr' ,'id="4"');
// echo "Delete Result is :";
// print_r($database->getResult()); 
// $database->sql('select * from usr');
// echo "SQL : ";
// echo "<pre>";
// print_r($database->getResult());
// echo "</pre>";

$database->select('usr', '*',null,null,null,null);
echo "SQL result is :";
echo "<pre>";
print_r($database->getResult());
echo "</pre>";

?>