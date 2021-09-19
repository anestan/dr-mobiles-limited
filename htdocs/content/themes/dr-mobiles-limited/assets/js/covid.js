import Swiper, { Autoplay, Pagination } from 'swiper';
import 'swiper/css/bundle';

let swiper_covid = new Swiper('.swiper-covid', {
  modules: [Autoplay, Pagination],
  slidesPerView: 1,
  loop: true,
  autoplay: {
    delay: 3000,
    disableOnInteraction: false,
  },
  speed: 1000,
  pagination: {
    el: '.swiper-pagination',
    clickable: true,
  },
});
