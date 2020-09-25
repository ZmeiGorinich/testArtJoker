<?php include(ROOT . '/views/layouts/default/header.php'); ?>
    <div class="container contact_container page_default">
        <div class="row">
            <div class="col-lg-6 get_in_touch_col">
                <div class="get_in_touch_contents">
                    <div class="card">
                        <h3 class="card-header">Регистрация</h3>
                        <div class="card-block">
                            <p class="card-text">
                            <form method="post" id="my_form" action="">
                                <div class="form-group">
                                    <input id="input_name" class="form_input input_email input_ph" type="text"
                                           name="name" placeholder="Имя"
                                           value=""></div>
                                <div class="form-group">
                                    <input id="input_email" class="form_input input_name input_ph" type="email"
                                           name="email" placeholder="Эл. почта"
                                           value="">
                                </div>
                                <div class="form-group">
                                    <select class="chosen-select" id="region" name="region" style="width:500px;"
                                            onchange="getCities(this.value)">
                                        <option> Выберите область</option>
                                        <?php foreach ($regions as $item): ?>
                                            <option value="<?php echo $item['reg_id'] ?>"><?php echo $item['ter_name'] ?></option>
                                        <?php endforeach; ?>
                                    </select></div>
                                <div class="form-group">
                                <span id="spanCityChosenSelect" style="display: none;">
                                    <select name="city" id="city" class="chosen-select"
                                            onchange="getDistrict(this.value)"
                                            style="width:500px;">
                                    </select>
                                </span></div>
                                <div class="form-group">
                                <span id="spanDistrictChosenSelect" style="display: none;">
                                    <select name="district" id="district" class="chosen-select"
                                            style="width:500px;">
                                    </select>
                                    </span>
                                </div>
                                <div class="form-group">
                                    <button type="button" id="my_form_send" class="btn btn-primary">Зарегистрироваться
                                    </button>
                                </div>

                            </form>

                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div id="my_message"></div>


    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Вы уже зарегистрированы</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>ФИО </p>
                    <p id="modal_name"></p>
                    <p>Email </p>
                    <p id="modal_email"></p>
                    <p>Адрес</p>
                    <p id="modal_address"></p>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
                </div>
            </div>
        </div>
    </div>
<?php include(ROOT . '/views/layouts/default/footer.php'); ?>