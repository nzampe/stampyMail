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
            $users = UserRepository::usersToObject($result);
            Connection::getConnection()->commit();
            return $users;
        } catch (\Throwable $th) {
            Connection::getConnection()->rollback();
            return false;
        }
    }

    public static function create($request) {
        try {
            self::hashPassword($request);
            Connection::getConnection()->beginTransaction();

            $sql = "INSERT INTO user (username, password, firstName, lastName, email, dni, createdAt, updatedAt)
                    VALUES (";

            $data = Repository::buildParamsUser($sql, $request, true);
            $data['sql'] .= ")";

            $result = Repository::excecuteQuery($data['sql'],$data['dataValues']);
            Connection::getConnection()->commit();
            return $result;
        } catch (\Throwable $th) {
            var_dump($th);die;
            Connection::getConnection()->rollback();
            return false;
        }
    }

    /**
     * @param array $request
     */
    private static function hashPassword(array &$request): void
    {
        if (isset($request['password'])) {
            $request['password'] = password_hash($request['password'], PASSWORD_DEFAULT);
        }
    }

    public static function update($request): bool
    {
        try {
            self::hashPassword($request);
            Connection::getConnection()->beginTransaction();
            $sql = "UPDATE user
                    SET ";
            $data = Repository::buildParamsUser($sql, $request, false);
            $data['sql'] .= " WHERE id = ".$request['id'].";";
            $result = Repository::excecuteQuery($data['sql'],$data['dataValues']);
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
                    WHERE ";
            $data = Repository::buildParamsWhere($sql, ['id' => $id], false);
            $result = Repository::excecuteQuery($data['sql'],$data['dataValues']);
            Connection::getConnection()->commit();
        } catch (\Throwable $th) {
            Connection::getConnection()->rollback();
            return false;
        }
    }

    public static function login($username, $password): array
    {
        try {
            Connection::getConnection()->beginTransaction();
            $sql = "SELECT *
                    FROM user
                    WHERE ";

            $data = Repository::buildParamsWhere($sql, ['username' => $username], false);
            $sth = Connection::getConnection()->prepare($data['sql'], array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $sth->execute($data['dataValues']);
            Connection::getConnection()->commit();
            $userData = $sth->fetch(PDO::FETCH_ASSOC);
            if ($userData && password_verify($password, $userData['password'])) {
                return $userData;
            }

            return [];
        } catch (\Throwable $th) {
            Connection::getConnection()->rollback();

            return [];
        }
    }
    
    public static function find($id) {
        try {
            Connection::getConnection()->beginTransaction();
            $sql = "SELECT *
                    FROM user
                    WHERE ";

            $data = Repository::buildParamsWhere($sql, ['id' => $id], false);
            $sth = Connection::getConnection()->prepare($data['sql'], array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $sth->execute($data['dataValues']);
            Connection::getConnection()->commit();
            return $sth->fetch(PDO::FETCH_ASSOC);
        } catch (\Throwable $th) {
            Connection::getConnection()->rollback();
            return false;
        }
    }

    public static function exists($username) {
        try {
            Connection::getConnection()->beginTransaction();
            $sql = "SELECT *
                    FROM user
                    WHERE ";

            $data = Repository::buildParamsWhere($sql, ['username' => $username], false);
            $sth = Connection::getConnection()->prepare($data['sql'], array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $sth->execute($data['dataValues']);
            Connection::getConnection()->commit();
            return $sth->fetch(PDO::FETCH_ASSOC);
        } catch (\Throwable $th) {
            Connection::getConnection()->rollback();
            return false;
        }
    }

    public static function usersToObject($users) {
        $result = [];
        foreach ($users as $value) {
            $result[] = new User(
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
        return $result;
    }
}
