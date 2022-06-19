let lat;
let lng;

let url = new URL(window.location.href);
$(function () {
    $("input[name='send']").click(function (e) {
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
        var genre = "";
        $("input[name='genre']:checked").each(function () {
            genre += "," + $(this).data("code");
        });
        if (genre) url.searchParams.append("genre", genre.substring(1));
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
        if (Number($("select[name='range']").val())) {
            // 位置情報取得まで検索不可
            $("input[name='send']").css("pointer-events", "none");
            $(".js_location").html("<div uk-spinner='ratio: 0.6' style='padding-bottom: 3px'></div>");
            getLocation();
        }
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
        // 緯度経度の取得時点で検索可能状態に戻す
        $("input[name='send']").css("pointer-events", "unset");
        setLocationName();
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

function setLocationName() {
    var url = "https://aginfo.cgk.affrc.go.jp/ws/rgeocode.php?lat=" + lat + "&lon=" + lng + "&json";
    $.getJSON(url).done(function (data) {
        // 現在地の表示
        $(".js_location").text(data.result.prefecture.pname + data.result.municipality.mname);
    }).fail(function () {
        // 失敗時：緯度経度表示
        $(".js_location").text("緯度" + lat + "経度" + lng);
    });
}