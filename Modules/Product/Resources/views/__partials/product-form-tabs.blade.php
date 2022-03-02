<div class="ibox">
    <ul class="plain-nav-tabs nav nav-tabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link @if(request()->routeIs('product.*')) active @endif" href="{{ $updateMode ? route('product.edit', $product) : route('product.create') }}"><strong>General Information</strong></a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if(request()->routeIs('product-images.*')) active @endif" href="{{ $updateMode ? route('product-images.index', $product->id) : '#' }}"><strong>Images </strong></a>
        </li>
    </ul>
</div>