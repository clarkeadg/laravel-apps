
const heroCarousel = () => {
  $(".hero-slider").slick({
    dots: false,
    infinite: true,
    speed: 500,
    autoplay: true,
    autoplaySpeed: 5000,
    slidesToShow: 1,
    slidesToScroll: 1
  });
}

export default heroCarousel;
