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
        <div class="grid grid-cols-12">
            <div class="col-span-12 md:col-span-3 flex items-center justify-center md:justify-end order-2 md:order-1">
                <img src="{{ get_field('image_1')['url'] }}" alt="{{ get_field('image_1')['alt'] }}" loading="lazy" class="object-contain object-center max-h-[300px]">
            </div>
            <div class="col-span-12 md:col-span-9 order-1 md:order-2">
                <script src="https://drmobilesltd.repairdesk.co/widgets/include.js?token=571ef0123424b1461645330&height=300&width=100%&scrolling=no"></script>
            </div>
        </div>
    </section>
@endsection
