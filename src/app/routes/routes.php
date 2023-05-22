<?php

$routes = [

	["login", "app/controllers/login/login.php"],

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

    //Improvementsuggestions routes
    ["getImprovementsuggestions", "app/controllers/Improvementsuggestions/getImprovementsuggestions.php"],
    ["listImprovementsuggestions", "app/controllers/Improvementsuggestions/listImprovementsuggestions.php"],
    ["createImprovementsuggestions", "app/controllers/Improvementsuggestions/createImprovementsuggestions.php"],
    ["updateImprovementsuggestions", "app/controllers/Improvementsuggestions/updateImprovementsuggestions.php"],
    ["deleteImprovementsuggestions", "app/controllers/Improvementsuggestions/deleteImprovementsuggestions.php"],

];
