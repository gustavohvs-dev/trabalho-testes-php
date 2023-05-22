<?php

$routes = [

	["login", "app/controllers/login/login.php"],
	["test", "app/controllers/test/test.php"],

    //Users routes
    ["getUsers", "app/controllers/Users/getUsers.php"],
    ["listUsers", "app/controllers/Users/listUsers.php"],
    ["createUsers", "app/controllers/Users/createUsers.php"],
    ["updateUsers", "app/controllers/Users/updateUsers.php"],
    ["deleteUsers", "app/controllers/Users/deleteUsers.php"],

    //Topics routes
    ["getTopics", "app/controllers/Topics/getTopics.php"],
    ["listTopics", "app/controllers/Topics/listTopics.php"],
    ["createTopics", "app/controllers/Topics/createTopics.php"],
    ["updateTopics", "app/controllers/Topics/updateTopics.php"],
    ["deleteTopics", "app/controllers/Topics/deleteTopics.php"],

    //Comments routes
    ["getComments", "app/controllers/Comments/getComments.php"],
    ["listComments", "app/controllers/Comments/listComments.php"],
    ["createComments", "app/controllers/Comments/createComments.php"],
    ["updateComments", "app/controllers/Comments/updateComments.php"],
    ["deleteComments", "app/controllers/Comments/deleteComments.php"],

];
