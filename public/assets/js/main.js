var leaderboard = "includes/board.php";

$("#leaderboard").load(leaderboard);

$("#search-player").on("keyup", function() {
  var b = $(this).val().toLowerCase();
  $("table tr").each(function(c) {
    0 != c && ($row = $(this), 0 == $row.find("td:first").text().toLowerCase().indexOf(b) ? $(this).show() : $(this).hide())
  })
})

$('input#mode').on('change', function() {
  if ($(this).is(":checked")) {
    var b = $(this).val();
    $("#leaderboard").load(leaderboard, {
      mode: b
    }, function() {
      $("#search-player").keyup()
    })
  }
  $('input#mode').not(this).prop('checked', false);
});

jQuery.fn.addSortWidget = function(b) {
  b = $.extend({}, {
    img_asc: "img/asc_sort.gif",
    img_desc: "img/desc_sort.gif",
    img_nosort: "img/no_sort.gif"
  }, b);
  var c = $(this),
    d = !0;
  return $("th", c).each(function(f) {
    $("<img>").attr("src", b.img_nosort).addClass("sorttable_img").css({
      cursor: "pointer",
      "margin-left": "10px"
    }).on("click", function() {
      $(".sorttable_img", c).attr("src", b.img_nosort), $(this).attr("src", d ? b.img_desc : b.img_asc), d = !d;
      var g = $("tr", c).not(":has(th)").get();
      g.sort(function(k, l) {
        var m = $("td:eq(" + f + ")", k).text(),
          n = $("td:eq(" + f + ")", l).text();
        return d ? m.localeCompare(n) : n.localeCompare(m)
      });
      for (var h = c.has("tbody") ? "tbody" : "", j = 0; j < g.length; j++) $(h, c).append(g[j])
    }).appendTo(this)
  }), c
};
