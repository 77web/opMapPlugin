<?php
//opDiaryPlugin
$this->dispatcher->connect('op_action.post_execute_diary_create', array("opRegisterMap", "listenToDiaryPostCreate"));
$this->dispatcher->connect('op_action.post_execute_diary_update', array("opRegisterMap", "listenToDiaryPostUpdate"));

$this->dispatcher->connect('op_action.post_execute_diaryComment_create', array('opRegisterMap', 'listenToDiaryCommentPostCreate'));

$this->dispatcher->connect('op_action.post_execute_diary_delete', array("opDeleteMap", "listenToDiaryPostDelete"));
$this->dispatcher->connect('op_action.post_execute_diaryComment_delete', array('opDeleteMap', 'listenToDiaryCommentPostDelete'));

//opCommunityTopicPlugin
$this->dispatcher->connect('op_action.post_execute_communityTopic_create', array('opRegisterMap', 'listenToCommunityTopicEventPostCreate'));
$this->dispatcher->connect('op_action.post_execute_communityTopic_update', array('opRegisterMap', 'listenToCommunityTopicEventPostUpdate'));

$this->dispatcher->connect('op_action.post_execute_communityEvent_create', array('opRegisterMap', 'listenToCommunityTopicEventPostCreate'));
$this->dispatcher->connect('op_action.post_execute_communityEvent_update', array('opRegisterMap', 'listenToCommunityTopicEventPostUpdate'));

$this->dispatcher->connect('op_action.post_execute_communityTopicComment_create', array('opRegisterMap', 'listenToCommunityTopicCommentPostCreate'));

$this->dispatcher->connect('op_action.post_execute_communityEventComment_create', array('opRegisterMap', 'listenToCommunityEventCommentPostCreate'));

$this->dispatcher->connect('op_action.post_execute_communityTopic_delete', array('opDeleteMap', 'listenToCommunityTopicEventPostDelete'));
$this->dispatcher->connect('op_action.post_execute_communityEvent_delete', array('opDeleteMap', 'listenToCommunityTopicEventPostDelete'));
$this->dispatcher->connect('op_action.post_execute_communityTopicComment_delete', array('opDeleteMap', 'listenToCommunityTopicCommentPostDelete'));
$this->dispatcher->connect('op_action.post_execute_communityEventComment_delete', array('opDeleteMap', 'listenToCommunityEventCommentPostDelete'));