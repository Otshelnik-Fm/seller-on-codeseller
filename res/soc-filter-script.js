(function($){
$(document).ready(function() {
    
    var aAsc   = $('.fa-sort-amount-asc');
    var aDesc  = $('.fa-sort-amount-desc');
    var pBttn = $('.soc_premium');
    var popBttn = $('.soc_popular');
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

    // вывод попул¤рные
    popBttn.on('click', function() {
        soc_clear_buttons();
        aAsc.add(aDesc).addClass('disabled');
        popBttn.addClass('active');
        sBlck.sort(sort_popular).appendTo(shWrap);
    });
    function sort_popular(a, b){
        return ($(b).data('popular')) > ($(a).data('popular')) ? 1 : -1;    
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
        aAsc.add(aDesc).add(pBttn).add(popBttn).add(alphaBttn).removeClass('active');
        aAsc.add(aDesc).removeClass('disabled');
        $(".soc_wrapper.js_filter_ready [data-price='0']").show();
    }
});
})(jQuery);