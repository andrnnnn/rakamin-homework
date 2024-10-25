$(document).ready(function () {
    var $nav = $("nav");
    var $navLinks = $(".navbar-nav .nav-link");

    // Mengatur efek scroll pada navbar
    $(window).on("scroll", function () {
        if ($(this).scrollTop() > 100) {
            $nav.addClass("bg-dark shadow");
        } else {
            $nav.removeClass("bg-dark shadow");
        }
        setActiveLink();
    });

    // Fungsi untuk mengatur kelas aktif
    function setActiveLink() {
        var scrollPosition = $(window).scrollTop() + 100; // Tambahkan offset agar pergantian lebih smooth

        $navLinks.each(function () {
            var $link = $(this);
            var section = $($link.attr("href"));

            // Cek apakah section ada dan apakah posisi scroll berada di dalam section tersebut
            if (section.length && section.offset().top <= scrollPosition && section.offset().top + section.outerHeight() > scrollPosition) {
                $link.addClass("active");
            } else {
                $link.removeClass("active");
            }
        });
    }

    // Tambahkan event listener untuk tautan navbar
    $navLinks.on("click", function () {
        setActiveLink();
    });
});
