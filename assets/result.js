if (url.searchParams.has("lat") && url.searchParams.has("lng")) {
    lat = url.searchParams.get("lat");
    lng = url.searchParams.get("lng");
    setLocationName();
}
var conditions = "";
// 0（しない）以外
if (Number($("select[name='range']").val())) {
    $(".js_conditions").append('<span class="uk-label uk-margin-small-right uk-margin-small-bottom">' + $("select[name='range'] option:selected").text() + '付近</span>');
}
$("input[name='genre']:checked").each(function () {
    conditions += " " + $(this).val();
    $(".js_conditions").append('<span class="uk-label uk-margin-small-right uk-margin-small-bottom">' + $(this).val() + '</span>');
});
$("input[name='other']:checked").each(function () {
    conditions += " " + $(this).val();
    $(".js_conditions").append('<span class="uk-label uk-margin-small-right uk-margin-small-bottom">' + $(this).val() + '</span>');
});

$(function () {
    $(".js_back, .js_next").click(function (e) {
        var page = 1;
        if ($(this).hasClass("js_back")) {
            page = Number($(".js_now").text()) - 1;
        } else {
            page = Number($(".js_now").text()) + 1;
        }
        if (url.searchParams.has("p")) {
            url.searchParams.set("p", page);
        } else {
            url.searchParams.append("p", page);
        }
        location.href = url;
    });
});