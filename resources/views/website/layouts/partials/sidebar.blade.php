@php
    $currentRouteName = \Illuminate\Support\Facades\Route::currentRouteName();
@endphp
<div class="col-md-3 left_col">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a href="/" class="site_title">
                <i class="fa fa-thumbs-o-up"></i>
                <span> Autolike Website</span>
            </a>
        </div>
        <div class="clearfix"></div>
        <div class="profile clearfix"><!--img_2 -->
            <div class="profile_pic">
                <img src="{{ config('app.asset_url') }}/images/circled-user-male-skin-type-1-2.png" alt="..." class="img-circle profile_img">
            </div>
            <div class="profile_info">
                <span>Xin chào, </span>
                <h2>{{ session('dataLogin') ? session('dataLogin')['fullname'] : '' }}</h2>
            </div>
        </div>
        <br>
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section active">
                <h3>Chức năng</h3>
                <ul class="nav side-menu">
                    <li>
                        <a href="{{ route('website.home.index') }}"><i class="fa fa-home"></i> Trang chủ </a>
                    </li>

                    @if(session('dataLogin')['invite_code'])
                        <li>
                            <a>
                                <i class="fa fa-table"></i> Danh sách cộng tác viên
                            </a>
                            <ul class="nav child_menu">
                                <li><a href="{{ route('website.user.index') }}">CTV / User</a></li>
                                <li><a href="{{ route('website.service.history') }}">Lịch sử sử dụng</a></li>
                                <li><a href="{{ route('website.service.report') }}">Lịch sử giao dịch</a></li>
                            </ul>
                        </li>
                    @endif

                    <li>
                        <a href="{{ route('website.user.profile') }}"><i class="fa fa-user"></i> Profile </a>
                    </li>

                    <li>
                        <a href="{{ route('website.service.money') }}"><i class="fa fa-money"></i> Nạp tiền</a>
                    </li>

                    <li>
                        <a href="{{ route('website.service.buyService') }}"><i class="fa fa-shopping-cart"></i>Mua dịch vụ</a>
                    </li>

                    <li>
                        <a href="{{ route('website.service.index') }}"><i class="fa fa-xing"></i> Dịch vụ viplike</a>
                    </li>

                    <li>
                        <a href="{{ route('website.service.indexType', ['type' => 'addfriend']) }}"><i class="fa fa-xing"></i> Dịch vụ Sub / Follow</a>
                    </li>

                    <li>
                        <a href="{{ route('website.service.indexType', ['type' => 'likepage']) }}"><i class="fa fa-xing"></i> Dịch vụ Like Fanpage</a>
                    </li>

                    <li>
                        <a href="{{ route('website.transaction.index') }}"><i class="fa fa-money"></i> Lịch sử giao dịch </a>
                    </li>

                    @if(session('dataLogin')['invite_code'])
                    <li>
                        <a>
                            <i class="fa fa-table"></i> Gift code <span class="fa fa-chevron-down"></span>
                        </a>
                        <ul class="nav child_menu">
                            <li><a href="{{ route('website.gift-code.using') }}">Sử dụng gift code</a></li>
                            <li><a href="{{ route('website.gift-code.index') }}">Danh sách</a></li>
                            <li><a href="{{ route('website.gift-code.history') }}">Lịch sử sử dụng</a></li>
                            <li><a href="{{ route('website.gift-code.create') }}">Tạo mới gift code</a></li>
                        </ul>
                    </li>
                    @else
                        <li>
                            <a href="{{ route('website.gift-code.using') }}"><i class="fa fa-gift"></i> Gift Code </a>
                        </li>
                    @endif
                    <li>
                        <a href="https://www.vultr.com/resources/faq/" target="_blank"><i class="fa fa-question-circle"></i> Hỗ trợ </a>
                    </li>
                    {{--<li class="@if(strpos($currentRouteName, 'website.transaction') === 0) active @endif ">--}}
                        {{--<a href="{{ route('website.transaction.index') }}"><i class="fa fa-money"></i> Lịch sử </a>--}}
                    {{--</li>--}}
                </ul>
            </div>
        </div>
    </div>
</div>