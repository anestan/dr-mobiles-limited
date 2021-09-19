@extends('layouts.main')

@section('content')
    <section class="container pt-[50px] px-[15px] mx-auto">
        @php(do_action('woocommerce_before_main_content'))
        @loop
        @php(do_action('woocommerce_before_single_product'))
        <div id="product-{{ Loop::id() }}" {{ wc_product_class() }}>
            @php(do_action('woocommerce_before_single_product_summary'))
            <div class="summary entry-summary">
                @php(do_action('woocommerce_single_product_summary'))
            </div>
            @php(do_action('woocommerce_after_single_product_summary'))
        </div>
        @php(do_action('woocommerce_after_single_product'))
        @endloop
        @php(do_action('woocommerce_after_main_content'))
    </section>
@endsection()
