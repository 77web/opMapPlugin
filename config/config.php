<?php
$this->dispatcher->connect('op_action.post_execute_diary_create', array("opRegisterMap", "listenToDiaryPostCreate"));
$this->dispatcher->connect('op_action.post_execute_diary_update', array("opRegisterMap", "listenToDiaryPostUpdate"));

$this->dispatcher->connect('op_action.post_execute_diary_delete', array("opDeleteMap", "listenToDiaryPostDelete"));

