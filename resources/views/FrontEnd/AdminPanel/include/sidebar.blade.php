<div class="list-group rounded-0 border-0 text-center">
    <a href="{{ route('category.index') }}" class="list-group-item @if(request()->segment(1) == 'category') c_active @endif"> Category </a>
    <a href="{{ url('blog') }}" class="list-group-item @if(request()->segment(1) == 'blog') c_active @endif"> Blog </a>
    <a href="{{ url('mirror_link') }}" class="list-group-item @if(request()->segment(1) == 'mirror_link') c_active @endif"> Mirror Links </a>
    <a href="{{ url('user_list') }}" class="list-group-item @if(request()->segment(1) == 'user_list' || request()->segment(1) == 'user_filter' || request()->segment(1) == 'user_details') c_active @endif"> User </a>
    <a href="{{ url('admin_product_list') }}" class="list-group-item @if(request()->segment(1) == 'admin_product_list' || request()->segment(1) == 'admin_product_edit' || request()->segment(1) == 'admin_product_filter') c_active @endif"> Product </a>
    <a href="{{ url('orders') }}" class="list-group-item @if(request()->segment(1) == 'orders') c_active @endif"> Purchases </a>
    <a href="{{ url('administrator_log') }}" class="list-group-item @if(request()->segment(1) == 'administrator_log') c_active @endif"> Log </a>
    <a href="{{ url('support-panel') }}" class="list-group-item @if(request()->segment(1) == 'support-panel') c_active @endif"> Disputes </a>
    <a href="{{ url('support-ticket') }}" class="list-group-item @if(request()->segment(1) == 'support-ticket') c_active @endif"> Tickets </a>
    <a href="#" class="list-group-item "> Vendor Purchase </a>
</div>
