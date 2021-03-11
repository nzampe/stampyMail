<?php

class Repository {

    public static function buildParamsUser($sql, $params, $insert) {
        $dataValues = [];
        foreach ($params as $key => $value) {
            if(!$insert){
                if($key !== 'id'){
                    $sql .= $key . " = ?,";
                    $dataValues[] = $value;
                }
            }
            else {
                $sql .= " ?,";
                $dataValues[] = $value;
            }
        }
        $sql = trim($sql, ',');
        return ['sql' => $sql, 'dataValues' => $dataValues];
    }

    public static function excecuteQuery($sql, $values) {
        $sth = Connection::getConnection()->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        return $sth->execute($values);
    }

    public static function buildParamsWhere($sql, $params) {
        $dataValues = [];
        foreach ($params as $key => $value) {
            $sql .= $key . " = ? and ";
            $dataValues[] = $value;
        }
        $sql = trim($sql, 'and ');
        return ['sql' => $sql, 'dataValues' => $dataValues];
    }
}