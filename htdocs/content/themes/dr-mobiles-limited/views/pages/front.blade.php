@extends('layouts.main')

@section('content')
    <section class="bg-cover bg-no-repeat bg-top h-[50vh] md:h-[70vh] relative" style="background-image:url({{ get_field('banner_1')['url'] }});">
        <div class="bg-dml-blue bg-opacity-[50%] absolute inset-0"></div>
        <div class="absolute top-[60%] left-0 right-0 transform translate-y-[-60%]">
            <div class="container px-[15px] mx-auto">
                <h1 class="font-primary text-[40px] md:text-[50px] leading-[40px] md:leading-[50px] text-white pb-[15px] m-0">{{ get_field('title_1') }}</h1>
                <p class="font-primary text-[16px] md:text-[20px] text-white m-0">{{ get_field('content_1') }}</p>
            </div>
        </div>
    </section>
    <section class="h-[50vh] mb-[50px] md:mb-[100px] relative">
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
        <div class="swiper-pagination absolute z-[10] bottom-0"></div>
    </section>
    <section class="container pb-[50px] md:pb-[100px] px-[15px] mx-auto">
        <h2 class="font-primary text-[30px] leading-[30px] text-black  pb-[15px] m-0">{{ get_field('title_2') }}</h2>
        <article>
            <p class="font-primary text-[16px] md:text-[20px] text-black  m-0">{!! get_field('content_2a') !!}
                <a href="{{ get_field('link_2b') }}" target="_blank" class="font-bold no-underline text-dml-blue transition-all ease-in-out duration-300 hover:text-dml-blue-200">{!! get_field('content_2b') !!}</a>
            </p>
        </article>
    </section>
    <section class="container pb-[50px] md:pb-[100px] px-[15px] mx-auto">
        <h2 class="font-primary text-[30px] leading-[30px] text-black  pb-[30px] m-0">{{ get_field('title_3') }}</h2>
        <div class="grid grid-cols-12 gap-y-[30px] md:gap-y-[50px] gap-x-[15px] md:gap-x-[50px]">
            @foreach(get_field('products_3') as $product)
                <div class="col-span-12 md:col-span-3 flex items-center justify-center md:justify-start">
                    <img src="{{ $product['image']['url'] }}" alt="{{ $product['image']['alt'] }}" loading="lazy" class="object-contain object-center max-h-[300px]">
                </div>
                <div class="col-span-12 md:col-span-9 flex flex-col items-center md:items-start justify-center">
                    <h3 class="font-primary font-medium text-[20px] md:text-[30px] leading-[20px] md:leading-[30px] text-black pb-[15px] m-0">{{ $product['title'] }}</h3>
                    <article>
                        <p class="font-primary text-[16px] md:text-[20px] text-black  m-0">{{ $product['content'] }}</p>
                    </article>
                </div>
            @endforeach
        </div>
    </section>
    <section class="pb-[50px] md:pb-[100px]">
        <div class="grid grid-cols-12">
            @foreach(get_field('products_4') as $product)
                <div class="col-span-4">
                    <img src="{{ $product['image']['url'] }}" alt="{{ $product['image']['alt'] }}" loading="lazy" class="object-cover object-center w-full h-full">
                </div>
            @endforeach
        </div>
    </section>
    <section class="container pb-[50px] md:pb-[100px] px-[15px] mx-auto">
        <div class="flex items-center justify-center">
            @foreach(get_field('products_5') as $product)
                <div class="col-span-4">
                    <img src="{{ $product['image']['url'] }}" alt="{{ $product['image']['alt'] }}" loading="lazy" class="object-contain object-center w-full pb-[30px] pr-[30px]">
                </div>
            @endforeach
        </div>
        <h2 class="font-primary text-[30px] leading-[30px] text-black  pb-[15px] m-0">{{ get_field('title_5') }}</h2>
        <article>
            <p class="font-primary text-[16px] md:text-[20px] text-black  m-0">{!! get_field('content_5') !!}</p>
        </article>
    </section>
@endsection
