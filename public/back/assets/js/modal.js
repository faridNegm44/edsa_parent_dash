$((function() {
    "use strict";
    $(".modal-effect").on("click", (function(t) {
        t.preventDefault();
        var e = $(this).attr("data-effect");
        $("#modaldemo8").addClass(e)
    })), $("#modaldemo8").on("hidden.bs.modal", (function(t) { $(this).removeClass((function(t, e) { return (e.match(/(^|\s)effect-\S+/g) || []).join(" ") })) }))
}));