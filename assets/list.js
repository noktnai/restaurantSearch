$(function () {
    // 検索結果に検討リスト登録済みの店舗がアイコンの変更
    Object.keys(localStorage).forEach(function (key) {
        $(".js_addlist").filter(function () {
            return ($(this).data("id") == key)
        }).toggleClass("js_addlist js_removelist").children("span").attr("uk-icon", "icon: trash; ratio: 0.8").next("strong").text("検討リストから削除");
    });

    // 検討リストに遷移（postデータ付与）
    $(".js_tolist").click(function (e) {
        var param = "";
        Object.keys(localStorage).forEach(function (key, index) {
            if (index !== 0) param += ",";
            param += key;
        });
        $("input[name='id']").val(param);
        $("form").submit();
    });

    // 検討リストに追加
    $("body").on("click", ".js_addlist", function () {
        localStorage.setItem($(this).data("id"), Date.now());
        // 10個以上で古いもの削除
        if (localStorage.length > 10) listPop();
        $(this).children("span").attr("uk-icon", "icon: trash").next("strong").text("検討リストから削除");
        $(this).toggleClass("js_addlist js_removelist");
    });

    // 検討リストから削除
    $("body").on("click", ".js_removelist", function () {
        localStorage.removeItem($(this).data("id"));
        $(this).children("span").attr("uk-icon", "icon: star").next("strong").text("検討リストに追加")
        $(this).toggleClass("js_addlist js_removelist");
    });
});

/**
 * 保存日の一番古いものを削除
 */
function listPop() {
    var temp = { key: "", value: "" };
    Object.keys(localStorage).forEach(function (key, index) {
        if (index === 0) {
            temp = { key: key, value: localStorage.getItem(key) }
        } else {
            if (Number(localStorage.getItem(key)) < Number(temp.value)) {
                temp = { key: key, value: localStorage.getItem(key) }
            }
        };
    });
    localStorage.removeItem(temp.key);
}