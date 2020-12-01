(function($){
$(document).ready(function() {
    
    var aAsc   = $('.fa-sort-amount-asc');
    var aDesc  = $('.fa-sort-amount-desc');
    var pBttn = $('.soc_premium');
    var popBttn = $('.soc_popular');
    var instBttn = $('.soc_install');
    var brBttn = $('.soc_br');
    var alphaBttn   = $('.soc_alphabet');
    
    var shWrap = $('.soc_wrapper.js_filter_ready');
    var sBlck    = $('.js_filter_ready .soc_blk');
    
    // вывод по уменьшению цены
    aDesc.on('click', function() {
        aAsc.removeClass('active');
        aDesc.addClass('active');
        sBlck.sort(sort_desc).appendTo(shWrap);
    });
    function sort_desc(a, b){
        return ($(b).data('price')) > ($(a).data('price')) ? 1 : -1;    
    }
    
    // по увеличению цены
    aAsc.on('click', function() {
        aDesc.removeClass('active');
        aAsc.addClass('active');
        sBlck.sort(sort_asc).appendTo(shWrap);
    });
    function sort_asc(a, b){ // от меньшего к большему
        return ($(b).data('price')) < ($(a).data('price')) ? 1 : -1;    
    }

    // вывод премиум
    pBttn.on('click', function() {
        soc_clear_buttons();
        pBttn.addClass('active');
        $(".soc_wrapper.js_filter_ready [data-price='0']").hide();
    });

    // по скачиваниям
    popBttn.on('click', function() {
        soc_clear_buttons();
        aAsc.add(aDesc).addClass('disabled');
        popBttn.addClass('active');
        $('.soc_tl_downloads').addClass('soc_mark');
        sBlck.sort(sort_popular).appendTo(shWrap);
    });
    function sort_popular(a, b){
        return ($(b).data('popular')) > ($(a).data('popular')) ? 1 : -1;    
    }
    
    // по активным установкам
    instBttn.on('click', function() {
        soc_clear_buttons();
        aAsc.add(aDesc).addClass('disabled');
        instBttn.addClass('active');
        $('.soc_tl_install').addClass('soc_mark');
        sBlck.sort(sort_install).appendTo(shWrap);
    });
    function sort_install(a, b){
        return ($(b).data('install')) > ($(a).data('install')) ? 1 : -1;    
    }
    
    // по отказам
    brBttn.on('click', function() {
        soc_clear_buttons();
        aAsc.add(aDesc).addClass('disabled');
        brBttn.addClass('active');
        $('.soc_tl_bounce').addClass('soc_mark');
        sBlck.sort(sort_br).appendTo(shWrap);
    });
    function sort_br(a, b){
        return ($(b).data('bouncer')) > ($(a).data('bouncer')) ? 1 : -1;    
    }

    //  вывод по алфавиту
    alphaBttn.on('click', function() {
        soc_clear_buttons();                        // очищаем статусы
        aAsc.add(aDesc).addClass('disabled');       // отключаем фильтры
        alphaBttn.addClass('active');               // активируем нашу кнопу
        sBlck.sort(sort_alphabet).appendTo(shWrap); // сортировка
    });
    function sort_alphabet(a, b){ // сортировка нечувствительна к регистру
        return ($(b).data('name').toLowerCase()) < ($(a).data('name').toLowerCase()) ? 1 : -1;    
    }

    // кнопка Reset
    $('.soc_reset').on('click', function() {
        $('.soc_reset .fa-refresh').addClass('fa-spin');
        soc_clear_buttons();
        sBlck.sort(sort_by_default).appendTo(shWrap);
        setTimeout(function() {
            $('.soc_reset .fa-refresh').removeClass('fa-spin');
        }, 1000);
    });
    function sort_by_default(a, b){ // возвращаем исходную сортировку
        return ($(b).data('num')) < ($(a).data('num')) ? 1 : -1;    
    }
    
    // очищаем статусы
    function soc_clear_buttons(){
        aAsc.add(aDesc).add(pBttn).add(popBttn).add(instBttn).add(brBttn).add(alphaBttn).removeClass('active');
        aAsc.add(aDesc).removeClass('disabled');
        $('.soc_tl_downloads, .soc_tl_install, .soc_tl_bounce').removeClass('soc_mark');
        $(".soc_wrapper.js_filter_ready [data-price='0']").show();
    }
    
    var count = $(".soc_list .soc_wrapper").children().length;
    if(count > 5){
        $(".soc_list").before('<div class="soc_cnt">Дополнений: '+count+'</div>');
    }
});
})(jQuery);