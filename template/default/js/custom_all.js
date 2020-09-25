function getCities(reg_id) {
    $.post('/get-cities', {
        reg_id: reg_id
    }, onAjaxSuccess);

    function onAjaxSuccess(data) {
        if (data.indexOf('<option value> - </option>') == 0) {
        }
        $('#city').find('option').remove();
        $('#district').find('option').remove();
        $('#city').append(data);
        $("#city").trigger("chosen:updated");
        $("#city_chosen").css('width', '500px');
        $('#spanCityChosenSelect').show();
        $('#spanDistrictChosenSelect').hide();

    }

}

function getDistrict(ter_id) {
    $.post('/get-district', {
        ter_id: ter_id
    }, onAjaxSuccess);

    function onAjaxSuccess(data) {
        if (data.indexOf('<option value> - </option>') == 0) {
            $('#district').find('option').remove();
            $("#district").trigger("chosen:updated");
            $('#spanDistrictChosenSelect').hide();

        } else {
            $('#district').find('option').remove();
            $('#district').append(data);
            $("#district").trigger("chosen:updated");
            $("#district_chosen").css('width', '500px');
            $('#spanDistrictChosenSelect').show();
        }
    }
}

$(document).ready(function () {
    $('#my_form_send').click(function (e) {
        e.preventDefault();
        var input_name = $('#input_name').val();
        var input_email = $('#input_email').val();

        $(".error").remove();
        if (input_name.length < 1) {
            $('#input_name').after('<span class="error">Поле обезательное</span>');
        }
        if (input_email.length < 1) {
            $('#input_email').after('<span class="error">Поле обязательно</span>');
        } else {
            var testEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
            if (testEmail.test(input_email)) {
            } else $('#input_email').after('<span class="error">Ввелите корректный Email</span>');
        }

        var region_text = $('#region_chosen').find('span').text();
        var city_text = $('#city_chosen').find('span').text();
        var disctrict_text = $('#district_chosen').find('span').text();

        if (region_text.indexOf('Выберите область') < 0) {
        } else {
            $('#region_chosen').after('<span class="error">Поле обезательное</span>');
        }

        if (city_text.indexOf('Выберите') < 0) {
        } else {
            $('#city_chosen').after('<span class="error">Поле обезательное</span>');
        }

        if (disctrict_text.indexOf('Выберите район') < 0) {
        } else {
            $('#district_chosen').after('<span class="error">Поле обезательное</span>');
        }


        var size = Object.keys($(".error")).length;

        if (size === 2) {
            $.post(
                '/send-form',
                $("#my_form").serialize(),

                function (msg) { // получен ответ серве

                    try {
                        let json = JSON.parse(msg);
                        $("#modal_name").text(json['name'])
                        $("#modal_email").text(json['email'])
                        $("#modal_address").text(json['ter_address'])
                        $('#my_message').html("");
                        $('#exampleModalCenter').modal();
                    } catch (e) {
                        $('#my_message').html(msg);
                    }
                }
            );
        }

    });
});

