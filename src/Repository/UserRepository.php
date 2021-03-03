<?php

class UserRepository {
    
    public function getUsers() {
        
        $today = new \DateTime("NOW");
        try {
            $sql = "SELECT *
                    FROM user
                    WHERE '".$dateTo."' <> null OR '".$dateTo."' > '".$today."'";

        } catch (\Throwable $th) {
            return false;
        }
    }

    public function userExists($id) {
        try {
            $sql = "SELECT *
                    FROM user as u
                    WHERE $id = u.id";
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function addUser($user) {
        try {
            $sql = "INSERT INTO user (username, password, firstName, lastName, email, dni, createdAt, updatedAt, dateTo)
                    VALUES ('".$user->getUsername()."', '".$user->getPassword()."', '".$user->getFirstName()."', '".$user->getLastName()."', '".$user->getEmail().", '"
                    .$user->getDni().", ". $user->getCreatedAt().", ".$user->getUpdatedAt().", ".$user->getDateTo().");";
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function deleteUser($id) {
        $today = new \DateTime("NOW");
        try {
            $sql = "UPDATE user as u
                    SET u.dateTo = $today
                    WHERE $id = u.id";
        } catch (\Throwable $th) {
            return false;
        }
    }
}