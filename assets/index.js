let lat;
let lng;

$(function () {
    $("input[name='send']").click(function (e) {
        var url = new URL(window.location.href);
        // 結果ページのurl追加
        var url_last = url.pathname.split("/").pop();
        if (url_last.includes(".php")) { // urlに.php（ファイルが含まれていたら遷移先urlと置換）
            url.pathname = url.pathname.replace(url_last, "search.php")
        } else {
            url.pathname += "search.php"
        }
        // 各パラメータの付与
        url.search = "";
        var keyword = $("input[name='keyword']").val();
        if (keyword) url.searchParams.append("keyword", keyword);
        var range = $("select[name='range']").val();
        if (Number(range)) {
            url.searchParams.append("lat", lat);
            url.searchParams.append("lng", lng);
            url.searchParams.append("range", range);
        }
        $("input[name='genre']:checked").each(function () {
            url.searchParams.append("genre", $(this).data("code"));
        });
        $("input[name='other']:checked").each(function () {
            url.searchParams.append($(this).data("key"), 1);
        });
        //console.log(url);
        // パラメータが一つでもあれば検索
        if (url.search) location.href = url;
    });
    $("select[name='range']").change(function (e) {
        // 位置情報表記を削除
        $(".js_location").text("");
        // val=0（しない）以外であれば位置情報の取得
        if (Number($("select[name='range']").val())) getLocation();
    });

    // enterキー、スマホ検索ボタン押されたらフォーカス外す（検索ボタンでの検索をさせる為）
    $("input[name='keyword']").keypress(function (e) {
        if (e.which == 13) {
            $("input[name='keyword']").blur();
            return false;
        }
    })
});

function getLocation() {
    // 位置情報を取得する
    navigator.geolocation.getCurrentPosition(function (position) {
        // 成功時処理
        lat = position.coords.latitude;
        lng = position.coords.longitude;
        var url = "http://geoapi.heartrails.com/api/json?method=searchByGeoLocation&x=" + lng + "&y=" + lat;
        $.getJSON(url, (data) => {
            // 現在地の表示
            $(".js_location").text(data.response.location[0].prefecture + data.response.location[0].city + data.response.location[0].town);
        });
    }, function (res) {
        switch (res.code) {
            case 1:
                alert("位置情報の取得を許可してください。");
                break;
            case 2:
            case 3:
                alert("位置情報の取得に失敗しました。");
        }
        $("select[name='range']").val(0);
    });
};