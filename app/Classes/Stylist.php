<?php
    namespace App\Classes;

    class Stylist{
        private $id;
        private $name;
        private $email;
        private $address;
        private $birthday;
        private $sex;
        private $phone;
        private $post;
        private $icon;
        function __construct($id,$name,$email,$address,$birthday,$sex,$phone,$post,$icon)
        {
            $this->id = $id;
            $this->name = $name;
            $this->email = $email;
            $this->address = $address;
            $this->birthday = $birthday;
            $this->sex = $sex;
            $this->phone = $phone;
            $this->post = $post;
            $this->icon = $icon;
        }

        function getId(){
            return $this->id;
        }
        function getEmail(){
            return $this->email;
        }
        function getName(){
            return $this->name;
        }
        function getAddress(){
            return $this->address;
        }
        function getBirthday(){
            return $this->birthday;
        }
        function getSex(){
            return $this->sex;
        }
        function getPhone(){
            return $this->phone;
        }
        function getPost(){
            return $this->post;
        }
        function getIcon(){
            return $this->icon;
        }

    }