<img
    src="{{ $route }}"
    alt="Captcha image"
    style="cursor:pointer;width:{{ $width }}px;height:{{ $height }}px;display:block;object-fit:contain;"
    title="{{ $title }}"
    onclick="this.setAttribute('src','{{ $route }}?_='+Math.random());var captcha=document.getElementById('{{ $input_id }}');if(captcha){captcha.focus()}"
>
