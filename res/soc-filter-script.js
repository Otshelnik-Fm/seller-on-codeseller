(function($){
$(document).ready(function() {
    
    var amountAsc   = $('.fa-sort-amount-asc');
    var amountDesc  = $('.fa-sort-amount-desc');
    var premiumBttn = $('.soc_premium');
    var popularBttn = $('.soc_popular');
    var alphaBttn   = $('.soc_alphabet');
    
    var shipWrapper = $('.soc_wrapper.js_filter_ready');
    var socBlock    = $('.js_filter_ready .soc_blk');
    
    // вывод по уменьшению цены
    amountDesc.on('click', function(e) {
        amountAsc.removeClass('active');
        amountDesc.addClass('active');
        socBlock.sort(sort_desc).appendTo(shipWrapper);
    });
    function sort_desc(a, b){
        return ($(b).data('price')) > ($(a).data('price')) ? 1 : -1;    
    }
    
    // по увеличению цены
    amountAsc.on('click', function(e) {
        amountDesc.removeClass('active');
        amountAsc.addClass('active');
        socBlock.sort(sort_asc).appendTo(shipWrapper);
    });
    function sort_asc(a, b){ // от меньшего к большему
        return ($(b).data('price')) < ($(a).data('price')) ? 1 : -1;    
    }

    // вывод премиум
    premiumBttn.on('click', function(e) {
        soc_clear_buttons();
        premiumBttn.addClass('active');
        $(".soc_wrapper.js_filter_ready [data-price='0']").hide();
    });

    // вывод попул¤рные
    popularBttn.on('click', function(e) {
        soc_clear_buttons();
        amountAsc.add(amountDesc).addClass('disabled');
        popularBttn.addClass('active');
        socBlock.sort(sort_popular).appendTo(shipWrapper);
    });
    function sort_popular(a, b){
        return ($(b).data('popular')) > ($(a).data('popular')) ? 1 : -1;    
    }

    //  вывод по алфавиту
    alphaBttn.on('click', function(e) {
        soc_clear_buttons();                                // очищаем статусы
        amountAsc.add(amountDesc).addClass('disabled');     // отключаем фильтры
        alphaBttn.addClass('active');                       // активируем нашу кнопу
        socBlock.sort(sort_alphabet).appendTo(shipWrapper); // сортировка
    });
    function sort_alphabet(a, b){ // сортировка нечувствительна к регистру
        return ($(b).data('name').toLowerCase()) < ($(a).data('name').toLowerCase()) ? 1 : -1;    
    }

    // кнопка Reset
    $('.soc_reset').on('click', function(e) {
        $('.soc_reset .fa-refresh').addClass('fa-spin');
        soc_clear_buttons();
        socBlock.sort(sort_by_default).appendTo(shipWrapper);
        setTimeout(function() {
            $('.soc_reset .fa-refresh').removeClass('fa-spin');
        }, 1000);
    });
    function sort_by_default(a, b){ // возвращаем исходную сортировку
        return ($(b).data('num')) < ($(a).data('num')) ? 1 : -1;    
    }
    
    // очищаем статусы
    function soc_clear_buttons(){
        amountAsc.add(amountDesc).add(premiumBttn).add(popularBttn).add(alphaBttn).removeClass('active');
        amountAsc.add(amountDesc).removeClass('disabled');
        $(".soc_wrapper.js_filter_ready [data-price='0']").show();
    }
});
})(jQuery);