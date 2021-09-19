import { createApp } from 'vue';
import ContactUsForm from './components/ContactUsForm';
import { VueReCaptcha } from 'vue-recaptcha-v3';
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

const app = createApp(ContactUsForm);

app.use(VueReCaptcha, {
  siteKey: window.contact_us_script_data.google_recaptcha_site_key,
  loaderOptions: {
    autoHideBadge: false,
    explicitRenderParameters: {
      badge: 'bottomleft',
      size: 'invisible',
    }
  }
});

app.use(VueSweetalert2);

app.mount('#contact-us');
