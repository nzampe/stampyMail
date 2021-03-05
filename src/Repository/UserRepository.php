<?php

class UserRepository extends Repository{
    
    public function findAll() {
        
        $today = new \DateTime("NOW");
        $today = $today->format('Y-m-d');
        try {
            $this->getConnection()->beginTransaction();
            $sql = 'SELECT *
                    FROM user as u';
            $sth = $this->getConnection()->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
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
            $this->getConnection()->commit();
            return $users;
        } catch (\Throwable $th) {
            $this->getConnection()->rollback();
            return false;
        }
    }

    public function new($user) {
        try {
            $this->getConnection()->beginTransaction();

            $sql = "INSERT INTO user (username, password, firstName, lastName, email, dni, createdAt, updatedAt)
                    VALUES (:username, :password, :firstName, :lastName, :email, :dni, :createdAt, :updatedAt);";

            $sth = $this->getConnection()->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $this->getConnection()->commit();
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
            $this->getConnection()->rollback();
            return false;
        }
    }

    public function edit($user, $request) {
        try {
            $this->getConnection()->beginTransaction();

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
            $sth = $this->getConnection()->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $result = $sth->execute($dataValues);
            $this->getConnection()->commit();
            return $result;
        } catch (\Throwable $th) {
            var_dump($th);die;
            $this->getConnection()->rollback();
            return false;
        }
    }

    public function delete($id) {
        try {
            $this->getConnection()->beginTransaction();
            $sql = "DELETE FROM user
                    WHERE id = :id";
            $sth = $this->getConnection()->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            return $sth->execute(array(':id' => $id));
            $this->getConnection()->commit();
        } catch (\Throwable $th) {
            $this->getConnection()->rollback();
            return false;
        }
    }

    public function exists($username) {
        try {
            $this->getConnection()->beginTransaction();
            $sql = "SELECT *
                    FROM user as u
                    WHERE u.username = :username";

            $sth = $this->getConnection()->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $sth->execute(array(':username' => $username));
            $this->getConnection()->commit();
            return $sth->fetch(PDO::FETCH_ASSOC);
        } catch (\Throwable $th) {
            $this->getConnection()->rollback();
            return false;
        }
    }
}