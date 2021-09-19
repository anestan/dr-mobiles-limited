@extends('layouts.main')

@section('content')
    <section class="h-[50vh]">
        <iframe class="w-full h-full" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3195.245009870064!2d{{ get_field('google_maps_longitude') }}!3d{{ get_field('google_maps_latitude') }}!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6d0d39d65211effb%3A0xaf55d06cbff09561!2sDr+Mobiles+Limited!5e0!3m2!1sen!2smy!4v1532858801107">
        </iframe>
    </section>
    <section class="bg-covid-yellow  h-[50vh] py-[50px] mb-[50px] md:mb-[100px] relative">
        <div class="swiper swiper-covid h-full">
            <div class="swiper-wrapper h-full">
                <div class="swiper-slide swiper-lazy flex justify-center h-full">
                    <img src="{{ get_field('covid_image_1', 'options')['url'] }}" alt="{{  get_field('covid_image_1', 'options')['alt'] }}" loading="lazy" class="object-contain object-center h-full shadow-md">
                </div>
                <div class="swiper-slide swiper-lazy flex justify-center h-full">
                    <img src="{{ get_field('covid_image_2', 'options')['url'] }}" alt="{{  get_field('covid_image_2', 'options')['alt'] }}" loading="lazy" class="object-contain object-center h-full shadow-md">
                </div>
            </div>
        </div>
        <div class="swiper-pagination absolute z-[10] bottom-[5px]"></div>
    </section>
    <section class="container pb-[50px] md:pb-[100px] px-[15px] mx-auto">
        <h1 class="font-primary text-[40px] md:text-[50px] text-[40px] md:leading-[50px] text-black pb-[15px] m-0">{{ get_field('title_1a') }}</h1>
        <article>
            <p class="font-primary text-[16px] md:text-[20px] text-black  m-0">{!! get_field('content_1a') !!}</p>
        </article>
    </section>
    <section class="container px-[15px] mx-auto">
        <h2 class="font-primary font-medium text-[30px] leading-[30px] text-black pb-[15px] m-0">{{ get_field('title_1b') }}</h2>
        <article>
            <p class="font-primary text-[16px] md:text-[20px] text-black  pb-[30px] m-0">{{ get_field('content_1b') }}</p>
        </article>
    </section>
    <section class="container pb-[50px] md:pb-[100px] px-[15px] mx-auto">
        <div class="grid grid-cols-12 gap-y-[50px] xl:gap-y-0 gap-x-0 xl:gap-x-[50px]">
            <div class="col-span-12 xl:col-span-5">
                <div id="contact-us"></div>
            </div>
            <div class="col-span-12 md:col-span-6 xl:col-span-4 flex flex-col justify-between">
                <div class="flex pb-[15px]">
                    <div class="w-[10%] h-[30px] mr-[15px]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-full h-full" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                        </svg>
                    </div>
                    <a href="tel:{{ str_replace(' ', '', get_field('company_phone', 'options')) }}" class="block w-[90%] font-primary no-underline text-[16px] md:text-[20px] text-black transition-all ease-in-our duration-300 hover:text-dml-blue-200">{{ get_field('company_phone', 'options') }}</a>
                </div>
                <div class="flex pb-[15px]">
                    <div class="w-[10%] h-[30px] mr-[15px]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-full h-full" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M14.243 5.757a6 6 0 10-.986 9.284 1 1 0 111.087 1.678A8 8 0 1118 10a3 3 0 01-4.8 2.401A4 4 0 1114 10a1 1 0 102 0c0-1.537-.586-3.07-1.757-4.243zM12 10a2 2 0 10-4 0 2 2 0 004 0z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <a href="mailto:{{ get_field('company_email', 'options') }}" class="block w-[90%] font-primary no-underline text-[16px] md:text-[20px] text-black transition-all ease-in-our duration-300 hover:text-dml-blue-200">{{ get_field('company_email', 'options') }}</a>
                </div>
                <div class="flex pb-[15px]">
                    <div class="w-[10%] h-[30px] mr-[15px]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="self-start w-full h-full" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="w-[90%] font-primary text-[16px] md:text-[20px] text-black">{!! get_field('company_address_long', 'options') !!}</div>
                </div>
                <div class="flex pb-[15px]">
                    <div class="w-[10%] h-[30px] mr-[15px]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-full h-full" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="w-[90%] font-primary text-[16px] md:text-[20px] text-black">{!! get_field('company_hours_weekdays', 'options') !!}</div>
                </div>
                <div class="flex pb-[15px]">
                    <div class="w-[10%] h-[30px] mr-[15px]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-full h-full" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="w-[90%] font-primary text-[16px] md:text-[20px] text-black">{!! get_field('company_hours_weekends', 'options') !!}</div>
                </div>
                <div class="flex pb-[15px]">
                    <div class="w-[10%] h-[30px] mr-[15px]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-full h-full" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="w-[90%] font-primary text-[16px] md:text-[20px] text-black">{!! get_field('company_hours_public_holidays', 'options') !!}</div>
                </div>
                <div class="flex pb-[15px]">
                    <div class="w-[10%] h-[30px] mr-[15px]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-full h-full" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.083 9h1.946c.089-1.546.383-2.97.837-4.118A6.004 6.004 0 004.083 9zM10 2a8 8 0 100 16 8 8 0 000-16zm0 2c-.076 0-.232.032-.465.262-.238.234-.497.623-.737 1.182-.389.907-.673 2.142-.766 3.556h3.936c-.093-1.414-.377-2.649-.766-3.556-.24-.56-.5-.948-.737-1.182C10.232 4.032 10.076 4 10 4zm3.971 5c-.089-1.546-.383-2.97-.837-4.118A6.004 6.004 0 0115.917 9h-1.946zm-2.003 2H8.032c.093 1.414.377 2.649.766 3.556.24.56.5.948.737 1.182.233.23.389.262.465.262.076 0 .232-.032.465-.262.238-.234.498-.623.737-1.182.389-.907.673-2.142.766-3.556zm1.166 4.118c.454-1.147.748-2.572.837-4.118h1.946a6.004 6.004 0 01-2.783 4.118zm-6.268 0C6.412 13.97 6.118 12.546 6.03 11H4.083a6.004 6.004 0 002.783 4.118z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <a href="{{ get_field('company_facebook', 'options') }}" class="block w-[90%] font-primary no-underline break-all text-[16px] md:text-[20px] text-black transition-all ease-in-our duration-300 hover:text-dml-blue-200">{{ get_field('company_facebook_label', 'options') }}</a>
                </div>
                <div class="flex pb-[15px]">
                    <div class="w-[10%] h-[30px] mr-[15px]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-full h-full" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.083 9h1.946c.089-1.546.383-2.97.837-4.118A6.004 6.004 0 004.083 9zM10 2a8 8 0 100 16 8 8 0 000-16zm0 2c-.076 0-.232.032-.465.262-.238.234-.497.623-.737 1.182-.389.907-.673 2.142-.766 3.556h3.936c-.093-1.414-.377-2.649-.766-3.556-.24-.56-.5-.948-.737-1.182C10.232 4.032 10.076 4 10 4zm3.971 5c-.089-1.546-.383-2.97-.837-4.118A6.004 6.004 0 0115.917 9h-1.946zm-2.003 2H8.032c.093 1.414.377 2.649.766 3.556.24.56.5.948.737 1.182.233.23.389.262.465.262.076 0 .232-.032.465-.262.238-.234.498-.623.737-1.182.389-.907.673-2.142.766-3.556zm1.166 4.118c.454-1.147.748-2.572.837-4.118h1.946a6.004 6.004 0 01-2.783 4.118zm-6.268 0C6.412 13.97 6.118 12.546 6.03 11H4.083a6.004 6.004 0 002.783 4.118z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <a href="{{ get_field('company_blog', 'options') }}" class="block w-[90%] font-primary no-underline break-all text-[16px] md:text-[20px] text-black transition-all ease-in-our duration-300 hover:text-dml-blue-200">{{ get_field('company_blog_label', 'options') }}</a>
                </div>
            </div>
            <div class="col-span-12 md:col-span-6 xl:col-span-3 flex items-center justify-center xl:items-end xl:justify-end">
                <img src="{{ get_field('image_1')['url'] }}" alt="{{ get_field('image_1')['alt'] }}" loading="lazy" class="object-contain object-center max-h-[300px]">
            </div>
        </div>
    </section>
@endsection
