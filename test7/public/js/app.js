/**
 * 削除ボタンクリック時の処理
 */
$(document).on("click", "#deleteButton", function(){
    if(window.confirm('削除しますか？')){
        // 削除対象のID
        var id = $(this).closest("td").closest("tr").find("td:eq(0)").html();

        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            type: 'POST',
            url: '/test7/public/destroy' + id
        }).done(function (data) {
            //Ajax通信が成功したときの処理
            searchProducts();
            console.log('削除にてAjax通信に成功しました。');
        }).fail(function () {
            //Ajax通信が失敗したときの処理
            console.log('削除にてAjax通信に失敗しました。');
        })
    }
});

/**
 * 検索ボタンクリック時の処理
 */
$(document).on("click", "#searchButton", function(){
    searchProducts();
});

/**
 * Ajaxによる検索処理
 */
function searchProducts() {
    // 一旦、すべての行を非表示
    $('#resultTable tbody').empty();

    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        type: 'POST',
        url: '/test7/public/products',
        data: {
            'productName': $("#productName").val(),
            'companyName': $("#companyName").val(),
            'priceMin': $("#priceMin").val(),
            'priceMax': $("#priceMax").val(),
            'stockMin': $("#stockMin").val(),
            'stockMax': $("#stockMax").val(),
        },
        dataType: 'json'
    }).done(function (data) {
        //Ajax通信が成功したときの処理
        let tr = '';
        $.each(data, function (index, value) {
            //dataの中身からvalueを取り出す
            let id = value.id;
            let img_path = "<p>no image</p>";
            if(value.img_path !== ''){
                img_path = '<img src="storage/' + value.img_path +'">';
            }
            let product_name = value.product_name;
            let price = value.price;
            let stock = value.stock;
            let comment = "";
            if(value.comment !== null){
                comment = value.comment;
            }
            let company_name = value.company_name;
            
            // 検索結果テーブルに表示する行
            tr = `
                <tr>
                    <td>${id}</td>
                    <td>
                        ${img_path}
                    </td>
                    <td id="resultProductName">${product_name}</td>
                    <td id="resultPrice">${price}</td>
                    <td id="resultStock">${stock}</td>
                    <td>${comment}</td>
                    <td id="resultCompanyName">${company_name}</td>
                    <td><a href="/test7/public/detail/${id}" class="btn btn-primary">詳細表示</a></td>
                    <td><input type="button" class="btn btn-danger" id="deleteButton" value="削除"></td>
                </tr>
            `;
        // 検索結果テーブルに行を追加
        $('#resultTable tbody').append(tr);
        })
        console.log('検索にてAjax通信に成功しました。');
    }).fail(function () {
        //Ajax通信が失敗したときの処理
        console.log('検索にてAjax通信に失敗しました。');
    })
}
