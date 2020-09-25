<?php

class UserController
{

    /**
     * Страница авторизации/регистрации
     */
    public function actionRegister()
    {
        $regions = TKoatuuTree::getRegions();
        $page = ['title' => 'Регистрация'];
        include_once ROOT.'/views/user/login-register.php';
    }

    public function actionGetCities(){

        $reg_id = $_POST['reg_id'];

        $cities=TKoatuuTree::getCities($reg_id);
        if (count($cities) > 0) {
            echo "<option value>Выберите город</option>";
            foreach ($cities as $city) {
                echo "<option value='" . $city['ter_id'] . "'>".$city['ter_name']."</option>";
            }
        } else {
            echo "<option value> - </option>";
        }
    }

    public function actionGetDistrict(){

        $ter_id = $_POST['ter_id'];

        $cities=TKoatuuTree::getDistrict($ter_id);
        if (count($cities) > 0) {
            echo "<option value>Выберите район</option>";
            foreach ($cities as $city) {
                echo "<option value='" . $city['ter_id'] . "'>".$city['ter_name']."</option>";
            }
        } else {
            echo "<option value> - </option>";
        }
    }

    public function actionSendForm(){
        $name=$_POST['name'];
        $email=$_POST['email'];
        $region=$_POST['region'];
        $city=$_POST['city'];
        isset($_POST['district']) ? $district=$_POST['district'] : $district=0;


        if (strlen($email)>2){
            if (User::checkEmailExist($email)){
                $user =User::getUserByEmail($email);
                echo json_encode($user);
            }else{
                if (strlen($name)>2 &&strlen($region)>1 &&strlen($city)>2){
                    $valid_data=User::checkDataRegister($name,$email,$region,$city,$district);
                    if ($valid_data==true){
                        if (User::register($name,$email,strlen($district)>2?$district:$city)){
                            echo 'Регистрация прошла успешно';
                        }else{
                            echo 'Ошибка регистрации';
                        }
                    }else{
                        echo 'Введите корректные данные';
                    }

                }else echo "Заполните все поля";
            }
        }else echo "Заполните все поля";


    }
}