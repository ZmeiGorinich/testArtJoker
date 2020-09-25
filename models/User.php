<?php

class User
{
    /**
     * Проверка данных при регистрации.
     */
    public static function checkDataRegister($name, $email, $region, $city,$district=0)
    {
        $error = null;

        if (!self::checkName($name)) $error= 'Некорректное имя: необходимо от 2 до 35 символов.';
        if (!self::checkEmailCorrect($email)) $error = 'Некорректный email.';
        if (!self::checkEmailExist($email)) $error = 'Данный эл. адрес уже зарегистрирован в системе.';
        if (!self::checkTerritory($region, $city,$district)) $error = 'Заполните все поля.';


        if (!isset($error)) {
            return true;
        } else {
            return $error;
        }
    }

    /**
     * Проверка имени: неменьше 2х, не больше 255 символов
     */
    public static function checkName($name)
    {
        if (mb_strlen($name) < 2 || mb_strlen($name) > 255) {
            return false;
        } else return true;
    }

    /**
     * Проверка email на валидность
     */
    public static function checkEmailCorrect($email)
    {
        if (filter_var(($email), FILTER_VALIDATE_EMAIL)) {
            return true;
        } else return false;
    }

    /**
     * Проверка email на уникальность
     */
    public static function checkEmailExist($email)
    {
        $db = Db::getConnection();
        $sql = $db->prepare('SELECT id FROM users WHERE email = :email');
        $sql->execute(['email' => $email]);
//        var_dump(count($sql->fetch()));die;
        if (count($sql->fetch()) > 1) {
            return true;
        } else return false;
    }


    public static function checkTerritory($region, $city,$district)
    {
        $db = Db::getConnection();
        $sql = $db->prepare('SELECT * FROM t_koatuu_tree where reg_id=:region and ter_id=:city;');
        $sql->execute(['region' => $region,'city' => $city]);
        $check_ter_type_id=$sql->fetch();
        if ($check_ter_type_id['ter_type_id']==3){
            return true;
        }else{
            $districtTT=TKoatuuTree::getDistrict($check_ter_type_id['ter_id']);
            if (count($districtTT)>0){
                if (strlen($district)>2){
                    return true;
                }else{
                    echo false;
                }
            }else{
                return true;
            }
        }
    }



    /**
     * Регистрация пользователя
     *
     * @param $name
     * @param $email
     * @param $territory
     * @return bool
     */
    public static function register($name,$email,$territory)
    {
        $db = Db::getConnection();
        $sql = $db->prepare('INSERT INTO users  (name, email, territory) VALUES (:name, :email, :territory)');
        $result = $sql->execute([
            'name'     => $name,
            'email'    => $email,
            'territory' => $territory
        ]);
        return $result;
    }


    /**
     * Вернет массив с информацией о пользователе
     * @param $email
     * @return mixed
     */
    public static function getUserByEmail($email)
    {
        $db = Db::getConnection();
        $sql = $db->prepare('select users.name, users.email,t_koatuu_tree.ter_address 
            from users left  join t_koatuu_tree on users.territory=t_koatuu_tree.ter_id where users.email = :email');
        $sql->execute(['email' => $email]);
        $result = $sql->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

}