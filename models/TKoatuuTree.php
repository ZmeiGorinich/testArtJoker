<?php

class TKoatuuTree
{

    public static function getRegions()
    {
        $db = Db::getConnection();
        $result = $db->query("SELECT * FROM t_koatuu_tree where ter_type_id=0;" );
        return self::getData($result);
    }

    public static function getCities($reg_id)
    {
        $db = Db::getConnection();
        if ($reg_id==80 || $reg_id==85){
            $result = $db->query("SELECT * FROM t_koatuu_tree where ter_type_id=3 and reg_id=$reg_id;" );

        }else{
            $result = $db->query("SELECT * FROM t_koatuu_tree where ter_type_id=1 and reg_id=$reg_id;" );
        }
        return self::getData($result);

    }

    public static function getDistrict($ter_id)
    {
        $db = Db::getConnection();
        $result_reg_id=$db->query("SELECT reg_id,ter_name FROM t_koatuu_tree where ter_id=$ter_id;" );
        $get_city_by_ter_id = $result_reg_id->fetch(PDO::FETCH_ASSOC);
        $reg_id=$get_city_by_ter_id['reg_id'];
        $ter_name=$get_city_by_ter_id['ter_name'];
        $result = $db->query("SELECT * FROM t_koatuu_tree where ter_type_id=3 and ter_level=3 and reg_id=$reg_id and ter_address LIKE '%$ter_name%';" );
        return self::getData($result);
    }

    public static function getData($result){
        $i=0;
        $region =array();
        while ($row = $result->fetch()) {
            $region[$i]['ter_id'] = $row['ter_id'];
            $region[$i]['ter_name'] = $row['ter_name'];
            $region[$i]['reg_id'] = $row['reg_id'];
            $i++;
        }
        return $region;
    }
}