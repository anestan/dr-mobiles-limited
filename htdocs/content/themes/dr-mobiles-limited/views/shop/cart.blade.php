@extends('layouts.main')

@section('content')
    <section class="container pt-[50px] px-[15px] mx-auto">
        @loop
        @template('parts.content', 'page')
        @if(comments_open() || get_comments_number())
            @php(comments_template('/views/comments/template.php'))
        @endif
        @endloop
    </section>
@endsection
