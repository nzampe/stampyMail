<?php

include_once('./src/Entity/User.php');

class UserRepository {

    public static function findAll() {
        
        $today = new \DateTime("NOW");
        $today = $today->format('Y-m-d');
        try {
            Connection::getConnection()->beginTransaction();
            $sql = 'SELECT *
                    FROM user as u';
            $sth = Connection::getConnection()->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $sth->execute();
            $result = $sth->fetchAll(PDO::FETCH_ASSOC);
            foreach ($result as $value) {
                $users[] = new User(
                    $value['id'],
                    $value['username'],
                    $value['password'],
                    $value['firstName'], 
                    $value['lastName'], 
                    $value['email'], 
                    $value['dni'], 
                    $value['createdAt'], 
                    $value['updatedAt']
                );
            }
            Connection::getConnection()->commit();
            return $users;
        } catch (\Throwable $th) {
            Connection::getConnection()->rollback();
            return false;
        }
    }

    public static function create($user) {
        try {
            Connection::getConnection()->beginTransaction();

            $sql = "INSERT INTO user (username, password, firstName, lastName, email, dni, createdAt, updatedAt)
                    VALUES (:username, :password, :firstName, :lastName, :email, :dni, :createdAt, :updatedAt);";

            $sth = Connection::getConnection()->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            Connection::getConnection()->commit();
            return $sth->execute(array(
                    ':username' => $user->getUsername(),
                    ':password' => $user->getPassword(),
                    ':firstName' => $user->getFirstName(),
                    ':lastName' => $user->getLastName(),
                    ':email' => $user->getEmail(),
                    ':dni' => $user->getDni(),
                    ':createdAt' => $user->getCreatedAt()->format('Y-m-d H:m:s'),
                    ':updatedAt' => $user->getUpdatedAt()->format('Y-m-d H:m:s'),
                ));
        } catch (\Throwable $th) {
            Connection::getConnection()->rollback();
            return false;
        }
    }

    public static function update($user, $request) {
        try {
            Connection::getConnection()->beginTransaction();

            $sql = "UPDATE user
                    SET ";

            $dataValues = [];
            foreach ($request as $key => $value) {
                if($key !== 'id'){
                    $sql .= $key . " = ?,";
                    $dataValues[] = $value;
                }
            }
            $sql = trim($sql, ',');
            $sql .= " WHERE id = ".$request['id'];
            $sth = Connection::getConnection()->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $result = $sth->execute($dataValues);
            Connection::getConnection()->commit();
            return $result;
        } catch (\Throwable $th) {
            Connection::getConnection()->rollback();
            return false;
        }
    }

    public static function delete($id) {
        try {
            Connection::getConnection()->beginTransaction();
            $sql = "DELETE FROM user
                    WHERE id = :id";
            $sth = Connection::getConnection()->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            return $sth->execute(array(':id' => $id));
            Connection::getConnection()->commit();
        } catch (\Throwable $th) {
            Connection::getConnection()->rollback();
            return false;
        }
    }

    public static function exists($username) {
        try {
            Connection::getConnection()->beginTransaction();
            $sql = "SELECT *
                    FROM user as u
                    WHERE u.username = :username";

            $sth = Connection::getConnection()->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $sth->execute(array(':username' => $username));
            Connection::getConnection()->commit();
            return $sth->fetch(PDO::FETCH_ASSOC);
        } catch (\Throwable $th) {
            Connection::getConnection()->rollback();
            return false;
        }
    }
}