(function($) {
    // "use strict";

    function responsive_dropdown() {
        /* ---- For Mobile Menu Dropdown JS Start ---- */
        $('#menu span.opener').on("click", function() {
            if ($(this).hasClass("plus")) {
                $(this).parent().find('.mobile-sub-menu').slideDown();
                $(this).removeClass('plus');
                $(this).addClass('minus');
            } else {
                $(this).parent().find('.mobile-sub-menu').slideUp();
                $(this).removeClass('minus');
                $(this).addClass('plus');
            }
            return false;
        });
        /* ---- For Mobile Menu Dropdown JS End ---- */

        /*---Mobile menu icon Start---*/
        var navbar_toggle = $('.navbar-toggle i');
        var menu_var = $('#menu');
        $('.navbar-toggle').on("click", function() {

            if (menu_var.hasClass('menu-open')) {
                menu_var.removeClass('menu-open');
                navbar_toggle.removeClass('fa-close');
                navbar_toggle.addClass('fa-bars');
            } else {
                menu_var.addClass('menu-open');
                navbar_toggle.addClass('fa-close');
                navbar_toggle.removeClass('fa-bars');
            }
            return false;
        });
        /*---Mobile menu icon End---*/

        /* ---- For Sidebar JS Start ---- */
        $(document).on("click", '.sidebar-box span.opener', function() {

            if ($(this).hasClass("plus")) {
                $(this).parent().find('.sidebar-contant').slideDown();
                $(this).removeClass('plus');
                $(this).addClass('minus');
            } else {
                $(this).parent().find('.sidebar-contant').slideUp();
                $(this).removeClass('minus');
                $(this).addClass('plus');
            }
            return false;
        });
        /* ---- For Sidebar JS End ---- */
        /* ---- For Footer JS Start ---- */
        $('.footer-static-block span.opener').on("click", function() {

            if ($(this).hasClass("plus")) {
                $(this).parent().find('.footer-block-contant').slideDown();
                $(this).removeClass('plus');
                $(this).addClass('minus');
            } else {
                $(this).parent().find('.footer-block-contant').slideUp();
                $(this).removeClass('minus');
                $(this).addClass('plus');
            }
            return false;
        });
        /* ---- For Footer JS End ---- */
    }

    function search_open() {
        /* ----- Search open close Start  ------ */
        $('.search-opener').on("click", function() {
            var search_bar = $('.top-search-bar');
            if (search_bar.hasClass('open')) {
                search_bar.removeClass('open');
            } else {
                search_bar.addClass('open');
            }
            return false;
        });
        /* ----- Search open close Start  ------ */
    }

    function owlcarousel_slider() {
        /* ------------ OWL Slider Start  ------------- */

        /* ----- pro_cat_slider Start  ------ */
        $(".pro_cat_slider").owlCarousel({
            items: 6,
            nav: true,
            dots: false,
            loop: false,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 1,
                },
                768: {
                    items: 2,
                },
                992: {
                    items: 3,
                },
                1200: {
                    items: 4,
                },
            },
        });
        /* ----- pro_cat_slider End  ------ */

        /* ----- sub_menu_slider Start  ------ */
        $('.sub_menu_slider').owlCarousel({
            items: 1,
            nav: false,
            dots: false,
            loop: true,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 1,
                },
                468: {
                    items: 1,
                },
                768: {
                    items: 1,
                },
                1200: {
                    items: 1,
                }
            }
        });
        /* -----sub_menu_slider End  ------ */

        /* ---- main-banner Testimonial Start ---- */
        $(".main-banner, #client").owlCarousel({

            //navigation : true,  Show next and prev buttons
            items: 1,
            nav: true,
            slideSpeed: 5000,
            paginationSpeed: 400,
            loop: true,
            autoplay: true,
            autoplaySpeed: 1000,
            dots: true,
            singleItem: true,
            // nav:true
        });
        
        //        Lucas
        $('.picto2').owlCarousel({
            loop:false,
            margin:5,
            nav:false,
            autoplay: true,
            dots:false,
            responsive:{
                0:{
                    items:3
                },
                600:{
                    items:3
                },
                1000:{
                    items:3
                }
            }
        });
        /* ----- main-banner Testimonial End  ------ */
        return false;
        /* ------------ OWL Slider End  ------------- */
    }

    function scrolltop_arrow() {
        /* ---- Page Scrollup JS Start ---- */
        //When distance from top = 250px fade button in/out
        var scrollup = $('#scrollup');
        var headertag = $('header');
        var mainfix = $('.main');
        $(window).scroll(function() {
            if ($(this).scrollTop() > 250) {
                scrollup.fadeIn(300);
            } else {
                scrollup.fadeOut(300);
            }

            /* header-fixed JS Start */
            // if ($(this).scrollTop() > 100){
            //    headertag.addClass("header-fixed");
            // }
            // else{ 
            //    headertag.removeClass("header-fixed");
            // }

            /* main-fixed JS Start */
            if ($(this).scrollTop() > 0) {
                mainfix.addClass("main-fixed");
            } else {
                mainfix.removeClass("main-fixed");
            }
            /* ---- Page Scrollup JS End ---- */
        });

        //On click scroll to top of page t = 1000ms
        scrollup.on("click", function() {
            $("html, body").animate({ scrollTop: 0 }, 1000);
            return false;
        });
    }

    function custom_tab() {
        /* ------------ Account Tab JS Start ------------ */
        $('.account-tab-stap').on('click', 'li', function() {
            $('.account-tab-stap li').removeClass('active');
            $(this).addClass('active');

            $(".account-content").fadeOut();
            var currentLiID = $(this).attr('id');
            $("#data-" + currentLiID).fadeIn();
            return false;
        });
        /* ------------ Account Tab JS End ------------ */
    }

    /* Price-range Js Start */
    function price_range() {
        $("#slider-range").slider({
            range: true,
            min: 0,
            max: 800,
            values: [75, 500],
            slide: function(event, ui) {
                $("#amount").val("$" + ui.values[0] + " - $" + ui.values[1]);
            }
        });
        $("#amount").val("$" + $("#slider-range").slider("values", 0) +
            " - $" + $("#slider-range").slider("values", 1));
    }
    /* Price-range Js End */

    /* Product Detail Page Tab JS Start */
    function description_tab() {
        $("#tabs li a").on("click", function(e) {
            var title = $(e.currentTarget).attr("title");
            $("#tabs li a , .tab_content li div").removeClass("selected")
            $(".tab-" + title + ", .items-" + title).addClass("selected")
            $("#items").attr("class", "tab-" + title);

            return false;
        });
    }

    $('.search-closer').hide();

    $(document).on('keyup', function(e) {
        if (e.keyCode == 27 || e.keyCode == 'Escape') {
            $('.search-closer').click();
        }
    });

    $('li.search-box').on('click', function() {
        $('li.search-box').hide();
        $('.search-closer').show();
        $('.sidebar-search-wrap').addClass('open').siblings().removeClass('open');
        return false;
    });

    /*Search-box-close-button*/

    $('.search-closer').on('click', function() {
        $('.search-closer').hide();
        $('li.search-box').show();
        var sidebar = $('.sidebar-navigation');
        var nav_icon = $('.navbar-toggle i');
        if (sidebar.hasClass('open')) {
            // sidebar.removeClass('open');
        } else {
            sidebar.addClass('open');
            nav_icon.addClass('fa-search-close');
            nav_icon.removeClass('fa-search-bars');
        }

        $('.sidebar-search-wrap').removeClass('open');
        return false;
    });

    function magnific_popup_image() {
        $('.popup-gallery').magnificPopup({
            delegate: 'a',
            type: 'image',
            tLoading: 'Loading image #%curr%...',
            mainClass: 'mfp-img-mobile',
            gallery: {
                enabled: false,
                navigateByImgClick: true,
                preload: [0, 1] // Will preload 0 - before current, and 1 after the current image
            },
            image: {
                tError: '<a href="%url%">The image #%curr%</a> could not be loaded.'
            }
        });
    }

    function dropdowns() {
        var width = $(window).width();
        if (width > 990) {
            $(window).click(function() {
                if ($(".nav>li.level.dropdown>a").hasClass("open")) {
                    $(".nav>li.level.dropdown>a").siblings(".megamenu").hide();
                    $(".nav>li.level.dropdown>a").removeClass("open");
                }
            });
            $(".nav>li.level.dropdown>a").click(function(e) {
                e.preventDefault();
                e.stopPropagation();
                $(this).parent().siblings('.dropdown').children('.megamenu').hide();
                $(this).siblings(".megamenu").toggle();
                if ($(this).hasClass("open")) {
                    $(this).removeClass("open");
                } else {
                    $(this).addClass("open");
                }
            });
        }
    }

    $(window).resize(function() {
        dropdowns();
    });


    /* Product Detail Page Tab JS End */
    $(document).on("ready", function() {
        owlcarousel_slider();
        price_range();
        responsive_dropdown();
        description_tab();
        custom_tab();
        scrolltop_arrow();
        search_open();
        magnific_popup_image();
        dropdowns();
        
        /***
         <!-- Bouton de téléchargement 
                                                            <button id="download-btn" class="btn btn-color">Télécharger la fiche technique</button>

                                                            <!-- Modal pour entrer l'email -->
                                                            <div id="email-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="emailModalLabel" aria-hidden="true">
                                                              <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                  <div class="modal-header">
                                                                    <h5 class="modal-title" id="emailModalLabel">Entrez votre email</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                      <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                  </div>
                                                                  <div class="modal-body">
                                                                    <label for="email">Entrez votre email :</label>
                                                                    <input type="email" id="email" class="form-control" required>
                                                                    
                                                                    <!-- Case à cocher pour accepter la politique de confidentialité -->
                                                                        <div>
                                                                            <input type="checkbox" id="privacy-policy" required>
                                                                            <label for="privacy-policy">J'accepte la <a href="#" target="_blank">politique de confidentialité</a>.</label>
                                                                        </div>
                                                                    
                                                                  </div>
                                                                  <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                                                                    <button id="submit-email" class="btn btn-primary" disabled>Envoyer</button>
                                                                  </div>
                                                                </div>
                                                              </div>
                                                            </div>

                                                            <!-- Lien pour le téléchargement -->
                                                            <a id="download-link" href="{{ product.field_fiche|field_value }}" download style="display: none;"></a>
         * 
         */
        
        document.getElementById('privacy-policy').addEventListener('change', function () {
            // Active ou désactive le bouton Envoyer selon l'état de la case à cocher
            var submitButton = document.getElementById('submit-email');
            submitButton.disabled = !this.checked;
        });
        
        document.getElementById('download-btn').addEventListener('click', function () {
            // Afficher le modal
            $('#email-modal').modal('show');
        });

        document.getElementById('submit-email').addEventListener('click', function () {
            var email = document.getElementById('email').value;
            var fileUrl = document.getElementById('download-link').getAttribute('href'); // Récupère le lien du fichier

            // Validation de l'email
            var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
            if (emailPattern.test(email)) {
                // Si l'email est valide, envoyer les données
                fetch('https://somalaval-ai.xnr.afb.mybluehost.me/mail/store_email.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: 'email=' + encodeURIComponent(email) + '&file_url=' + encodeURIComponent(fileUrl)
                }).then(response => response.text())
                .then(data => {
                    console.log('Votre email a été enregistré. Le téléchargement va commencer.');
                    $('#email-modal').modal('hide'); // Fermer le modal
                    document.getElementById('download-link').click(); // Lancer le téléchargement
                })
                .catch(error => {
                    $('#email-modal').modal('hide');
                    console.error('Erreur :', error);
                });
            } else {
                // Afficher un message d'erreur si l'email est invalide
                console.log('Veuillez entrer un email valide.');
                alert("Veuillez entrer un email valide.");
            }
        });

        
    });

    $(window).on("load", function() {
        // Animate loader off screen
        $(".se-pre-con").fadeOut("slow");
    });
})(jQuery);