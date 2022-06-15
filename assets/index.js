$(function () {
    $("input[name='send']").click(function (e) {
        var url = new URL(window.location.href);
        // 結果ページのurl追加
        url.href += "search.php";
        // 各パラメータの付与
        var keyword = $("input[name='keyword']").val();
        if (keyword) url.searchParams.append("keyword", keyword);
        $(":checkbox[name='genre']:checked").each(function () {
            url.searchParams.append("genre", $(this).data("code"));
        });
        $(":checkbox[name='other']:checked").each(function () {
            url.searchParams.append($(this).data("key"), 1);
        });
        location.href = url;
    });
    $("input[name='range']").change(function (e) {
        window.location.href = '/';
    });

    // enterキー、スマホ検索ボタン押されたらフォーカス外す（検索ボタンでの検索をさせる為）
    $("input[name='keyword']").keypress(function (e) {
        if (e.which == 13) {
            $("input[name='keyword']").blur();
            return false;
        }
    })

});