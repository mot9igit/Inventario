var inventario = {
    options: {
        wrapper: '.i_wrap',
        live_form: '.i_live_form',
        form: '.i_form',
        profile_product: '.item_object',
        profile_client: '.item_client',
        new_object_button: '.object-create',
        new_client_button: '.client-create'
    },
    initialize: function () {
        $(document).on('submit', inventario.options.live_form, function(e){
            e.preventDefault();
            var $that = $(this);
            var data = new FormData($that.get(0));
            inventario.send(data);
        });
        $(document).on('submit', inventario.options.form, function(e){
            e.preventDefault();
            $(this).find('.message').html("");
            var $that = $(this);
            var data = new FormData($that.get(0));
            inventario.send(data);
        });
        $(inventario.options.live_form).on('keyup input', 'input[type=text]', function(e){
            if($(this).val().length >= 3 || $(this).val().length == 0){
                const url = new URL(document.location);
                const searchParams = url.searchParams;
                searchParams.delete("page");
                window.history.pushState({}, '', url.toString());
                pdoPage.keys['page'] = 1;
                $(this).closest(inventario.options.live_form).trigger('submit');
            }
        });
        $(inventario.options.live_form).on('change', 'input[type=checkbox]', function(e){
            const url = new URL(document.location);
            const searchParams = url.searchParams;
            searchParams.delete("page");
            window.history.pushState({}, '', url.toString());
            pdoPage.keys['page'] = 1;
            $(this).closest(inventario.options.live_form).trigger('submit');
        });
        $(document).on("click", inventario.options.new_object_button, function(e) {
            e.preventDefault();
            $("#remain form")[0].reset();
            $('#remain input[name="type"]').val('InventarioItems');
            $('#remain input[name="id"]').val('');
            $('#remain .image_placeholder').html("");
            $("#remain").modal("show");
        });
        $(document).on("click", inventario.options.new_client_button, function(e) {
            e.preventDefault();
            $("#client form")[0].reset();
            $('#client input[name="type"]').val('InventarioClients');
            $('#client input[name="id"]').val('');
            $('#client .image_placeholder').html("");
            $("#client").modal("show");
        });
        $(document).on("click", inventario.options.profile_product, function(e) {
            e.preventDefault();
            var id = $(this).closest('.profile-products__item').data('id');
            var name = $(this).closest('.profile-products__item').data('name');
            var count = $(this).closest('.profile-products__item').data('count');
            var type = $(this).closest('.profile-products__item').data('type');
            var number = $(this).closest('.profile-products__item').data('number');
            var image = $(this).closest('.profile-products__item').data('image');
            var description = $(this).closest('.profile-products__item').data('description');
            $('#remain input[name="id"]').val(id);
            $('#remain input[name="name"]').val(name);
            $('#remain input[name="type"]').val(type);
            $('#remain input[name="count"]').val(count);
            $('#remain input[name="number"]').val(number);
            $('#remain textarea[name="description"]').val(description);
            if(image){
                $('#remain .image_placeholder').html("<img src='"+image+"' alt='"+name+"' title='"+name+"'>");
            }else{
                $('#remain .image_placeholder').html("");
            }
            $("#remain").modal("show");
        });
        $(document).on("click", inventario.options.profile_client, function(e) {
            e.preventDefault();
            var id = $(this).closest('.profile-products__item').data('id');
            var name = $(this).closest('.profile-products__item').data('name');
            var birthday = $(this).closest('.profile-products__item').data('birthday');
            var type = $(this).closest('.profile-products__item').data('type');
            var contact = $(this).closest('.profile-products__item').data('contact');
            var email = $(this).closest('.profile-products__item').data('email');
            var phone = $(this).closest('.profile-products__item').data('phone');
            var image = $(this).closest('.profile-products__item').data('photo');
            var description = $(this).closest('.profile-products__item').data('description');
            $('#client input[name="id"]').val(id);
            $('#client input[name="name"]').val(name);
            $('#client input[name="birthday"]').val(birthday);
            $('#client input[name="type"]').val(type);
            $('#client input[name="contact"]').val(contact);
            $('#client input[name="email"]').val(email);
            $('#client input[name="phone"]').val(phone);
            $('#client textarea[name="description"]').val(description);
            if(image){
                $('#client .image_placeholder').html("<img src='"+image+"' alt='"+name+"' title='"+name+"'>");
            }else{
                $('#client .image_placeholder').html("");
            }
            $("#client").modal("show");
        });
    },
    send: function(data){
        var response = '';
        $.ajax({
            type: "POST",
            contentType: false,
            processData: false,
            url: inventarioConfig['actionUrl'],
            dataType: 'json',
            data: data,
            success:  function(data_r) {
                if(data_r.data.remove_id){
                    $('.profile-products__item[data-id='+data_r.data.remove_id+']').remove();
                    $(inventario.options.live_form).trigger('submit');
                }
                if(data_r.data.type == 'object'){
                    var form = $("#remain form");
                    form.find('.message').html(data_r.message);
                    form.find('.message').show();
                    setTimeout(function(){
                        form.find('.message').hide("slow", function() {
                            form.find('.message').html();
                        }).html('');
                    }, 2000);
                    $(inventario.options.live_form).trigger("submit");
                }
                if(data_r.data.type == 'client'){
                    var form = $("#client form");
                    form.find('.message').html(data_r.message);
                    form.find('.message').show();
                    setTimeout(function(){
                        form.find('.message').hide("slow", function() {
                            form.find('.message').html();
                        }).html('');
                    }, 2000);
                    $(inventario.options.live_form).trigger("submit");
                }
                if(data_r.topdo){
                    $('#pdopage .rows').html(data_r.data);
                    $('#pdopage .pagination').html(data_r.pagination);
                    $('#pdopage span.total').html(data_r.total);
                }
            }
        });
    },
}

$(document).ready(function(){
    inventario.initialize();
})