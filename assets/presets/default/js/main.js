(function ($) {
  "use strict";
  //============================ Scroll To Top Js Start ========================
  var btn = $(".scroll-top");

  $(window).on("scroll", function () {
    if ($(window).scrollTop() > 300) {
      btn.addClass("show");
    } else {
      btn.removeClass("show");
    }
  });

  btn.on("click", function (e) {
    e.preventDefault();
    $("html, body").animate({
        scrollTop: 0,
      },
      "300"
    );
  });
  //============================ Scroll To Top Js End ========================

  // ========================= Header Sticky Js Start ==============
  $(window).on("scroll", function () {
    if ($(window).scrollTop() >= 300) {
      $(".header__area").addClass("fixed-header");
    } else {
      $(".header__area").removeClass("fixed-header");
    }
  });
  // ========================= Header Sticky Js End===================

  //============================ Offcanvas Js Start ============================
  $(document).on("click", ".menu__open", function () {
    $(".offcanvas__area, .overlay").addClass("active");
  });

  $(document).on("click", ".menu__close, .overlay", function () {
    $(".offcanvas__area, .overlay").removeClass("active");
  });

  //============================ Offcanvas Js End ==============================

  // ========================== Add Attribute For Bg Image Js Start =====================
  $(".bg--img").css("background-image", function () {
    var bg = "url(" + $(this).data("background-image") + ")";
    return bg;
  });
  // ========================== Add Attribute For Bg Image Js End =====================


  // Testimonial start ==============================
  var TestimonialSwiper = new Swiper(".mySwiper", {
    slidesPerView: 1,
    loop: true,
    spaceBetween: 30,
    autoplay: {
      delay: 2500,
      disableOnInteraction: false,
    },
    breakpoints: {
      768: {
        slidesPerView: 2,
        spaceBetween: 40,
      },
    },
  });

  // Testimonial ends =============================

  // brand slider
  var brandSwiper = new Swiper(".brand-slider", {
    loop: true,
    slidesPerView: 'auto',
    centeredSlides: true,
    allowTouchMove: false,
    spaceBetween: 60,
    speed: 2000,
    autoplay: {
      delay: 0,
      disableOnInteraction: false,
    },
  });

  // brand slider

  // ========================= Odometer Js Start ===================
  if ($(".odometer").length > 0) {
    $(window).on("scroll", function () {
      $(".odometer").each(function () {
        if ($(this).isInViewport()) {
          if (!$(this).data("odometer-started")) {
            $(this).data("odometer-started", true);
            this.innerHTML = $(this).data("odometer-final");
          }
        }
      });
    });
  }
  // isInViewport helper function
  $.fn.isInViewport = function () {
    let elementTop = $(this).offset().top;
    let elementBottom = elementTop + $(this).outerHeight();
    let viewportTop = $(window).scrollTop();
    let viewportBottom = viewportTop + $(window).height();
    return elementBottom > viewportTop && elementTop < viewportBottom;
  };
  // ========================= Odometer Js End ===================


  // ========================= Show Hide Password Js Start ===================
  if ($(".password-show-hide").length) {
    $(".password-show-hide").each(function () {
      let container = $(this);
      let inputField = container.closest(".form-floating").find("input");
      let showIcon = container.find(".open-eye-icon");
      let hideIcon = container.find(".close-eye-icon");
      showIcon.show();
      hideIcon.hide();
      showIcon.on("click", function () {
        inputField.attr("type", "text");
        showIcon.hide();
        hideIcon.show();
      });
      hideIcon.on("click", function () {
        inputField.attr("type", "password");
        hideIcon.hide();
        showIcon.show();
      });
    });
  }
  // ========================= Show Hide Password Js End ===================


  // ========================= Scroll Reveal Js Start ===================
  const sr = ScrollReveal({
    origin: "top",
    distance: "60px",
    duration: 1500,
    delay: 100,
    reset: false,
  });

  sr.reveal(".hero-left__image, .hero-right__image, .about-thumb, .cta-thumb, .faq-thumb, .google-maps", {
    delay: 60,
    origin: "top",
  });

  sr.reveal(".hero-item, .brand-items, .about-content, .cta-content, .cta-right, .section-heading, .mySwiper, .contact-main__items, .contact-info, .news", {
    delay: 60,
    origin: "bottom",
  });

  sr.reveal(".work-items, .accordion-item", {
    delay: 60,
    interval: 100,
    origin: "bottom",
  });
  // ========================= Scroll Reveal Js End ===================

  // ========================== Table Data Label Js Start =====================
  Array.from(document.querySelectorAll("table")).forEach((table) => {
    let heading = table.querySelectorAll("thead tr th");
    Array.from(table.querySelectorAll("tbody tr")).forEach((row) => {
      let columArray = Array.from(row.querySelectorAll("td"));
      if (columArray.length <= 1) return;
      columArray.forEach((colum, i) => {
        colum.setAttribute("data-label", heading[i].innerText);
      });
    });
  });
  // ========================== Table Data Label Js End =====================

  // ========================= Filter Js Start ===================

  $(document).on("click", ".filter__btn", function () {
    $(".filter__main, .overlay").addClass("active");
  });

  // Filter Close
  $(document).on("click", ".filter__close, .overlay", function () {
    $(".filter__main, .overlay").removeClass("active");
  });

  // ========================= Filter Js End ===================

  // ========================== Label Required Js Start =====================
  $.each($("input, select, textarea"), function (i, element) {
    if (element.hasAttribute("required")) {
      $(element)
        .closest(".form-group")
        .find("label")
        .first()
        .addClass("required");
    }
  });
  // ========================== Label Required Js End =====================

  // ========================= Preloader Js Start =====================
  $(window).on("load", function () {
    $(".preloader").fadeOut();
  });
  // ========================= Preloader Js End=====================
})(jQuery);