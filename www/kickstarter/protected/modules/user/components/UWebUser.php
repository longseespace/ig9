<?php
  class UWebUser extends CWebUser {

    public function isAdmin() {
      return UserModule::isAdmin();
    }

    public function model() {
      return UserModule::user();
    }

  }
?>