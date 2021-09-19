<template>
    <Form v-on:submit="onSubmit" v-bind:validation-schema="schema" v-slot="{ errors }">
      <div class="grid grid-cols-12 gap-y-[30px] gap-x-0 xl:gap-x-[30px]">
        <div class="col-span-12">
          <label for="name" class="block font-primary font-bold text-[16px] text-black pb-[5px]">{{contact_label_1 }}</label>
          <Field type="text" name="name" id="name" class="bg-gray-100 text-black w-full h-[40px] px-[15px] border-[1px] border-gray-100 rounded-[5px] outline-none transition-all ease-in-out duration-300 focus:border-dml-blue"/>
          <ErrorMessage name="name" class="block font-primary text-[12px] text-red-500 pt-[5px]"/>
        </div>
        <div class="col-span-12 xl:col-span-6">
          <label for="phone" class="block font-primary font-bold text-[16px] text-black pb-[5px]">{{contact_label_2 }}</label>
          <Field type="text" name="phone" id="phone" class="bg-gray-100 text-black w-full h-[40px] px-[15px] border-[1px] border-gray-100 rounded-[5px] outline-none transition-all ease-in-out duration-300 focus:border-dml-blue"/>
          <ErrorMessage name="phone" class="block font-primary text-[12px] text-red-500 pt-[5px]"/>
        </div>
        <div class="col-span-12 xl:col-span-6">
          <label for="email" class="block font-primary font-bold text-[16px] text-black pb-[5px]">{{ contact_label_3 }}</label>
          <Field type="email" name="email" id="email" class="bg-gray-100 text-black w-full h-[40px] px-[15px] border-[1px] border-gray-100 rounded-[5px] outline-none transition-all ease-in-out duration-300 focus:border-dml-blue"/>
          <ErrorMessage name="email" class="block font-primary text-[12px] text-red-500 pt-[5px]"/>
        </div>
        <div class="col-span-12">
          <label for="message" class="block font-primary font-bold text-[16px] text-black pb-[5px]">{{ contact_label_4 }}</label>
          <Field as="textarea" name="message" id="message" class="bg-gray-100 text-black w-full px-[15px] border-[1px] border-gray-100 rounded-[5px] outline-none transition-all ease-in-out duration-300 focus:border-dml-blue" v-bind:rows="6"></Field>
          <ErrorMessage name="message" class="block font-primary text-[12px] text-red-500 pt-[5px]"/>
        </div>
        <div class="col-span-12 flex items-center justify-end">
          <svg v-if="loading" class="animate-spin text-black w-[20px] h-[20px] mr-[15px]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-[25%]" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-[75%]" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
          </svg>
          <button type="submit" class="cursor-pointer font-secondary font-extrabold italic no-underline font-bold text-[16px] text-white bg-dml-blue text-center py-[15px] px-[30px] border-1 border-dml-blue rounded-[5px] shadow-md transition-all ease-in-out duration-300 hover:text-dml-blue hover:bg-white hover:shadow-xl">
            {{ contact_label_submit }}
          </button>
        </div>
      </div>
    </Form>
</template>
<script>
import { Form, Field, ErrorMessage } from 'vee-validate';
import * as yup from 'yup';
import axios from 'axios';

export default {
  name: 'ContactUsForm',
  components: {
    Form,
    Field,
    ErrorMessage,
  },
  data () {
    return {
      wp_ajax: window.contact_us_script_data.wp_ajax,
      wp_nonce: window.contact_us_script_data.wp_nonce,
      wp_action: 'submit_contact_us_form',
      recaptcha_token: '',
      loading: false,
      contact_label_1: window.contact_us_script_data.contact_label_1,
      contact_label_2: window.contact_us_script_data.contact_label_2,
      contact_label_3: window.contact_us_script_data.contact_label_3,
      contact_label_4: window.contact_us_script_data.contact_label_4,
      contact_error_1: window.contact_us_script_data.contact_error_1,
      contact_error_2: window.contact_us_script_data.contact_error_2,
      contact_error_3: window.contact_us_script_data.contact_error_3,
      contact_error_4: window.contact_us_script_data.contact_error_4,
      contact_error_5: window.contact_us_script_data.contact_error_5,
      contact_label_submit: window.contact_us_script_data.contact_label_submit,
      contact_submission_succeeded: window.contact_us_script_data.contact_submission_succeeded,
      contact_submission_failed: window.contact_us_script_data.contact_submission_failed,
      schema: yup.object({
        name: yup.string().required(window.contact_us_script_data.contact_error_1),
        phone: yup.string().required(window.contact_us_script_data.contact_error_2),
        email: yup.string().required(window.contact_us_script_data.contact_error_3).email(window.contact_us_script_data.contact_error_4),
        message: yup.string().required(window.contact_us_script_data.contact_error_5),
      }),
    };
  },
  methods: {
    async onSubmit (values, {resetForm}) {
      this.loading = true;
      await this.$recaptchaLoaded();
      this.recaptcha_token = await this.$recaptcha(this.wp_action);
      let formData = new FormData();
      formData.append('wp_nonce', this.wp_nonce);
      formData.append('action', this.wp_action);
      formData.append('recaptcha_token', this.recaptcha_token);
      formData.append('name', values.name);
      formData.append('phone', values.phone);
      formData.append('email', values.email);
      formData.append('message', this.message);
      axios({
        method: 'POST',
        url: this.wp_ajax,
        headers: {
          'Content-Type': 'multipart/form-data'
        },
        data: formData,
      }).then(() => {
        resetForm();
        this.$swal('Sent', this.contact_submission_succeeded, 'success');
        this.loading = false;
      }).catch(() => {
        this.$swal('Error', this.contact_submission_failed, 'error');
        this.loading = false;
      });
    },
  }
};
</script>
