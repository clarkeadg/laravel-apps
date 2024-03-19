
const photosCarousel = () => {
  $(".photos-slider").slick({
    dots: false,
    infinite: false,
    speed: 500,
    autoplay: false,
    autoplaySpeed: 5000,
    slidesToShow: 6,
    slidesToScroll: 6,
    responsive: [
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 3
        }
      },
      {
        breakpoint: 768,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1,
          //arrows: false
        }
      }
    ]
  });
  
  let slider;
  const $modal = $("#photosModal");

  $(".photos-slider-card").on("click",(e) => {
    e.preventDefault();
    $modal.show();
    const index = +$(e.currentTarget).attr("data-index");
    if (!slider) {
      slider = $(".photos-slider-big").slick({
        dots: false,
        infinite: false,
        autoplay: false,
        slidesToShow: 1,
        slidesToScroll: 1,
        initialSlide: index
      });
    } else {
      slider.slick('slickGoTo', index, true);
    }
  });

  $("#closePhotosModal").on("click",(e) => {
    e.preventDefault();
    $modal.hide();
  });
}

export default photosCarousel;
