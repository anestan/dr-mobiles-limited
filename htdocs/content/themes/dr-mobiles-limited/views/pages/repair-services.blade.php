@extends('layouts.main')

@section('content')
    <section class="bg-cover bg-no-repeat bg-top h-[50vh] relative mb-[50px] md:mb-[100px]" style="background-image:url({{ get_field('banner_1')['url'] }});">
        <div class="bg-dml-blue bg-opacity-[50%] absolute inset-0"></div>
        <div class="absolute top-[60%] left-0 right-0 transform translate-y-[-60%]">
            <div class="container px-[15px] mx-auto">
                <h1 class="font-primary text-[40px] md:text-[50px] leading-[40px] md:leading-[50px] text-white pb-[15px] m-0">{{ get_field('title_1') }}</h1>
                <p class="font-primary text-[16px] md:text-[20px] text-white m-0">{{ get_field('content_1') }}</p>
            </div>
        </div>
    </section>
    <section class="container pb-[50px] md:pb-[100px] px-[15px] mx-auto">
        <h2 class="font-primary text-[30px] leading-[30px] text-black  pb-[15px] m-0">{{ get_field('title_3') }}</h2>
        <article>
            <p class="font-primary text-[16px] md:text-[20px] text-black  m-0">{!! get_field('content_3') !!}</p>
        </article>
    </section>
    <section class="container pb-[30px] md:pb-[50px] px-[15px] mx-auto">
        <h2 class="font-primary text-[30px] leading-[30px] text-black  pb-[15px] m-0">{{ get_field('title_2') }}</h2>
        <article>
            <p class="font-primary text-[16px] md:text-[20px] text-black  m-0">{!! get_field('content_2') !!}</p>
        </article>
    </section>
    <section class="container pb-[50px] md:pb-[100px] px-[15px] mx-auto">
        @foreach(get_field('products_2') as $product)
            <h3 class="font-primary font-medium text-[20px] md:text-[30px] leading-[20px] md:leading-[30px] text-black  pb-[15px] m-0">{{ $product['title'] }}</h3>
            <div class="grid grid-cols-12 gap-[15px] pb-[30px] md:pb-[50px]">
                @foreach($product['services'] as $service)
                    <div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-3 flex">
                        <div class="w-[10%] h-[30px] mr-[5px]">
                            <svg class="text-green-500 w-full h-full" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="w-[90%] font-primary text-[16px] md:text-[20px] text-black m-0">{{ $service['name'] }}</div>
                    </div>
                @endforeach
            </div>
        @endforeach
        <div class="flex justify-center">
            <img src="{{ get_field('image_2')['url'] }}" alt="{{ get_field('image_2')['alt'] }}" loading="lazy" class="object-contain object-center max-h-[300px]">
        </div>
    </section>
@endsection
