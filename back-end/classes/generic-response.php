<?php
class GenericResponse {
    public $success;
    public $data;

    public function __construct($success, $data) {
        $this->success = $success;
        $this->data = $data;
    }
}
?>