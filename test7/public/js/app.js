function delete_alert(e){
    if(window.confirm('削除しますか？')){
        document.deleteform.submit();
    }
    return false;
};

/**
 * 検索ボタンクリック時の処理
 */
$(document).on("click", "#narrowDownButton", function(){
    // 検索条件
    var productName = $("#productName").val(); // 商品名
    var companyName = $("#companyName").val(); // メーカー名
    var priceMin = $("#priceMin").val(); // 価格(下限)
    var priceMax = $("#priceMax").val(); // 価格(上限)
    var stockMin = $("#stockMin").val(); // 在庫数(下限)
    var stockMax = $("#stockMax").val(); // 在庫数(上限)

    // 一旦、すべての行を表示
    $("#resultTable tbody tr").show();

    // 商品名(部分一致)で絞り込み
    if (productName != "") {
        searchProductName(productName);
    }
    // メーカー名で絞り込み
    if (companyName != "") {
        searchCompanyName(companyName);
    }
    // 価格(下限)で絞り込み
    if (priceMin != "") {
        searchPriceMin(priceMin);
    }
    // 価格(上限)で絞り込み
    if (priceMax != "") {
        searchPriceMax(priceMax);
    }
    // 在庫数(下限)で絞り込み
    if (stockMin != "") {
        searchStockMin(stockMin);
    }
    // 在庫数(上限)で絞り込み
    if (stockMax != "") {
        searchStockMax(stockMax);
    }
});

/**
 * 商品名(部分一致)で絞り込み
 */
function searchProductName(productName) {
    $("#resultTable tbody tr").each(function(){
        // 検索対象の列
        var product = $(this).find("td:eq(2)").html();

        // 一致しない行は非表示
        if (product.indexOf(productName) == -1) {
			$(this).hide();
		}
    });
}

/**
 * メーカー名で絞り込み
 */
function searchCompanyName(companyName) {
    $("#resultTable tbody tr").each(function(){
        // 検索対象の列
        var company = $(this).find("td:eq(6)").html();

        // 一致しない行は非表示
        if (company != companyName) {
			$(this).hide();
		}
    });
}

/**
 * 価格(下限)で絞り込み
 */
function searchPriceMin(priceMin) {
    $("#resultTable tbody tr").each(function(){
        // 検索対象の列
        var price = $(this).find("td:eq(3)").html();

        // 一致しない行は非表示
        if (Number(price) < priceMin) {
			$(this).hide();
		}
    });
}

/**
 * 価格(上限)で絞り込み
 */
function searchPriceMax(priceMax) {
    $("#resultTable tbody tr").each(function(){
        // 検索対象の列
        var price = $(this).find("td:eq(3)").html();

        // 一致しない行は非表示
        if (Number(price) > priceMax) {
			$(this).hide();
		}
    });
}

/**
 * 在庫数(下限)で絞り込み
 */
function searchStockMin(stockMin) {
    $("#resultTable tbody tr").each(function(){
        // 検索対象の列
        var stock = $(this).find("td:eq(4)").html();

        // 一致しない行は非表示
        if (Number(stock) < stockMin) {
			$(this).hide();
		}
    });
}

/**
 * 在庫数(上限)で絞り込み
 */
function searchStockMax(stockMax) {
    $("#resultTable tbody tr").each(function(){
        // 検索対象の列
        var stock = $(this).find("td:eq(4)").html();

        // 一致しない行は非表示
        if (Number(stock) > stockMax) {
			$(this).hide();
		}
    });
}

/**
 * 削除ボタンクリック時の処理
 */
$(document).on("click", "#deleteButton", function(){
    if(window.confirm('削除しますか？')){
        // その行を非表示
        $(this).closest("td").closest("tr").hide();
    }
});