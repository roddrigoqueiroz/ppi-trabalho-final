<?php
class Response {
    public $success;
    public $redirect;
    public $message;
  
    public function __construct($success, $redirect, $message = '') {
      $this->success = $success;
      $this->redirect = $redirect;
      $this->message = $message;
    }
  }
?>