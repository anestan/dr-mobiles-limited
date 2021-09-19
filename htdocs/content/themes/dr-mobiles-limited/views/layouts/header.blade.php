<header class="bg-white w-full transition-all ease-in-out duration-300 fixed z-[9998]" x-data="{ shrinkHeader: false,  showSideMenu : false }" x-bind:class="{ 'shadow-xl': shrinkHeader, 'shadow-md': !shrinkHeader }" x-on:scroll.window="shrinkHeader = window.scrollY > 0">
    <div class="flex justify-end bg-dml-blue">
        <a href="tel:{{ str_replace(' ', '', get_field('company_phone', 'options')) }}" class="inline-flex items-center font-primary no-underline text-[12px] text-white py-[5px] px-[15px] transition-all ease-in-out duration-300 hover:bg-dml-blue-200">
            <svg class="w-[20px] h-[20px]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path d="M17.924 2.617a.997.997 0 00-.215-.322l-.004-.004A.997.997 0 0017 2h-4a1 1 0 100 2h1.586l-3.293 3.293a1 1 0 001.414 1.414L16 5.414V7a1 1 0 102 0V3a.997.997 0 00-.076-.383z"/>
                <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
            </svg>
            <span class="hidden xl:inline xl:pl-[5px]">{{ get_field('company_phone', 'option') }}</span>
        </a>
        <a href="mailto:{{ get_field('company_email', 'option') }}" class="inline-flex items-center font-primary no-underline text-[12px] text-white py-[5px] px-[15px] transition-all ease-in-out duration-300 hover:bg-dml-blue-200">
            <svg class="w-[20px] h-[20px]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
            </svg>
            <span class="hidden xl:inline xl:pl-[5px]">{{ get_field('company_email', 'option') }}</span>
        </a>
        <a href="{{ get_permalink(get_page_by_title('Contact Us')) }}" class="inline-flex items-center font-primary no-underline text-[12px] text-white py-[5px] px-[15px] transition-all ease-in-out duration-300 hover:bg-dml-blue-200">
            <svg class="w-[20px] h-[20px]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
            </svg>
            <span class="hidden xl:inline xl:pl-[5px]">{{ get_field('company_address_short', 'option') }}</span>
        </a>
    </div>
    <nav class="flex items-center justify-between xl:items-stretch">
        <div class="flex items-center">
            {{ the_custom_logo() }}
            <a href="{{ home_url() }}" class="inline-flex items-center justify-start font-secondary font-extrabold italic no-underline text-dml-blue text-[18px] leading-[18px] xl:text-[30px] xl:leading-[30px] h-full pl-[15px] xl:pl-[30px]">
                {{ get_bloginfo( 'name' ) }}
            </a>
        </div>
        <ul class="hidden xl:flex list-none p-0 m-0">
            @foreach($menu_array as $menu_index => $menu_item)
                <li class="flex items-center relative" x-data="{ showSubMenu_{{ $menu_index }}: false }" x-on:mouseover="showSubMenu_{{ $menu_index }} = true" x-on:mouseover.away="showSubMenu_{{ $menu_index }} = false">
                    @if($loop->last)
                        <a href="{{ $menu_item['url'] }}" target="{{ $menu_item['target'] }}" class="inline-flex items-center justify-center font-secondary font-extrabold italic no-underline font-bold text-[16px] text-dml-blue text-center h-[80%] px-[15px] border-solid border-[1px] border-dml-blue rounded-[5px] mx-[30px] transition-all ease-in-out duration-300 hover:text-white hover:bg-dml-blue">{{ $menu_item['title'] }}</a>
                    @else
                        <a href="{{ $menu_item['url'] }}" target="{{ $menu_item['target'] }}" class="inline-flex items-center justify-center font-primary font-bold no-underline text-[16px] @if($menu_item['url'] == $current_url) text-dml-blue-200 @else text-dml-blue @endif text-center h-full px-[30px] transition-all ease-in-out duration-300 hover:text-white hover:bg-dml-blue">{{ $menu_item['title'] }}</a>
                    @endif
                    @if (isset($menu_item['children']))
                        <ul class="list-none flex flex-col p-0 m-0" x-cloak x-bind:class="showSubMenu_{{ $menu_index }} ? 'block w-full shadow-xl absolute top-full left-0' : 'hidden'">
                            @foreach($menu_item['children'] as $menu_index => $menu_item)
                                <li class="relative" x-data="{ showSubMenu_{{ $menu_index }}: false }" x-on:mouseover="showSubMenu_{{ $menu_index }} = true" x-on:mouseover.away="showSubMenu_{{ $menu_index }} = false">
                                    <a href="{{ $menu_item['url'] }}" target="{{ $menu_item['target'] }}" class="inline-flex items-center justify-center font-primary font-bold no-underline text-[16px] text-dml-blue bg-white w-full py-[30px] transition-all ease-in-out duration-300 hover:text-white hover:bg-dml-blue">{{ $menu_item['title'] }}</a>
                                    @if (isset($menu_item['children']))
                                        <ul class="list-none flex flex-col p-0 m-0" x-cloak x-bind:class="showSubMenu_{{ $menu_index }} ? 'block w-full shadow-xl absolute top-0 left-full' : 'hidden'">
                                            @foreach($menu_item['children'] as $menu_index => $menu_item)
                                                <li class="relative" x-data="{ showSubMenu_{{ $menu_index }}: false }" x-on:mouseover="showSubMenu_{{ $menu_index }} = true" x-on:mouseover.away="showSubMenu_{{ $menu_index }} = false">
                                                    <a href="{{ $menu_item['url'] }}" target="{{ $menu_item['target'] }}" class="inline-flex items-center justify-center font-primary font-bold no-underline text-[16px] text-dml-blue bg-white w-full py-[30px] transition-all ease-in-out duration-300 hover:text-white hover:bg-dml-blue">{{ $menu_item['title'] }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endforeach
        </ul>
        <svg xmlns="http://www.w3.org/2000/svg" class="inline-block xl:hidden cursor-pointer w-[50px] h-[50px] transition-all ease-in-out duration-300 hover:text-dml-blue-200" viewBox="0 0 20 20" fill="currentColor" x-bind:class="{ 'text-dml-blue-200': showSideMenu, 'text-dml-blue' : !showSideMenu }" x-on:click.stop="showSideMenu = true">
            <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM9 15a1 1 0 011-1h6a1 1 0 110 2h-6a1 1 0 01-1-1z" clip-rule="evenodd"/>
        </svg>
    </nav>
    <div x-cloak x-show="showSideMenu">
        <div class="flex fixed inset-0">
            <div class="cursor-pointer fixed inset-0"
                 x-show="showSideMenu"
                 x-on:click="showSideMenu = false"
                 x-transition:enter="transition-all ease-in-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-all ease-in-out duration-300"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0">
                <div class="bg-gray-500 bg-opacity-[75%] absolute inset-0"></div>
            </div>
            <div class="bg-dml-blue w-full max-w-xs py-[60px] relative overflow-auto"
                 x-show="showSideMenu"
                 x-transition:enter="transition ease-in-out duration-300 transform"
                 x-transition:enter-start="-translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transition ease-in-out duration-300 transform"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="-translate-x-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="cursor-pointer text-white w-[50px] h-[50px] transition-all ease-in-out duration-300 hover:text-dml-blue-200 absolute top-[5px] right-[5px] hover:text-blue-dml-50" viewBox="0 0 20 20" fill="currentColor" x-on:click.stop="showSideMenu = false">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                </svg>
                <ul class="list-none p-0 m-0">
                    @foreach($menu_array as $menu_index => $menu_item)
                        <li>
                            @if($loop->last)
                                <a href="{{ $menu_item['url'] }}" class="inline-block font-secondary font-extrabold italic no-underline font-bold text-[16px] text-white py-[15px] px-[15px] border-solid border-[1px] border-white rounded-[5px] my-[15px] mx-[30px] transition-all ease-in-out duration-300 hover:bg-dml-blue-200">{{ $menu_item['title'] }}</a>
                            @else
                                <a href="{{ $menu_item['url'] }}" class="flex items-center justify-start font-primary font-bold no-underline text-[16px] @if($menu_item['url'] == $current_url) text-dml-blue-50 @else text-white @endif py-[15px] px-[30px] transition-all ease-in-out duration-300 hover:text-dml-blue hover:bg-white">{{ $menu_item['title'] }}</a>
                            @endif
                            @if (isset($menu_item['children']))
                                <ul class="list-none p-0 m-0">
                                    @foreach($menu_item['children'] as $menu_index => $menu_item)
                                        <li>
                                            <a href="{{ $menu_item['url'] }}" class="flex items-center justify-start font-primary font-bold no-underline text-[16px] @if($menu_item['url'] == $current_url) text-dml-blue-50 @else text-white @endif py-[15px] px-[60px] transition-all ease-in-out duration-300 hover:text-dml-blue hover:bg-white">{{ $menu_item['title'] }}</a>
                                            @if (isset($menu_item['children']))
                                                <ul class="list-none p-0 m-0">
                                                    @foreach($menu_item['children'] as $menu_index => $menu_item)
                                                        <li>
                                                            <a href="{{ $menu_item['url'] }}" class="flex items-center justify-start font-primary font-bold no-underline text-[16px] @if($menu_item['url'] == $current_url) text-dml-blue-50 @else text-white @endif py-[15px] px-[90px] transition-all ease-in-out duration-300 hover:text-dml-blue hover:bg-white">{{ $menu_item['title'] }}</a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</header>
<div class="pb-[90px]"></div>
