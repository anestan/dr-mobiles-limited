<div class="fixed z-[9998] right-0 transition-all ease-in-out duration-300" x-data="{ showScrollToTop: false }" x-bind:class="{ 'bottom-[-100%]': !showScrollToTop, 'bottom-[45px]': showScrollToTop }" x-on:scroll.window="showScrollToTop = window.scrollY > 0">
    <div class="inline-block cursor-pointer text-white bg-dml-blue w-[50px] h-[50px] p-[5px] rounded-full m-[15px] shadow-md transition-all ease-in-out duration-300 hover:bg-dml-blue-200 hover:shadow-xl" x-bind:class="{'opacity-0': !showScrollToTop, 'opacity-100': showScrollToTop}" x-on:click="window.scrollTo(0, 0)">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-full h-full" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd"/>
        </svg>
    </div>
</div>
<div class="container px-[15px] mx-auto flex items-center justify-center flex-wrap">
    <img class="object-contain object-center pb-[30px] pr-[30px]" style="cursor: pointer;" id="seal_2_certificate_image" src="https://www.crazydomains.co.nz/certification/seal/2/7d9696e2ff6346c19d2ad7c514de4fe01622857285/" onclick="if (document.getElementById('seal_2_certificate').style.display == 'none') document.getElementById('seal_2_certificate').style.display = ''; else document.getElementById('seal_2_certificate').style.display = 'none';"><div style="display:none;position: fixed; top: 50%; left: 50%; margin-left: -303px; margin-top: -313px;" id="seal_2_certificate"><a href="javascript:void(0);" onclick="javascript:document.getElementById('seal_2_certificate').style.display = 'none';" style=" font-size: 13px !important; top: -25px;  right: 607px; color: #484848;  opacity: 0.8;  float: right; font-weight: bold; position: relative;  line-height: 20px;  font-family: Verdana, Arial, sans-serif;" class="close">[×] close</a><iframe style="height:626px; width:607px; 690px; border: none; background: white; box-shadow: 0 0 20px rgba(0, 0, 0, 0.2); border-radius: 6px;" scrolling="no" src="https://www.crazydomains.co.nz/certification/certificate/?token=7d9696e2ff6346c19d2ad7c514de4fe01622857285"></iframe></div>
    <img class="object-contain object-center pb-[30px] pr-[30px]" src="//www.mysecuressls.com/images/seals/crazy_secure_01.png" border="0">
</div>
<footer class="text-left md:text-center px-[5px] py-[5px]">
    <a href="{{ home_url() }}" class="font-primary font-bold no-underline text-[16px] text-dml-blue transition-all ease-in-out duration-300 hover:text-dml-blue-200">{!! get_field('footer_copyright', 'options') !!}</a>
</footer>
